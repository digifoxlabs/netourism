@extends('admin-layout')

@section('page-content')
<div class="mx-auto max-w-4xl px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Payment Gateway</h1>
            <p class="text-sm text-slate-500">Configure PayU checkout and Alt ID credentials.</p>
        </div>
        <a href="{{ route('admin.payments.reports') }}" class="rounded-lg border px-4 py-2 text-sm font-semibold">Reports</a>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.payments.settings.update') }}" class="space-y-6 rounded-2xl border bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <label class="flex items-center gap-3 text-sm font-semibold">
            <input type="checkbox" name="enabled" value="1" @checked(old('enabled', $settings->enabled)) class="h-4 w-4 rounded border-slate-300 text-emerald-600">
            Enable PayU payments
        </label>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Environment</label>
                <select name="environment" class="mt-1 h-11 w-full rounded-lg border px-3">
                    <option value="demo" @selected(old('environment', $settings->environment) === 'demo')>Demo</option>
                    <option value="live" @selected(old('environment', $settings->environment) === 'live')>Live</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Merchant Key</label>
                <input name="merchant_key" value="{{ old('merchant_key', $settings->merchant_key) }}" class="mt-1 h-11 w-full rounded-lg border px-3">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700">Merchant Salt</label>
                <input name="merchant_salt" value="{{ old('merchant_salt', $settings->merchant_salt) }}" class="mt-1 h-11 w-full rounded-lg border px-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Demo Checkout URL</label>
                <input name="demo_url" value="{{ old('demo_url', $settings->demo_url) }}" class="mt-1 h-11 w-full rounded-lg border px-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Live Checkout URL</label>
                <input name="live_url" value="{{ old('live_url', $settings->live_url) }}" class="mt-1 h-11 w-full rounded-lg border px-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Demo Alt ID URL</label>
                <input name="alt_id_demo_url" value="{{ old('alt_id_demo_url', $settings->alt_id_demo_url) }}" class="mt-1 h-11 w-full rounded-lg border px-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Live Alt ID URL</label>
                <input name="alt_id_live_url" value="{{ old('alt_id_live_url', $settings->alt_id_live_url) }}" class="mt-1 h-11 w-full rounded-lg border px-3">
            </div>
        </div>

        <div class="flex justify-end">
            <button class="rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Save Settings</button>
        </div>
    </form>
</div>
@endsection
