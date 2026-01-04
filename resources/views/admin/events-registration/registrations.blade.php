
@extends('admin-layout')

@section('page-content')

<div class="mx-auto max-w-4xl px-4 py-8 lg:py-10">

    
    <div class="mb-6 flex items-center justify-between gap-4">

        
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Registration #{{ $event_registration->id }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ $event_registration->full_name }} — {{ $event_registration->event_name }}
            </p>
        </div>
        <div class="flex gap-2">

                    @php
            $status = $event_registration->status;
            $statusClasses = match ($status) {
                'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                default     => 'bg-slate-50 text-slate-700 border-slate-200',
            };
        @endphp

        <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
            Status: {{ ucfirst($status) }}
        </span>
            <a href="{{ route('admin.event-registrations.edit', $event_registration) }}"
               class="inline-flex items-center rounded-lg border border-blue-300 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50">
                Edit
            </a>
            <a href="{{ route('admin.event-registrations.index') }}"
               class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                Back to list
            </a>
        </div>

        
    </div>

    {{-- Event Meta --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">Event Details</h2>
        <dl class="grid gap-3 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-slate-500">Event Code</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->event_code }}</dd>
            </div>
            <div>
                <dt class="text-slate-500">Event Name</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->event_name }}</dd>
            </div>
        </dl>
    </div>

    {{-- Personal Details --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">Personal Details</h2>
        <dl class="grid gap-3 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-slate-500">Full Name</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->full_name }}</dd>
            </div>
            <div>
                <dt class="text-slate-500">Email</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->email }}</dd>
            </div>
            <div>
                <dt class="text-slate-500">Mobile</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->mobile }}</dd>
            </div>
            <div>
                <dt class="text-slate-500">City / State</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->city_state }}</dd>
            </div>
            <div>
                <dt class="text-slate-500">Date of Birth</dt>
                <dd class="font-medium text-slate-900">
                    {{ \Carbon\Carbon::parse($event_registration->date_of_birth)->format('d M Y') }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Emergency Contact Person</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->emergency_contact_person }}</dd>
            </div>
            <div>
                <dt class="text-slate-500">Emergency Contact Number</dt>
                <dd class="font-medium text-slate-900">{{ $event_registration->emergency_contact_number }}</dd>
            </div>
        </dl>
    </div>

    {{-- Event & Ride Details --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">Ride & Accommodation</h2>
        <dl class="grid gap-3 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-slate-500">Mode of Transport</dt>
                <dd class="font-medium text-slate-900">
                    {{ ucfirst(str_replace('_', ' ', $event_registration->mode_of_transport)) }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Motorcycle Make & Model</dt>
                <dd class="font-medium text-slate-900">
                    {{ $event_registration->motorcycle_make_model ?: 'N/A' }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">License Plate Number</dt>
                <dd class="font-medium text-slate-900">
                    {{ $event_registration->license_plate_number ?: 'N/A' }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Is Pillion?</dt>
                <dd class="font-medium text-slate-900">
                    {{ $event_registration->is_pillion ? 'Yes' : 'No' }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Primary Rider Name</dt>
                <dd class="font-medium text-slate-900">
                    {{ $event_registration->primary_rider_name ?: 'N/A' }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Accommodation Preference</dt>
                <dd class="font-medium text-slate-900">
                    {{ $event_registration->accommodation_preference === 'tent_sharing' ? 'Tent (Sharing)' : 'Separate Tent' }}
                </dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-slate-500">Allergies / Dietary Requirements</dt>
                <dd class="font-medium text-slate-900 whitespace-pre-line">
                    {{ $event_registration->allergies_dietary ?: 'None specified' }}
                </dd>
            </div>
        </dl>
    </div>

    {{-- Payment & Terms --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">Payment & Confirmation</h2>
        <dl class="grid gap-3 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-slate-500">Payment Method</dt>
                <dd class="font-medium text-slate-900 text-uppercase">
                    {{ strtoupper($event_registration->payment_method) }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Transaction ID</dt>
                <dd class="font-medium text-slate-900">
                    {{ $event_registration->transaction_id }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Payment Date</dt>
                <dd class="font-medium text-slate-900">
                    {{ \Carbon\Carbon::parse($event_registration->payment_date)->format('d M Y') }}
                </dd>
            </div>
            <div>
                <dt class="text-slate-500">Terms Accepted</dt>
                <dd class="font-medium text-slate-900">
                    {{ $event_registration->terms_accepted ? 'Yes' : 'No' }}
                </dd>
            </div>
        </dl>
    </div>










{{-- Confirm section (only if pending) --}}
@if($event_registration->status === 'pending')
    <div class="mt-6 flex justify-end">
        <button
            type="button"
            onclick="openConfirmModal()"
            class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500"
        >
            Confirm Registration & Send Email
        </button>
    </div>
@endif


{{-- Confirm Modal --}}
<div
    id="confirmModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50"
>
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4 p-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Confirm Registration
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            This will mark the registration as <strong>confirmed</strong> and send the following email to:
            <span class="font-medium">{{ $event_registration->email }}</span>
        </p>

        {{-- Email preview --}}
        <div class="mt-4 border border-slate-200 rounded-lg bg-white px-4 py-4 text-sm text-slate-800 overflow-y-auto max-h-[70vh]">
        @include('emails.events.partials.registration_confirmed_content', [
        'registration' => $event_registration
        ])
        </div>

        <form
            method="POST"
            action="{{ route('admin.event-registrations.confirm', $event_registration) }}"
            class="mt-6 flex justify-end gap-3"
        >
            @csrf

            <button
                type="button"
                onclick="closeConfirmModal()"
                class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-100"
            >
                Cancel
            </button>

            <button
                type="submit"
                class="px-4 py-2 rounded-lg bg-emerald-600 text-sm font-semibold text-white hover:bg-emerald-500"
            >
                Confirm & Send Email
            </button>
        </form>
    </div>
</div>











</div>






@endsection

@push('scripts')


<script>
    function openConfirmModal() {
        const modal = document.getElementById('confirmModal');
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeConfirmModal();
        }
    });

    // Close on backdrop click
    document.addEventListener('click', function (e) {
        const modal = document.getElementById('confirmModal');
        if (!modal || modal.classList.contains('hidden')) return;

        if (e.target === modal) {
            closeConfirmModal();
        }
    });
</script>

    
@endpush