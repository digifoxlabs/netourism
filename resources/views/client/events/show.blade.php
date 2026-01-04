@extends('client-layout')

@section('page-content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Status Alerts --}}
    @if($event->status === 'upcoming')
        <div class="mb-6 rounded-lg border bg-sky-50 p-4 text-sm text-sky-800">
            Registrations will open soon. Please check back later.
        </div>
    @endif

    @if($event->status === 'expired')
        <div class="mb-6 rounded-lg border bg-slate-100 p-4 text-sm text-slate-700">
            This event has already concluded.
        </div>
    @endif

    {{-- Two Column Layout --}}
    <div class="grid gap-8 lg:grid-cols-5">

        {{-- LEFT: Event Details --}}
        <div class="lg:col-span-2 space-y-6 lg:sticky lg:top-6 self-start">

            {{-- Hero / Details Card --}}
            <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
                <img
                    src="{{ $event->photo_path ? asset('storage/'.$event->photo_path) : 'https://via.placeholder.com/1200x500' }}"
                    class="w-full h-56 object-cover"
                >

                <div class="p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase
                            {{ $event->status === 'active' ? 'bg-emerald-100 text-emerald-700' :
                               ($event->status === 'upcoming' ? 'bg-sky-100 text-sky-700' :
                                'bg-slate-200 text-slate-700') }}">
                            {{ ucfirst($event->status) }}
                        </span>

                        @if($event->fee)
                            <span class="text-xs text-slate-500">₹{{ $event->fee }}</span>
                        @endif
                    </div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        {{ $event->title }}
                    </h1>

                    <p class="mt-1 text-slate-600">
                        {{ $event->subtitle }}
                    </p>

                    {{-- Dates --}}
                    <div class="mt-4 space-y-1 text-sm text-slate-600">
                        <div>
                            📅 <span class="font-medium">Event:</span>
                            {{ optional($event->start_date)->format('d M Y') }}
                            –
                            {{ optional($event->end_date)->format('d M Y') }}
                        </div>

                        @if($event->submission_start_date || $event->submission_end_date)
                            <div>
                                📝 <span class="font-medium">Registration:</span>
                                {{ optional($event->submission_start_date)->format('d M Y') }}
                                –
                                {{ optional($event->submission_end_date)->format('d M Y') }}
                            </div>
                        @endif
                    </div>

                    <p class="mt-4 text-slate-700 text-sm leading-relaxed">
                        {{ $event->description }}
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Registration Form --}}
        {{-- <div class="lg:col-span-3">

            @if($form)
                <div class="rounded-2xl border bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">
                        Register for this event
                    </h2>

                    @include('client.forms._render', [
                        'form' => $form,
                        'sections' => $sections,
                        'action' => route('events.submit', $event->slug),
                        'enable_conditional_js' => true
                    ])
                </div>
            @else
                <div class="rounded-lg border bg-yellow-50 p-4 text-sm text-yellow-800">
                    Registration form is not available for this event.
                </div>
            @endif

        </div> --}}



        <div class="lg:col-span-3"
x-data="{ submitting: false }">

{{-- SUCCESS STATE --}}
@if(session('success'))
<div class="rounded-2xl border bg-emerald-50 p-6 shadow-sm text-center">
    <h2 class="text-lg font-semibold text-emerald-800">
        Registration Successful 🎉
    </h2>

    <p class="mt-2 text-sm text-emerald-700">
        {{ session('success') }}
    </p>

    <a href="{{ route('events.index') }}"
        class="mt-6 inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">
        ← Back to Events
    </a>
</div>

{{-- FORM STATE --}}
@elseif($form)
<div class="relative rounded-2xl border bg-white p-6 shadow-sm">

    {{-- Submitting Overlay --}}
    <div x-show="submitting" x-transition.opacity
        class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white/80 backdrop-blur-sm rounded-2xl">
        <svg class="h-6 w-6 animate-spin text-emerald-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <p class="text-sm font-medium text-slate-700">
            Submitting your registration…
        </p>
    </div>

    <h2 class="text-lg font-semibold mb-4">
        Register for this event
    </h2>

    <form action="{{ route('events.submit', $event->slug) }}" method="POST" @submit="submitting = true">
        @csrf

        @include('client.forms._render', [
        'form' => $form,
        'sections' => $sections,
        'action' => route('events.submit', $event->slug),
        'enable_conditional_js' => true
        ])
    </form>
</div>

{{-- NO FORM --}}
@else
<div class="rounded-lg border bg-yellow-50 p-4 text-sm text-yellow-800">
    Registration form is not available for this event.
</div>
@endif

</div>


    </div>
</div>
@endsection
