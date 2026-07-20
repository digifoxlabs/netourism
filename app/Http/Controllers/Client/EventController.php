<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\FormSubmission;
use Illuminate\Support\Carbon;
use App\Support\FormAutoEmailService;
use App\Services\EmailTemplateService;
use App\Mail\GenericSubmissionMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Client\BookingPaymentController;

class EventController extends Controller
{
    public function show($slug)
        {
        $event = Event::where('slug', $slug)->firstOrFail();

        // Optional: block expired events completely
        // if ($event->status === 'expired') {
        //     abort(404);
        // }

        $form = null;
        $sections = collect();

        // Only load form if event is active
        if ($event->status === 'active' && $event->form) {
            $form = $event->form;

            $fields = $form->fields()
                ->orderBy('sort_order')
                ->get();

            $sections = $fields->groupBy(fn ($f) => $f->section_title ?: 'Form');
        }

        return view('client.events.show', compact('event', 'form', 'sections'));
    }

public function submit(Request $request, $slug)
{
    $event = Event::where('slug', $slug)
        ->where('status', 'active')
        ->firstOrFail();

    $form = $event->form;

    if (!$form) {
        abort(404, 'Event form not found.');
    }

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
        'form_id'    => $form->id,
        'event_id'   => $event->id,
        'data'       => $validated,
        'status'     => $event->payment_required ? 'payment_pending' : 'pending',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    $payment = null;
    $paymentOptions = BookingPaymentController::optionsFor($event);
    if ($event->payment_required && count($paymentOptions) === 1) {
        $payment = BookingPaymentController::createPaymentFromOption($submission, $paymentOptions[0]);
    }

    // 🔥 AUTO EMAIL (FORM LEVEL — ALWAYS)
   // FormAutoEmailService::sendIfEnabled($form, $validated);


       if ($form->auto_email_confirmation && $form->confirmation_email_template) {

        // Detect user email dynamically
        $userEmail = null;
        foreach ($submission->data as $key => $value) {
            if (
                str_contains(strtolower($key), 'email') &&
                filter_var($value, FILTER_VALIDATE_EMAIL)
            ) {
                $userEmail = $value;
                break;
            }
        }

        if ($userEmail) {
            
            $subject = EmailTemplateService::render(
                $form->confirmation_email_subject ?: 'Form Submitted',
                $submission
            );

            $body = EmailTemplateService::render(
                $form->confirmation_email_template,
                $submission
            );

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
                Log::warning('Event auto-confirmation email failed.', [
                    'submission_id' => $submission->id,
                    'event_id' => $event->id,
                    'email' => $userEmail,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    if ($payment) {
        return redirect()->route('payments.show', $payment);
    }

    if ($event->payment_required && count($paymentOptions) > 1) {
        return redirect()->route('booking-payments.options', $submission);
    }

    return back()->with(
        'success',
        $form->success_message ?: 'Your registration has been received.'
    );
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






    public function index(Request $request)
    {
        // load all events that are either active or have dates; adjust as required
        $events = Event::with('form')
            ->orderByDesc('start_date')
            ->get();

        // compute status for each event if not available on model
        $events->transform(function ($event) {
            // if model has status attribute / column and it's set, use it
            if (isset($event->status) && $event->status) {
                $status = strtolower($event->status);
            } else {
                $today = Carbon::now()->startOfDay();

                // expired/past if end_date exists and is before today
                if ($event->end_date && Carbon::parse($event->end_date)->endOfDay()->lt($today)) {
                    $status = 'expired';
                }
                // upcoming if start_date exists and is in future
                elseif ($event->start_date && Carbon::parse($event->start_date)->startOfDay()->gt($today)) {
                    $status = 'upcoming';
                }
                // otherwise active (running / registration open)
                else {
                    $status = ($event->is_active ?? true) ? 'active' : 'inactive';
                }
            }

            // attach computed status for the view
            $event->computed_status = $status;

            return $event;
        });

        // Group into collections for display. Order upcoming ascending (nearest first), active by start_date desc, past by end_date desc
        $active = $events->where('computed_status', 'active')->sortByDesc(function ($e) {
            return $e->start_date ? Carbon::parse($e->start_date)->timestamp : 0;
        })->values();

        $upcoming = $events->where('computed_status', 'upcoming')->sortBy(function ($e) {
            return $e->start_date ? Carbon::parse($e->start_date)->timestamp : PHP_INT_MAX;
        })->values();

        $past = $events->whereIn('computed_status', ['expired', 'completed'])->sortByDesc(function ($e) {
            return $e->end_date ? Carbon::parse($e->end_date)->timestamp : 0;
        })->values();

        // If you prefer pagination instead of returning full collections, uncomment and adapt:
        // $perPage = 9;
        // $active = $this->paginateCollection($active, $perPage, 'active');
        // $upcoming = $this->paginateCollection($upcoming, $perPage, 'upcoming');
        // $past = $this->paginateCollection($past, $perPage, 'past');

        return view('client.events.index', compact('active', 'upcoming', 'past'));
    }

    /**
     * Helper to paginate a Collection (optional).
     * Usage: $paginated = $this->paginateCollection($collection, 12, 'page_param_name');
     */
    protected function paginateCollection($collection, $perPage = 12, $pageName = 'page', $requestPage = null)
    {
        $page = $requestPage ?? request($pageName, 1);
        $offset = ($page - 1) * $perPage;
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->slice($offset, $perPage)->values(),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
