<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['event', 'package', 'submission'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(20)->withQueryString();

        $stats = [
            'today' => Payment::whereDate('created_at', today())->sum('amount'),
            'pending' => Payment::where('status', Payment::STATUS_PENDING)->count(),
            'failed' => Payment::where('status', Payment::STATUS_FAILED)->count(),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function settings()
    {
        $settings = PaymentSetting::current();

        return view('admin.payments.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'environment' => ['required', 'in:demo,live'],
            'demo_url' => ['required', 'url'],
            'live_url' => ['required', 'url'],
            'alt_id_demo_url' => ['required', 'url'],
            'alt_id_live_url' => ['required', 'url'],
            'merchant_key' => ['nullable', 'string', 'max:255'],
            'merchant_salt' => ['nullable', 'string'],
        ]);

        $data['enabled'] = $request->boolean('enabled');

        PaymentSetting::current()->update($data);

        return redirect()->route('admin.payments.settings')->with('success', 'Payment settings updated.');
    }

    public function reports()
    {
        $paid = Payment::where('status', Payment::STATUS_PAID);

        $paymentsToday = (clone $paid)->whereDate('paid_at', today())->sum('amount');
        $pendingPayments = Payment::where('status', Payment::STATUS_PENDING)->latest()->take(20)->get();
        $failedPayments = Payment::where('status', Payment::STATUS_FAILED)->latest()->take(20)->get();

        $packageRevenue = Payment::query()
            ->selectRaw('package_id, SUM(amount) as revenue, COUNT(*) as payments_count')
            ->with('package')
            ->where('status', Payment::STATUS_PAID)
            ->whereNotNull('package_id')
            ->groupBy('package_id')
            ->orderByDesc('revenue')
            ->get();

        $eventRevenue = Payment::query()
            ->selectRaw('event_id, SUM(amount) as revenue, COUNT(*) as payments_count')
            ->with('event')
            ->where('status', Payment::STATUS_PAID)
            ->whereNotNull('event_id')
            ->groupBy('event_id')
            ->orderByDesc('revenue')
            ->get();

        $refunds = Payment::where('status', Payment::STATUS_REFUNDED)->latest('refunded_at')->get();

        return view('admin.payments.reports', compact(
            'paymentsToday',
            'pendingPayments',
            'failedPayments',
            'packageRevenue',
            'eventRevenue',
            'refunds'
        ));
    }

    public function markPending(Payment $payment)
    {
        if ($payment->status !== Payment::STATUS_CANCELLED) {
            return redirect()
                ->route('admin.payments.index')
                ->with('error', 'Only cancelled payments can be changed back to pending.');
        }

        $payment->update([
            'status' => Payment::STATUS_PENDING,
            'cancelled_at' => null,
            'failed_at' => null,
            'expires_at' => now()->addMinutes(30),
        ]);

        optional($payment->submission)->update(['status' => 'payment_pending']);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment reopened. Share link: ' . route('payments.show', $payment));
    }
}
