<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PaymentSetting;
use Illuminate\Support\Str;

class PayuPaymentService
{
    public function settings(): PaymentSetting
    {
        return PaymentSetting::current();
    }

    public function createCheckoutPayload(Payment $payment): array
    {
        $settings = $this->settings();
        $params = [
            'key' => $settings->merchant_key,
            'txnid' => $payment->txnid,
            'amount' => number_format((float) $payment->amount, 2, '.', ''),
            'productinfo' => Str::limit($payment->productinfo, 100, ''),
            'firstname' => $payment->firstname ?: 'Guest',
            'email' => $payment->email ?: config('mail.from.address'),
            'phone' => $payment->phone ?: '9999999999',
            'surl' => route('payments.success', $payment),
            'furl' => route('payments.failure', $payment),
            'udf1' => (string) $payment->id,
            'udf2' => $payment->event_id ? 'event' : ($payment->package_id ? 'package' : 'form'),
            'udf3' => (string) ($payment->event_id ?: $payment->package_id ?: ''),
            'udf4' => '',
            'udf5' => '',
        ];

        $params['hash'] = $this->paymentHash($params, $settings->merchant_salt);

        return $params;
    }

    public function paymentHash(array $params, string $salt): string
    {
        $sequence = [
            $params['key'] ?? '',
            $params['txnid'] ?? '',
            $params['amount'] ?? '',
            $params['productinfo'] ?? '',
            $params['firstname'] ?? '',
            $params['email'] ?? '',
            $params['udf1'] ?? '',
            $params['udf2'] ?? '',
            $params['udf3'] ?? '',
            $params['udf4'] ?? '',
            $params['udf5'] ?? '',
            '',
            '',
            '',
            '',
            '',
            $salt,
        ];

        return hash('sha512', implode('|', $sequence));
    }

    public function responseHashIsValid(array $payload, Payment $payment): bool
    {
        $settings = $this->settings();
        if (blank($settings->merchant_salt) || blank($payload['hash'] ?? null)) {
            return false;
        }

        $sequence = [
            $settings->merchant_salt,
            $payload['status'] ?? '',
            '',
            '',
            '',
            '',
            '',
            $payload['udf5'] ?? '',
            $payload['udf4'] ?? '',
            $payload['udf3'] ?? '',
            $payload['udf2'] ?? '',
            $payload['udf1'] ?? '',
            $payload['email'] ?? $payment->email,
            $payload['firstname'] ?? $payment->firstname,
            $payload['productinfo'] ?? $payment->productinfo,
            $payload['amount'] ?? number_format((float) $payment->amount, 2, '.', ''),
            $payload['txnid'] ?? $payment->txnid,
            $settings->merchant_key,
        ];

        if (isset($payload['additionalCharges'])) {
            array_unshift($sequence, $payload['additionalCharges']);
        }

        return hash_equals(hash('sha512', implode('|', $sequence)), $payload['hash']);
    }

    public function altIdHeaders(array $body): array
    {
        $settings = $this->settings();
        $json = json_encode($body, JSON_UNESCAPED_SLASHES);
        $date = gmdate('D, d M Y H:i:s') . ' GMT';
        $digest = base64_encode(hash('sha256', $json, true));
        $signingString = "date: {$date}\ndigest: {$digest}";
        $signature = base64_encode(hash_hmac('sha256', $signingString, (string) $settings->merchant_salt, true));

        return [
            'Content-Type' => 'application/json',
            'date' => $date,
            'digest' => $digest,
            'authorization' => 'hmac username="' . $settings->merchant_key . '", algorithm="hmac-sha256", headers="date digest", signature="' . $signature . '"',
            'platformId' => '1',
        ];
    }
}
