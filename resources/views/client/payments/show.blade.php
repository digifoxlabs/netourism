@extends('client-layout')

@section('page-content')
<div class="mx-auto max-w-3xl px-4 py-10">
    <div class="rounded-2xl border bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-sm text-slate-500">Payment Reference</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">{{ $payment->txnid }}</h1>
            </div>

            <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase
                {{ $payment->status === 'paid' ? 'bg-emerald-100 text-emerald-700' :
                    ($payment->status === 'pending' ? 'bg-amber-100 text-amber-700' :
                    'bg-slate-200 text-slate-700') }}">
                {{ ucfirst($payment->status) }}
            </span>
        </div>

        @if(session('success'))
            <div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-xl border bg-slate-50 p-4">
                <p class="text-xs text-slate-500">For</p>
                <p class="mt-1 font-semibold text-slate-900">{{ $payment->productinfo }}</p>
            </div>

            <div class="rounded-xl border bg-slate-50 p-4">
                <p class="text-xs text-slate-500">Amount</p>
                <p class="mt-1 font-semibold text-slate-900">Rs. {{ number_format((float) $payment->amount, 2) }}</p>
            </div>

            <div class="rounded-xl border bg-slate-50 p-4">
                <p class="text-xs text-slate-500">Name</p>
                <p class="mt-1 font-semibold text-slate-900">{{ $payment->firstname ?: 'Guest' }}</p>
            </div>

            <div class="rounded-xl border bg-slate-50 p-4">
                <p class="text-xs text-slate-500">Email</p>
                <p class="mt-1 font-semibold text-slate-900">{{ $payment->email ?: 'Not provided' }}</p>
            </div>
        </div>

        @if($payment->status === 'pending')
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                This payment link is valid until {{ optional($payment->expires_at)->format('d M Y, h:i A') }}.
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <form method="POST" action="{{ route('payments.checkout', $payment) }}">
                    @csrf
                    <button type="submit" class="inline-flex rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">
                        Pay Now
                    </button>
                </form>

                <form method="POST" action="{{ route('payments.cancel', $payment) }}">
                    @csrf
                    <button type="submit" class="inline-flex rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel Payment
                    </button>
                </form>
            </div>
        @elseif($payment->status === 'paid')
            <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                Payment received on {{ optional($payment->paid_at)->format('d M Y, h:i A') }}.
            </div>
        @endif
    </div>
</div>
@endsection
