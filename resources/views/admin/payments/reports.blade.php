@extends('admin-layout')

@section('page-content')
<div class="mx-auto max-w-6xl px-4 py-8 space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Payment Reports</h1>
            <p class="text-sm text-slate-500">Revenue and status summaries for events and packages.</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="rounded-lg border px-4 py-2 text-sm font-semibold">All Payments</a>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-xl border bg-white p-4"><p class="text-xs text-slate-500">Payments Today</p><p class="text-xl font-bold">Rs. {{ number_format((float) $paymentsToday, 2) }}</p></div>
        <div class="rounded-xl border bg-white p-4"><p class="text-xs text-slate-500">Pending Payments</p><p class="text-xl font-bold">{{ $pendingPayments->count() }}</p></div>
        <div class="rounded-xl border bg-white p-4"><p class="text-xs text-slate-500">Failed Payments</p><p class="text-xl font-bold">{{ $failedPayments->count() }}</p></div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-2xl border bg-white p-5">
            <h2 class="mb-4 font-semibold">Package-wise Revenue</h2>
            <div class="space-y-3">
                @forelse($packageRevenue as $row)
                    <div class="flex justify-between border-b pb-2 text-sm"><span>{{ optional($row->package)->name ?: 'Deleted package' }}</span><strong>Rs. {{ number_format((float) $row->revenue, 2) }}</strong></div>
                @empty
                    <p class="text-sm text-slate-500">No paid package payments yet.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border bg-white p-5">
            <h2 class="mb-4 font-semibold">Event-wise Revenue</h2>
            <div class="space-y-3">
                @forelse($eventRevenue as $row)
                    <div class="flex justify-between border-b pb-2 text-sm"><span>{{ optional($row->event)->title ?: 'Deleted event' }}</span><strong>Rs. {{ number_format((float) $row->revenue, 2) }}</strong></div>
                @empty
                    <p class="text-sm text-slate-500">No paid event payments yet.</p>
                @endforelse
            </div>
        </section>
    </div>

    <section class="rounded-2xl border bg-white p-5">
        <h2 class="mb-4 font-semibold">Refund Report</h2>
        @forelse($refunds as $payment)
            <div class="flex justify-between border-b py-2 text-sm"><span>{{ $payment->txnid }} - {{ $payment->productinfo }}</span><strong>Rs. {{ number_format((float) $payment->amount, 2) }}</strong></div>
        @empty
            <p class="text-sm text-slate-500">No refunded payments recorded.</p>
        @endforelse
    </section>
</div>
@endsection
