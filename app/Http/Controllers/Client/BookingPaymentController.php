<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingPaymentController extends Controller
{
    public function options(FormSubmission $submission)
    {
        $submission->load(['event', 'package']);
        $options = $this->paymentOptions($submission);

        abort_unless(count($options) > 1, 404);

        return view('client.payments.options', compact('submission', 'options'));
    }

    public function choose(Request $request, FormSubmission $submission)
    {
        $submission->load(['event', 'package']);
        $options = $this->paymentOptions($submission);

        abort_unless(count($options) > 1, 404);

        $validated = $request->validate([
            'payment_option' => ['required', 'integer', 'min:0'],
        ]);

        $option = $options[$validated['payment_option']] ?? null;
        abort_unless($option, 404);

        $payment = $this->createPaymentFromOption($submission, $option);

        return redirect()->route('payments.show', $payment);
    }

    public static function optionsFor($bookable): array
    {
        if (!$bookable || !$bookable->payment_required) {
            return [];
        }

        $options = collect($bookable->payment_options ?? [])
            ->map(fn ($option) => [
                'label' => trim((string) ($option['label'] ?? '')),
                'description' => trim((string) ($option['description'] ?? '')),
                'amount' => (float) ($option['amount'] ?? 0),
                'type' => in_array(($option['type'] ?? 'full'), ['partial', 'full', 'pay_later'])
                    ? $option['type']
                    : 'full',
            ])
            ->filter(fn ($option) => $option['label'] !== '' && ($option['type'] === 'pay_later' || $option['amount'] > 0))
            ->values()
            ->all();

        if (!$options && (float) $bookable->payment_amount > 0) {
            $options[] = [
                'label' => 'Full payment',
                'description' => '',
                'amount' => (float) $bookable->payment_amount,
                'type' => 'full',
            ];
        }

        return $options;
    }

    public static function createPaymentFromOption(FormSubmission $submission, array $option): Payment
    {
        $submission->loadMissing(['event', 'package']);
        $data = $submission->data ?? [];
        $bookable = $submission->event ?: $submission->package;
        $productInfo = $submission->event ? $submission->event->title : optional($submission->package)->name;
        $paymentType = $option['type'] ?? 'full';

        $payment = Payment::create([
            'form_submission_id' => $submission->id,
            'event_id' => $submission->event_id,
            'package_id' => $submission->package_id,
            'txnid' => 'NET' . Str::upper(Str::random(24)),
            'status' => $paymentType === 'pay_later' ? Payment::STATUS_PAY_LATER : Payment::STATUS_PENDING,
            'amount' => (float) ($option['amount'] ?? 0),
            'productinfo' => $productInfo ?: 'Booking',
            'payment_label' => $option['label'] ?? null,
            'payment_type' => $paymentType,
            'payment_description' => $option['description'] ?? null,
            'firstname' => self::findFieldValue($data, ['name', 'full_name', 'firstname']) ?: 'Guest',
            'email' => self::findFieldValue($data, ['email', 'mail']),
            'phone' => self::findFieldValue($data, ['phone', 'mobile', 'contact']),
            'expires_at' => $paymentType === 'pay_later' ? null : now()->addMinutes(30),
        ]);

        $submission->update([
            'status' => $paymentType === 'pay_later' ? 'pay_later' : 'payment_pending',
        ]);

        return $payment;
    }

    private function paymentOptions(FormSubmission $submission): array
    {
        return self::optionsFor($submission->event ?: $submission->package);
    }

    private static function findFieldValue(array $data, array $needles): ?string
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
