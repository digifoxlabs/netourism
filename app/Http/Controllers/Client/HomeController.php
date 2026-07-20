<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Event;
use App\Models\HomePageSlide;
use App\Models\PackageCategory;
use App\Models\SiteSetting;
use App\Models\FormSubmission;
use App\Models\Payment;
use Illuminate\Support\Facades\Schema;
use App\Services\EmailTemplateService;
use App\Mail\GenericSubmissionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Client\BookingPaymentController;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HomePageSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $activeEvents = Event::where('status', 'active')
            ->orderBy('start_date')
            ->get();

        $upcomingEvents = Event::where('status', 'upcoming')
            ->orderBy('start_date')
            ->get();

        $homeSectionSettings = SiteSetting::getSettings(SiteSetting::HOME_SECTION_DEFAULTS);
        if (Schema::hasTable('package_categories') && Schema::hasColumn('packages', 'category_id')) {
            $defaultCategory = PackageCategory::defaultCategory();

            $packageCategories = PackageCategory::query()
                ->with(['packages' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('created_at', 'desc');
                }])
                ->whereHas('packages', function ($query) {
                    $query->where('is_active', true);
                })
                ->orderByRaw("CASE WHEN id = ? THEN 0 ELSE 1 END", [$defaultCategory->id])
                ->orderBy('name')
                ->get();
        } else {
            $packageCategories = collect([
                (object) [
                    'name' => 'Packages',
                    'slug' => 'packages',
                    'packages' => Package::query()
                        ->where('is_active', true)
                        ->orderBy('created_at', 'desc')
                        ->take(9)
                        ->get(),
                ],
            ]);
        }

        return view('client.home', compact('heroSlides', 'activeEvents', 'upcomingEvents', 'homeSectionSettings', 'packageCategories'));
    }


    public function packages()
    {
        $packages = Package::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);



        return view('client.packages.index', compact('packages'));
    }

    // public function show(Package $package)
    // {
    //     abort_unless($package->is_active, 404);

    //     $package->load(['gallery', 'form.fields']);

    //     $sections = null;

    //     if ($package->form) {
    //         $sections = $package->form->fields
    //             ->sortBy('sort_order')
    //             ->groupBy(fn ($f) => $f->section_title ?: 'Form');
    //     }

    //     return view('client.packages.show', compact('package', 'sections'));
    // }

    public function show(Package $package)
{
    $form = null;
    $sections = collect();

    if ($package->form_id) {
        $form = $package->form()
            ->where('is_active', true)
            ->first();

        if ($form) {
            $sections = $form->fields()
                ->orderBy('sort_order')
                ->get()
                ->groupBy(fn ($f) => $f->section_title ?: 'Form');
        }
    }

    return view('client.packages.show', compact(
        'package',
        'form',
        'sections'
    ));
}

public function submitPackage(Request $request, Package $package)
{
    abort_unless($package->is_active, 404);

    $form = $package->form()->where('is_active', true)->firstOrFail();
    $fields = $form->fields()->orderBy('sort_order')->get();

    $rules = [];
    $labels = [];

    foreach ($fields as $field) {
        $rule = $field->required ? ['required'] : ['nullable'];

        if ($field->type === 'email') $rule[] = 'email';
        if ($field->type === 'number') $rule[] = 'numeric';
        if ($field->type === 'date') $rule[] = 'date';

        $rules[$field->name] = implode('|', $rule);
        $labels[$field->name] = $field->label;
    }

    $validated = $request->validate($rules, [], $labels);

    $submission = FormSubmission::create([
        'form_id' => $form->id,
        'package_id' => $package->id,
        'data' => $validated,
        'status' => $package->payment_required ? 'payment_pending' : 'confirmed',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    $payment = null;
    $paymentOptions = BookingPaymentController::optionsFor($package);
    if ($package->payment_required && count($paymentOptions) === 1) {
        $payment = BookingPaymentController::createPaymentFromOption($submission, $paymentOptions[0]);
    }

    if ($form->auto_email_confirmation && $form->confirmation_email_template) {
        $userEmail = $this->findFieldValue($submission->data, ['email', 'mail']);

        if ($userEmail && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $subject = EmailTemplateService::render(
                $form->confirmation_email_subject ?: 'Form Submitted',
                $submission
            );

            $body = EmailTemplateService::render($form->confirmation_email_template, $submission);

            if ($payment && !str_contains($body, route('payments.show', $payment))) {
                $body .= "\n\nPayment amount: Rs. " . number_format((float) $payment->amount, 2);
                $body .= "\nPayment status: " . ucfirst($payment->status);
                $body .= "\nPayment link: " . route('payments.show', $payment);
            } elseif (count($paymentOptions) > 1 && !str_contains($body, route('booking-payments.options', $submission))) {
                $body .= "\n\nChoose payment option: " . route('booking-payments.options', $submission);
            }

            try {
                Mail::to($userEmail)
                    ->bcc(config('mail.admin_email'))
                    ->send(new GenericSubmissionMail($subject, nl2br($body)));
            } catch (\Throwable $e) {
                Log::warning('Package auto-confirmation email failed.', [
                    'submission_id' => $submission->id,
                    'package_id' => $package->id,
                    'email' => $userEmail,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    if ($payment) {
        return redirect()->route('payments.show', $payment);
    }

    if ($package->payment_required && count($paymentOptions) > 1) {
        return redirect()->route('booking-payments.options', $submission);
    }

    return back()->with('success', $form->success_message ?: 'Thank you. Your submission has been received.');
}

private function createPaymentForSubmission(FormSubmission $submission, float $amount, string $productInfo, array $data, array $extra = []): Payment
{
    $email = $this->findFieldValue($data, ['email', 'mail']);
    $phone = $this->findFieldValue($data, ['phone', 'mobile', 'contact']);
    $name = $this->findFieldValue($data, ['name', 'full_name', 'firstname']) ?: 'Guest';

    return Payment::create(array_merge([
        'form_submission_id' => $submission->id,
        'txnid' => 'NET' . Str::upper(Str::random(24)),
        'status' => Payment::STATUS_PENDING,
        'amount' => $amount,
        'productinfo' => $productInfo,
        'firstname' => $name,
        'email' => $email,
        'phone' => $phone,
        'expires_at' => now()->addMinutes(30),
    ], $extra));
}

private function findFieldValue(array $data, array $needles): ?string
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            continue;
        }

        $normalized = strtolower((string) $key);
        foreach ($needles as $needle) {
            if (str_contains($normalized, $needle) && filled($value)) {
                return (string) $value;
            }
        }
    }

    return null;
}





}
