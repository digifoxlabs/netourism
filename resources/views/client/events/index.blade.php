@extends('client-layout')

@section('page-content')

<div class="max-w-6xl mx-auto px-4 py-8">


    {{-- Page Header --}}
    <header class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                    Events & Rides
                </h1>
                <p class="mt-2 text-sm md:text-base text-slate-600">
                    Explore active, upcoming, and past events curated by Netourism and partner communities.
                </p>
            </div>
        </div>
    </header>

    <div class="space-y-10">

        {{-- ACTIVE EVENTS --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">Active Events</h2>
                <span
                    class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 border border-emerald-100">
                    Currently running
                </span>
            </div>

            @if($active->isEmpty())
            <p class="text-sm text-slate-500">No active events right now.</p>
            @endif

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($active as $event)
                <article
                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-emerald-300 bg-emerald-50/80 shadow-sm ring-1 ring-emerald-200">

                    {{-- Badge --}}
                    <div
                        class="absolute left-3 top-3 z-10 inline-flex items-center gap-1 rounded-full bg-emerald-600/95 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-50 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-200 animate-pulse"></span>
                        Active
                    </div>

                    {{-- Image --}}
                    <a href="{{ route('events.show', $event->slug) }}"
                        class="relative h-40 w-full overflow-hidden block">
                        <img src="{{ $event->photo_path ? asset('storage/'.$event->photo_path) : 'https://images.pexels.com/photos/1005417/pexels-photo-1005417.jpeg?auto=compress&cs=tinysrgb&w=1200' }}"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div
                            class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent opacity-80">
                        </div>

                        <div class="absolute bottom-3 left-3 right-3 text-xs text-slate-50">
                            <div class="font-semibold">
                                {{ optional($event->start_date)->format('d M') }}
                                –
                                {{ optional($event->end_date)->format('d M Y') }}
                            </div>
                            <div class="text-[11px] text-slate-200">
                                {!! $event->subtitle !!}
                            </div>
                        </div>
                    </a>

                    {{-- Body --}}
                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                            <a href="{{ route('events.show', $event->slug) }}">
                                {{ $event->title }}
                            </a>
                        </h3>

                        {{-- Dates --}}
                        <div class="mt-2 space-y-1 text-xs text-slate-600">
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

                        <p class="mt-3 text-sm text-slate-700 line-clamp-3">
                            {!! Str::limit($event->description, 140) !!}
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <a href="{{ route('events.show', $event->slug) }}"
                                class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-xs md:text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                                Register now
                            </a>

                            <span class="text-xs text-slate-500">
                                {{ $event->fee ? '₹'.$event->fee : '' }}
                            </span>
                        </div>
                    </div>

                </article>
                @endforeach
            </div>
        </section>

        {{-- UPCOMING EVENTS --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">Upcoming Events</h2>
                <span
                    class="inline-flex items-center rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-700 border border-sky-100">
                    Plan ahead
                </span>
            </div>

            @if($upcoming->isEmpty())
            <p class="text-sm text-slate-500">No upcoming events scheduled.</p>
            @endif

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($upcoming as $event)
                <article
                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition">

                    {{-- Image --}}
                    <a href="{{ route('events.show', $event->slug) }}"
                        class="relative h-40 w-full overflow-hidden block">
                        <img src="{{ $event->photo_path ? asset('storage/'.$event->photo_path) : 'https://images.pexels.com/photos/2101154/pexels-photo-2101154.jpeg?auto=compress&cs=tinysrgb&w=1200' }}"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">

                        <div
                            class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/55 via-slate-950/5 to-transparent opacity-80">
                        </div>

                        <div
                            class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-xs text-slate-50">
                            <div>
                                <span class="font-semibold">
                                    {{ optional($event->start_date)->format('d M Y') }}
                                </span>
                                <div class="text-[11px] text-slate-200">
                                    {{ $event->subtitle }}
                                </div>
                            </div>

                            <span
                                class="inline-flex items-center rounded-full bg-sky-500/95 px-2 py-1 text-[11px] font-semibold uppercase">
                                Upcoming
                            </span>
                        </div>
                    </a>

                    {{-- Body --}}
                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                            <a href="{{ route('events.show', $event->slug) }}">
                                {{ $event->title }}
                            </a>
                        </h3>

                        {{-- Dates --}}
                        <div class="mt-2 space-y-1 text-xs text-slate-600">
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

                        <p class="mt-3 text-sm text-slate-700 line-clamp-3">
                            {!! Str::limit($event->description, 140) !!}
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <a href="{{ route('events.show', $event->slug) }}"
                                class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-xs md:text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                                View details
                            </a>

                            <span class="text-xs text-slate-500">
                                Registrations opening soon
                            </span>
                        </div>
                    </div>

                </article>
                @endforeach
            </div>
        </section>

        {{-- PAST EVENTS --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">Past Events</h2>
                <span
                    class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600 border border-slate-200">
                    Completed journeys
                </span>
            </div>

            @if($past->isEmpty())
            <p class="text-sm text-slate-500">No past events available.</p>
            @endif

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($past as $event)
                <article
                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">

                    <a href="{{ route('events.show', $event->slug) }}"
                        class="relative h-40 w-full overflow-hidden block grayscale group-hover:grayscale-0 transition">
                        <img src="{{ $event->photo_path ? asset('storage/'.$event->photo_path) : 'https://images.pexels.com/photos/3729464/pexels-photo-3729464.jpeg?auto=compress&cs=tinysrgb&w=1200' }}"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div
                            class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent opacity-80">
                        </div>

                        <div class="absolute bottom-3 left-3 right-3 text-xs text-slate-50 flex justify-between">
                            <div>
                                <span class="font-semibold">
                                    {{ optional($event->start_date)->format('d M') }}
                                    –
                                    {{ optional($event->end_date)->format('d M Y') }}
                                </span>
                                <div class="text-[11px] text-slate-200">{{ $event->subtitle }}</div>
                            </div>

                            <span
                                class="inline-flex items-center rounded-full bg-slate-700/95 px-2 py-1 text-[11px] font-semibold uppercase">
                                Completed
                            </span>
                        </div>
                    </a>
                    {{--
                        <div class="flex flex-1 flex-col p-4">
                            <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                                <a href="{{ route('events.show', $event->slug) }}">
                    {{ $event->title }}
                    </a>
                    </h3>

                    <p class="mt-2 text-sm text-slate-700 line-clamp-3">
                        {{ Str::limit($event->description, 140) }}
                    </p>

                    <div class="mt-4 flex items-center justify-between text-xs text-slate-600">
                        <span>{{ optional($event->start_date)->format('d M Y') }}</span>
                        <span
                            class="inline-flex items-center rounded-full bg-white px-2 py-1 text-[11px] font-medium text-slate-500 border border-slate-200">Archive</span>
                    </div>
            </div> --}}

            <div class="flex flex-1 flex-col p-4">
                <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                    <a href="{{ route('events.show', $event->slug) }}">
                        {{ $event->title }}
                    </a>
                </h3>

                {{-- Dates --}}
                <div class="mt-2 space-y-1 text-xs text-slate-600">
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

                <p class="mt-3 text-sm text-slate-700 line-clamp-3">
                    {!! Str::limit($event->description, 140) !!}
                </p>

                <div class="mt-4 flex items-center justify-between text-xs text-slate-600">
                    <span class="inline-flex items-center rounded-full bg-white px-2 py-1 border border-slate-200">
                        Archived
                    </span>
                </div>
            </div>

            </article>
            @endforeach
    </div>
    </section>

</div>
</div>
@endsection