@extends('client-layout')

@section('page-content')


<div class="max-w-4xl mx-auto px-4 py-8">
    {{-- Header --}}
    <header class="mb-8">
        <div class="bg-white shadow-sm rounded-2xl p-6 border border-slate-200">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight mb-2">
                Alfresco 2.0 – Embracing the Call of the Wild, Kaziranga
            </h1>
            <p class="text-sm text-slate-600 mb-1">
                Powered By: <span class="font-semibold">Netourism</span>
            </p>
            <p class="text-sm text-slate-600 mb-1">
                Organized By: <span class="font-semibold">The Hind Riders Motorcycle Community</span>
            </p>
            <p class="text-sm text-slate-600 mb-1">
                Event Dates: <span class="font-semibold">20th December to 21st December 2025</span>
            </p>
            <p class="text-sm text-slate-800 mt-3 font-semibold">
                Registration Fee: ₹2,299/- <span class="font-normal text-slate-600">per head</span>
            </p>
        </div>
    </header>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <p class="font-semibold mb-2">Please correct the following errors:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form
        action="{{ route('events.alfresco.register.store') }}"
        method="POST"
        class="space-y-6"
        x-data="{
            transport: '{{ old('mode_of_transport', 'motorcycle') }}',
            isPillion: {{ old('is_pillion', 0) ? 'true' : 'false' }},
        }"
    >
        @csrf

        {{-- 1. Personal Details --}}
        <section class="bg-white shadow-sm rounded-2xl p-6 border border-slate-200">
            <h2 class="text-lg font-semibold mb-4">1. Personal Details</h2>
            <div class="grid gap-4 md:grid-cols-2">
                {{-- Full Name --}}
                <div>
                    <label for="full_name" class="block text-sm font-medium text-slate-700">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="full_name"
                        name="full_name"
                        type="text"
                        required
                        value="{{ old('full_name') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>

                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        value="{{ old('email') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                    <p class="mt-1 text-xs text-slate-500">
                        For communication and confirmation.
                    </p>
                </div>

                {{-- Mobile Number --}}
                <div>
                    <label for="mobile" class="block text-sm font-medium text-slate-700">
                        Mobile Number <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="mobile"
                        name="mobile"
                        type="tel"
                        required
                        value="{{ old('mobile') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                    <p class="mt-1 text-xs text-slate-500">
                        For urgent contact.
                    </p>
                </div>

                {{-- City/State of Residence --}}
                <div>
                    <label for="city_state" class="block text-sm font-medium text-slate-700">
                        City/State of Residence <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="city_state"
                        name="city_state"
                        type="text"
                        required
                        value="{{ old('city_state') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>

                {{-- Date of Birth --}}
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-slate-700">
                        Date of Birth <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="date_of_birth"
                        name="date_of_birth"
                        type="date"
                        required
                        value="{{ old('date_of_birth') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>

                {{-- Emergency Contact Person --}}
                <div>
                    <label for="emergency_contact_person" class="block text-sm font-medium text-slate-700">
                        Emergency Contact Person <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="emergency_contact_person"
                        name="emergency_contact_person"
                        type="text"
                        required
                        value="{{ old('emergency_contact_person') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>

                {{-- Emergency Contact Number --}}
                <div>
                    <label for="emergency_contact_number" class="block text-sm font-medium text-slate-700">
                        Emergency Contact Number <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="emergency_contact_number"
                        name="emergency_contact_number"
                        type="tel"
                        required
                        value="{{ old('emergency_contact_number') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>
            </div>
        </section>

        {{-- 2. Event & Ride Details --}}
        <section class="bg-white shadow-sm rounded-2xl p-6 border border-slate-200">
            <h2 class="text-lg font-semibold mb-4">2. Event & Ride Details</h2>

            {{-- Mode of Transport --}}
            <div class="mb-4">
                <p class="block text-sm font-medium text-slate-700 mb-2">
                    Mode of Transport <span class="text-red-500">*</span>
                </p>
                <div class="space-y-2 text-base">
                    <label class="flex items-center gap-3">
                        <input
                            type="radio"
                            name="mode_of_transport"
                            value="motorcycle"
                            x-model="transport"
                            class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            {{ old('mode_of_transport', 'motorcycle') === 'motorcycle' ? 'checked' : '' }}
                        >
                        <span>Motorcycle Ride (Self)</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input
                            type="radio"
                            name="mode_of_transport"
                            value="pillion"
                            x-model="transport"
                            class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            {{ old('mode_of_transport') === 'pillion' ? 'checked' : '' }}
                        >
                        <span>Pillion Rider (Riding with a registered rider)</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input
                            type="radio"
                            name="mode_of_transport"
                            value="other"
                            x-model="transport"
                            class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            {{ old('mode_of_transport') === 'other' ? 'checked' : '' }}
                        >
                        <span>Other (Will arrange own transport to Assembly Point)</span>
                    </label>
                </div>
            </div>

            {{-- Motorcycle details (shown only if transport == 'motorcycle') --}}
            <div
                class="grid gap-4 md:grid-cols-2"
                x-show="transport === 'motorcycle'"
                x-cloak
            >
                <div>
                    <label for="motorcycle_make_model" class="block text-sm font-medium text-slate-700">
                        Motorcycle Make &amp; Model
                        <span class="text-red-500" x-show="transport === 'motorcycle'">*</span>
                    </label>
                    <input
                        id="motorcycle_make_model"
                        name="motorcycle_make_model"
                        type="text"
                        value="{{ old('motorcycle_make_model') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                    <p class="mt-1 text-xs text-slate-500">
                        e.g., Royal Enfield Classic 350
                    </p>
                </div>

                <div>
                    <label for="license_plate_number" class="block text-sm font-medium text-slate-700">
                        License Plate Number
                        <span class="text-red-500" x-show="transport === 'motorcycle'">*</span>
                    </label>
                    <input
                        id="license_plate_number"
                        name="license_plate_number"
                        type="text"
                        value="{{ old('license_plate_number') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>
            </div>

            {{-- Pillion Rider --}}
            <div class="mt-6 space-y-3">
                <div>
                    <p class="block text-sm font-medium text-slate-700 mb-2">
                        Are you registering as a Pillion Rider?
                    </p>
                    <div class="flex flex-wrap gap-4 text-base">
                        <label class="inline-flex items-center gap-3">
                            <input
                                type="radio"
                                name="is_pillion"
                                value="1"
                                x-model="isPillion"
                                :checked="{{ old('is_pillion', 0) ? 'true' : 'false' }}"
                                @change="isPillion = true"
                                class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            >
                            <span>Yes</span>
                        </label>
                        <label class="inline-flex items-center gap-3">
                            <input
                                type="radio"
                                name="is_pillion"
                                value="0"
                                x-model="isPillion"
                                @change="isPillion = false"
                                class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                {{ old('is_pillion', 0) ? '' : 'checked' }}
                            >
                            <span>No</span>
                        </label>
                    </div>
                </div>

                <div x-show="isPillion" x-cloak>
                    <label for="primary_rider_name" class="block text-sm font-medium text-slate-700">
                        Primary Rider's Name
                        <span class="text-red-500" x-show="isPillion">*</span>
                    </label>
                    <input
                        id="primary_rider_name"
                        name="primary_rider_name"
                        type="text"
                        value="{{ old('primary_rider_name') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>
            </div>

            {{-- Accommodation Preference --}}
            <div class="mt-6">
                <p class="block text-sm font-medium text-slate-700 mb-2">
                    Accommodation Preference <span class="text-red-500">*</span>
                </p>
                <p class="text-xs text-slate-500 mb-2">
                    Based on a shared camp setup.
                </p>
                <div class="space-y-2 text-base">
                    <label class="flex items-center gap-3">
                        <input
                            type="radio"
                            name="accommodation_preference"
                            value="tent_sharing"
                            class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            {{ old('accommodation_preference', 'tent_sharing') === 'tent_sharing' ? 'checked' : '' }}
                        >
                        <span>Tent Sharing (Standard)</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input
                            type="radio"
                            name="accommodation_preference"
                            value="separate_tent"
                            class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            {{ old('accommodation_preference') === 'separate_tent' ? 'checked' : '' }}
                        >
                        <span>Request for separate tent (May incur extra cost - specify in Notes)</span>
                    </label>
                </div>
            </div>

            {{-- Allergies / Dietary --}}
            <div class="mt-6">
                <label for="allergies_dietary" class="block text-sm font-medium text-slate-700">
                    Any Known Allergies or Dietary Restrictions?
                </label>
                <textarea
                    id="allergies_dietary"
                    name="allergies_dietary"
                    rows="3"
                    class="mt-1 block w-full rounded-lg border-slate-300 px-4 py-3 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    placeholder="e.g., Vegetarian, No Gluten, Nut Allergy"
                >{{ old('allergies_dietary') }}</textarea>
            </div>
        </section>

        {{-- 3. Payment & Confirmation --}}
        <section class="bg-white shadow-sm rounded-2xl p-6 border border-slate-200">
            <h2 class="text-lg font-semibold mb-4">3. Payment &amp; Confirmation</h2>

            <p class="text-sm text-slate-800 mb-3">
                Registration Fee: <span class="font-semibold">₹2,299/- per head.</span>
            </p>

            <div class="grid gap-4 md:grid-cols-2">
                {{-- Payment Method --}}
                <div class="md:col-span-2">
                    <p class="block text-sm font-medium text-slate-700 mb-2">
                        Payment Method Used <span class="text-red-500">*</span>
                    </p>
                    <div class="space-y-2 text-base">
                        <label class="flex items-center gap-3">
                            <input
                                type="radio"
                                name="payment_method"
                                value="upi"
                                class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                {{ old('payment_method', 'upi') === 'upi' ? 'checked' : '' }}
                            >
                            <span>UPI (PhonePe / GPay)</span>
                        </label>
                        <label class="flex items-center gap-3">
                            <input
                                type="radio"
                                name="payment_method"
                                value="bank_transfer"
                                class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                            >
                            <span>Bank Transfer</span>
                        </label>
                    </div>
                </div>

                {{-- Transaction ID --}}
                <div>
                    <label for="transaction_id" class="block text-sm font-medium text-slate-700">
                        Transaction ID / Reference Number <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="transaction_id"
                        name="transaction_id"
                        type="text"
                        required
                        value="{{ old('transaction_id') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                    <p class="mt-1 text-xs text-slate-500">
                        This confirms your spot.
                    </p>
                </div>

                {{-- Payment Date --}}
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-slate-700">
                        Date of Payment <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="payment_date"
                        name="payment_date"
                        type="date"
                        required
                        value="{{ old('payment_date') }}"
                        class="mt-1 block w-full h-12 px-4 rounded-lg border-slate-300 text-base shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                    >
                </div>
            </div>

            {{-- Payment Instructions --}}
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-900">
                <p class="mb-1">
                    <span class="font-semibold">Payment Instructions:</span>
                    Please pay the registration fee of ₹2,299/- per head before filling out this form.
                </p>
                <p>
                    For payment details (UPI / Bank Account), please contact
                    <span class="font-semibold">Ronnie</span> at
                    <span class="font-mono">+91-93658-04680</span>
                    or visit
                    <a href="https://www.netourism.com" class="underline text-amber-900" target="_blank" rel="noopener noreferrer">
                        www.netourism.com
                    </a>.
                </p>
            </div>
        </section>

        {{-- 4. Terms & Conditions --}}
        <section class="bg-white shadow-sm rounded-2xl p-6 border border-slate-200">
            <h2 class="text-lg font-semibold mb-4">4. Terms &amp; Conditions</h2>

            <ul class="list-disc list-inside text-sm text-slate-700 space-y-2 mb-4">
                <li>
                    I confirm that I possess a valid driver's license and all necessary documents for my motorcycle (if applicable).
                </li>
                <li>
                    I understand that motorcycle riding and jungle activities carry inherent risks, and I agree to participate at my own risk.
                </li>
                <li>
                    I agree to adhere to all safety guidelines and instructions provided by the organizers (The Hind Riders &amp; Netourism).
                </li>
                <li>
                    I understand that the Assembly Point is
                    <span class="font-semibold">TAJ Hotel, Khanapara</span>,
                    and the Assembly Time is
                    <span class="font-semibold">08:00 AM on Saturday, 20th Dec 2025</span>.
                </li>
            </ul>

            <label class="flex items-start gap-3 text-base text-slate-800">
                <input
                    type="checkbox"
                    name="terms_accepted"
                    value="1"
                    class="mt-1 h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                    {{ old('terms_accepted') ? 'checked' : '' }}
                    required
                >
                <span>I agree to the Terms &amp; Conditions.</span>
            </label>
        </section>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3">
            <button
                type="reset"
                class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-base font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            >
                Reset
            </button>
            <button
                type="submit"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            >
                Submit Registration
            </button>
        </div>
    </form>
</div>







@endsection
@push('scripts')


@endpush