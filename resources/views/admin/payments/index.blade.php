@extends('admin-layout')

@section('page-content')
<div class="mx-auto max-w-6xl px-4 py-8">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Payments</h1>
            <p class="text-sm text-slate-500">Track customer payment attempts and statuses.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.payments.settings') }}" class="rounded-lg border px-4 py-2 text-sm font-semibold">Settings</a>
            <a href="{{ route('admin.payments.reports') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Reports</a>
        </div>
    </div>

    <div class="mb-6 grid gap-4 md:grid-cols-3">
        <div class="rounded-xl border bg-white p-4"><p class="text-xs text-slate-500">Payments Today</p><p class="text-xl font-bold">Rs. {{ number_format((float) $stats['today'], 2) }}</p></div>
        <div class="rounded-xl border bg-white p-4"><p class="text-xs text-slate-500">Pending Payments</p><p class="text-xl font-bold">{{ $stats['pending'] }}</p></div>
        <div class="rounded-xl border bg-white p-4"><p class="text-xs text-slate-500">Failed Payments</p><p class="text-xl font-bold">{{ $stats['failed'] }}</p></div>
    </div>

    <div class="overflow-hidden rounded-2xl border bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Txn ID</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">For</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($payments as $payment)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $payment->txnid }}</td>
                        <td class="px-4 py-3">{{ $payment->firstname }}<br><span class="text-xs text-slate-500">{{ $payment->email }}</span></td>
                        <td class="px-4 py-3">{{ $payment->productinfo }}</td>
                        <td class="px-4 py-3">Rs. {{ number_format((float) $payment->amount, 2) }}</td>
                        <td class="px-4 py-3">{{ ucfirst($payment->status) }}</td>
                        <td class="px-4 py-3">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">No payments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $payments->links() }}</div>
</div>
@endsection
