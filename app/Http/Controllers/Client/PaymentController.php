<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PayuPaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Payment $payment)
    {
        $this->cancelIfExpired($payment);

        $payment->load(['event', 'package', 'submission.form']);

        return view('client.payments.show', compact('payment'));
    }

    public function checkout(Payment $payment, PayuPaymentService $payu)
    {
        $this->cancelIfExpired($payment);

        if ($payment->status !== Payment::STATUS_PENDING) {
            return redirect()->route('payments.show', $payment);
        }

        $settings = $payu->settings();
        if (!$settings->isReady()) {
            return redirect()
                ->route('payments.show', $payment)
                ->with('error', 'Online payment is not available right now. Please contact support.');
        }

        $params = $payu->createCheckoutPayload($payment);
        $payment->update(['gateway_request' => $params]);

        return view('client.payments.checkout', [
            'payment' => $payment,
            'gatewayUrl' => $settings->checkoutUrl(),
            'params' => $params,
        ]);
    }

    public function success(Request $request, Payment $payment, PayuPaymentService $payu)
    {
        $payload = $request->all();
        $valid = $payu->responseHashIsValid($payload, $payment);
        $status = strtolower($payload['status'] ?? '');

        if ($valid && $status === 'success') {
            $payment->update([
                'status' => Payment::STATUS_PAID,
                'payu_status' => $payload['status'] ?? null,
                'payu_payment_id' => $payload['mihpayid'] ?? null,
                'gateway_response' => $payload,
                'paid_at' => now(),
            ]);

            optional($payment->submission)->update(['status' => 'confirmed']);

            return redirect()->route('payments.show', $payment)->with('success', 'Payment completed successfully.');
        }

        return $this->markFailed($payment, $payload, 'We could not verify the payment response.');
    }

    public function failure(Request $request, Payment $payment)
    {
        return $this->markFailed($payment, $request->all(), 'Payment failed or was cancelled at PayU.');
    }

    public function cancel(Payment $payment)
    {
        if ($payment->status === Payment::STATUS_PENDING) {
            $payment->update([
                'status' => Payment::STATUS_CANCELLED,
                'cancelled_at' => now(),
            ]);
        }

        return redirect()->route('payments.show', $payment)->with('success', 'Payment has been cancelled.');
    }

    private function cancelIfExpired(Payment $payment): void
    {
        if ($payment->isExpiredPending()) {
            $payment->update([
                'status' => Payment::STATUS_CANCELLED,
                'cancelled_at' => now(),
            ]);
        }
    }

    private function markFailed(Payment $payment, array $payload, string $message)
    {
        $payment->update([
            'status' => Payment::STATUS_FAILED,
            'payu_status' => $payload['status'] ?? null,
            'payu_payment_id' => $payload['mihpayid'] ?? null,
            'gateway_response' => $payload,
            'failed_at' => now(),
        ]);

        return redirect()->route('payments.show', $payment)->with('error', $message);
    }
}
