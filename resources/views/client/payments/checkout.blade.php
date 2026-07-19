@extends('client-layout')

@section('page-content')
<div class="mx-auto max-w-xl px-4 py-16 text-center">
    <div class="rounded-2xl border bg-white p-8 shadow-sm">
        <h1 class="text-xl font-semibold text-slate-900">Redirecting to PayU</h1>
        <p class="mt-2 text-sm text-slate-600">Please wait while we securely send your payment request.</p>

        <form id="payu-checkout-form" method="POST" action="{{ $gatewayUrl }}" class="hidden">
            @foreach($params as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
        </form>
    </div>
</div>

<script>
    document.getElementById('payu-checkout-form').submit();
</script>
@endsection
