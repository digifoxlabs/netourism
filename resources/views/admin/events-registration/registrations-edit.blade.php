@extends('admin-layout')

@section('page-content')
<div class="mx-auto max-w-4xl px-4 py-8 lg:py-10">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Edit Registration #{{ $event_registration->id }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ $event_registration->full_name }} — {{ $event_registration->event_name }}
            </p>
        </div>
        <a href="{{ route('admin.event-registrations.show', $event_registration) }}"
           class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            View details
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="font-semibold mb-1">There were some errors with your submission:</div>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.event-registrations.update', $event_registration) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Event Meta --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm space-y-4">
            <h2 class="text-sm font-semibold text-slate-800">Event Details</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Event Code</label>
                    <input type="text" name="event_code"
                           value="{{ old('event_code', $event_registration->event_code) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Event Name</label>
                    <input type="text" name="event_name"
                           value="{{ old('event_name', $event_registration->event_name) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>
        </div>

        {{-- Personal Details --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm space-y-4">
            <h2 class="text-sm font-semibold text-slate-800">Personal Details</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Full Name</label>
                    <input type="text" name="full_name"
                           value="{{ old('full_name', $event_registration->full_name) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $event_registration->email) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Mobile</label>
                    <input type="text" name="mobile"
                           value="{{ old('mobile', $event_registration->mobile) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">City / State</label>
                    <input type="text" name="city_state"
                           value="{{ old('city_state', $event_registration->city_state) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                           value="{{ old('date_of_birth', \Carbon\Carbon::parse($event_registration->date_of_birth)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Emergency Contact Person</label>
                    <input type="text" name="emergency_contact_person"
                           value="{{ old('emergency_contact_person', $event_registration->emergency_contact_person) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Emergency Contact Number</label>
                    <input type="text" name="emergency_contact_number"
                           value="{{ old('emergency_contact_number', $event_registration->emergency_contact_number) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
            </div>
        </div>

        {{-- Ride & Accommodation --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm space-y-4">
            <h2 class="text-sm font-semibold text-slate-800">Ride & Accommodation</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Mode of Transport</label>
                    <select name="mode_of_transport"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                        @foreach (['motorcycle' => 'Motorcycle', 'pillion' => 'Pillion', 'other' => 'Other'] as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('mode_of_transport', $event_registration->mode_of_transport) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Motorcycle Make & Model</label>
                    <input type="text" name="motorcycle_make_model"
                           value="{{ old('motorcycle_make_model', $event_registration->motorcycle_make_model) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">License Plate Number</label>
                    <input type="text" name="license_plate_number"
                           value="{{ old('license_plate_number', $event_registration->license_plate_number) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div class="flex items-center gap-2 mt-6">
                    <input
                        type="checkbox"
                        id="is_pillion"
                        name="is_pillion"
                        value="1"
                        class="rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                        {{ old('is_pillion', $event_registration->is_pillion) ? 'checked' : '' }}
                    >
                    <label for="is_pillion" class="text-xs font-medium text-slate-700">
                        Is Pillion
                    </label>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Primary Rider Name</label>
                    <input type="text" name="primary_rider_name"
                           value="{{ old('primary_rider_name', $event_registration->primary_rider_name) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Accommodation Preference</label>
                    <select name="accommodation_preference"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="tent_sharing"
                            {{ old('accommodation_preference', $event_registration->accommodation_preference) === 'tent_sharing' ? 'selected' : '' }}>
                            Tent (Sharing)
                        </option>
                        <option value="separate_tent"
                            {{ old('accommodation_preference', $event_registration->accommodation_preference) === 'separate_tent' ? 'selected' : '' }}>
                            Separate Tent
                        </option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-slate-600 mb-1">Allergies / Dietary Requirements</label>
                    <textarea
                        name="allergies_dietary"
                        rows="3"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500"
                    >{{ old('allergies_dietary', $event_registration->allergies_dietary) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Payment & Terms --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm space-y-4">
            <h2 class="text-sm font-semibold text-slate-800">Payment & Terms</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Payment Method</label>
                    <select name="payment_method"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="upi"
                            {{ old('payment_method', $event_registration->payment_method) === 'upi' ? 'selected' : '' }}>
                            UPI
                        </option>
                        <option value="bank_transfer"
                            {{ old('payment_method', $event_registration->payment_method) === 'bank_transfer' ? 'selected' : '' }}>
                            Bank Transfer
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Transaction ID</label>
                    <input type="text" name="transaction_id"
                           value="{{ old('transaction_id', $event_registration->transaction_id) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Payment Date</label>
                    <input type="date" name="payment_date"
                          value="{{ old('payment_date', \Carbon\Carbon::parse($event_registration->payment_date)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                </div>
                <div class="flex items-center gap-2 mt-6">
                    <input
                        type="checkbox"
                        id="terms_accepted"
                        name="terms_accepted"
                        value="1"
                        class="rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                        {{ old('terms_accepted', $event_registration->terms_accepted) ? 'checked' : '' }}
                    >
                    <label for="terms_accepted" class="text-xs font-medium text-slate-700">
                        Terms Accepted
                    </label>
                </div>


            {{-- NEW: Status --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Status</label>
                    <select name="status"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="pending"
                            {{ old('status', $event_registration->status) === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="confirmed"
                            {{ old('status', $event_registration->status) === 'confirmed' ? 'selected' : '' }}>
                            Confirmed
                        </option>
                    </select>
                    <p class="mt-1 text-[11px] text-slate-500">
                        Changing this here will update the status only. Confirmation email is sent via the Confirm button on the details page.
                    </p>
                </div>


            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.event-registrations.index') }}"
               class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button
                type="submit"
                class="inline-flex items-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-500"
            >
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
