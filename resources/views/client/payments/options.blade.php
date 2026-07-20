@extends('client-layout')

@section('page-content')
<div class="mx-auto max-w-3xl px-4 py-10">
    <div class="rounded-2xl border bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Choose Payment Option</h1>
        <p class="mt-2 text-sm text-slate-600">
            Select one option to proceed with your booking.
        </p>

        <form method="POST" action="{{ route('booking-payments.choose', $submission) }}" class="mt-6 space-y-4">
            @csrf

            @foreach($options as $index => $option)
                <label class="block cursor-pointer rounded-xl border p-4 hover:border-emerald-400">
                    <div class="flex items-start gap-3">
                        <input type="radio" name="payment_option" value="{{ $index }}" class="mt-1 text-emerald-600" @checked($loop->first)>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <span class="font-semibold text-slate-900">{{ $option['label'] }}</span>
                                <span class="text-sm font-semibold text-emerald-700">
                                    @if($option['type'] === 'pay_later')
                                        Pay Later
                                    @else
                                        Rs. {{ number_format((float) $option['amount'], 2) }}
                                    @endif
                                </span>
                            </div>
                            <p class="mt-1 text-xs uppercase tracking-wide text-slate-500">{{ str_replace('_', ' ', $option['type']) }}</p>
                            @if($option['description'])
                                <p class="mt-2 text-sm text-slate-600">{{ $option['description'] }}</p>
                            @endif
                        </div>
                    </div>
                </label>
            @endforeach

            @error('payment_option')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="flex justify-end">
                <button class="rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">
                    Proceed for Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
