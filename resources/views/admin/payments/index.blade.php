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

    @if(session('success'))
        <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

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
                    <th class="px-4 py-3">Payment Link</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($payments as $payment)
                    @php($paymentUrl = route('payments.show', $payment))
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $payment->txnid }}</td>
                        <td class="px-4 py-3">{{ $payment->firstname }}<br><span class="text-xs text-slate-500">{{ $payment->email }}</span></td>
                        <td class="px-4 py-3">
                            {{ $payment->productinfo }}
                            @if($payment->payment_label)
                                <br>
                                <span class="text-xs text-slate-500">
                                    {{ $payment->payment_label }} · {{ str_replace('_', ' ', ucfirst($payment->payment_type)) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">Rs. {{ number_format((float) $payment->amount, 2) }}</td>
                        <td class="px-4 py-3">{{ ucfirst($payment->status) }}</td>
                        <td class="px-4 py-3">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                        <td class="px-4 py-3">
                            @if($payment->status === \App\Models\Payment::STATUS_PENDING)
                                <div class="flex flex-wrap items-center gap-2">
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $paymentUrl }}"
                                        class="h-9 w-56 rounded-lg border border-slate-300 px-3 text-xs text-slate-600"
                                    >
                                    <button
                                        type="button"
                                        data-copy="{{ $paymentUrl }}"
                                        class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                                    >
                                        Copy
                                    </button>
                                    <a
                                        href="mailto:{{ $payment->email }}?subject={{ rawurlencode('Payment link for ' . $payment->productinfo) }}&body={{ rawurlencode('Please complete your payment using this link: ' . $paymentUrl) }}"
                                        class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700"
                                    >
                                        Email
                                    </a>
                                </div>
                            @elseif($payment->status === \App\Models\Payment::STATUS_CANCELLED)
                                <form method="POST" action="{{ route('admin.payments.mark-pending', $payment) }}">
                                    @csrf
                                    <button class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600">
                                        Change to Pending
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">Not shareable</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-slate-500">No payments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $payments->links() }}</div>
</div>

<script>
    document.addEventListener('click', async function (event) {
        const button = event.target.closest('[data-copy]');
        if (!button) return;

        try {
            await navigator.clipboard.writeText(button.dataset.copy);
            const oldText = button.textContent;
            button.textContent = 'Copied';
            setTimeout(() => button.textContent = oldText, 1200);
        } catch (error) {
            window.prompt('Payment link', button.dataset.copy);
        }
    });
</script>
@endsection
