@extends('admin-layout')

@section('page-content')
<div class="mx-auto w-full max-w-7xl px-4">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Events</h1>
            <p class="text-sm text-slate-600">Manage events and view registrations</p>
        </div>

        <a href="{{ route('admin.events.create') }}"
           class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
            + New Event
        </a>
    </div>

    {{-- FILTER BAR --}}
    <form method="GET" class="mb-6 flex flex-wrap items-center gap-3">
        <span class="text-sm font-medium text-slate-700">Filter:</span>

        <select name="status"
                onchange="this.form.submit()"
                class="h-9 rounded-lg border border-slate-300 px-3 text-sm">
            <option value="">All Events</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="upcoming" @selected(request('status') === 'upcoming')>Upcoming</option>
            <option value="expired" @selected(request('status') === 'expired')>Expired</option>
        </select>

        @if(request()->has('status'))
            <a href="{{ route('admin.events.index') }}"
               class="text-xs text-slate-600 underline">
                Clear filter
            </a>
        @endif
    </form>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 rounded-2xl border bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Homepage Event Visibility</h2>
                <p class="mt-1 text-sm text-slate-600">
                    Control whether the Active Events and Upcoming Events sections appear on the client home page.
                </p>
            </div>

            <a href="{{ route('admin.settings.edit') }}" class="text-sm font-medium text-brand-600 hover:underline">
                Open full settings
            </a>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-5 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4">
                    <input type="hidden" name="home_show_active_events" value="0">
                    <input
                        type="checkbox"
                        name="home_show_active_events"
                        value="1"
                        @checked($eventSectionSettings['home_show_active_events'])
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span>
                        <span class="block font-medium text-slate-900">Show active events</span>
                        <span class="block text-sm text-slate-600">Displays the active events section on the home page.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4">
                    <input type="hidden" name="home_show_upcoming_events" value="0">
                    <input
                        type="checkbox"
                        name="home_show_upcoming_events"
                        value="1"
                        @checked($eventSectionSettings['home_show_upcoming_events'])
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span>
                        <span class="block font-medium text-slate-900">Show upcoming events</span>
                        <span class="block text-sm text-slate-600">Displays the upcoming events section on the home page.</span>
                    </span>
                </label>
            </div>

            <button type="submit" class="rounded-lg bg-brand-600 px-5 py-2 text-sm font-semibold text-white">
                Save Visibility
            </button>
        </form>
    </div>

    {{-- EVENTS GRID --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach($events as $event)
            <article class="relative flex flex-col overflow-hidden rounded-2xl border bg-white shadow-sm">

                {{-- EVENT STATUS --}}
                <span class="absolute left-3 top-3 z-10 rounded-full px-3 py-1 text-xs font-semibold uppercase
                    {{ $event->status === 'active' ? 'bg-emerald-600 text-white' :
                       ($event->status === 'upcoming' ? 'bg-sky-600 text-white' :
                        'bg-slate-700 text-white') }}">
                    {{ ucfirst($event->status) }}
                </span>

                {{-- SUBMISSION STATUS --}}
                <span class="absolute right-3 top-3 z-10 rounded-full px-3 py-1 text-xs font-semibold
                    {{ $event->submissionsOpen() ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                    {{ $event->submissionsOpen() ? 'Submissions Open' : 'Submissions Closed' }}
                </span>

                {{-- IMAGE --}}
                <div class="h-40 overflow-hidden">
                    <img
                        src="{{ $event->photo_path ? asset('storage/'.$event->photo_path) : 'https://via.placeholder.com/600x400' }}"
                        class="h-full w-full object-cover"
                        alt="{{ $event->title }}"
                    >
                </div>

                {{-- BODY --}}
                <div class="flex flex-1 flex-col p-4">
                    <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
                    <p class="text-sm text-slate-600">{{ $event->subtitle }}</p>

                    {{-- DATES --}}
                    <div class="mt-3 text-xs text-slate-600 space-y-1">
                        <div>
                            <span class="font-medium">Event:</span>
                            {{ optional($event->start_date)->format('d M Y') }}
                            –
                            {{ optional($event->end_date)->format('d M Y') }}
                        </div>

                        @if($event->submission_start_date || $event->submission_end_date)
                            <div>
                                <span class="font-medium">Submissions:</span>
                                {{ $event->submission_start_date ? \Carbon\Carbon::parse($event->submission_start_date)->format('d M Y') : '—' }}
                                –
                                {{ $event->submission_end_date ? \Carbon\Carbon::parse($event->submission_end_date)->format('d M Y') : '—' }}
                            </div>
                        @endif
                    </div>

                    {{-- PROGRESS BAR --}}
                    @if($event->auto_close_submission)
                        @php
                            $total = $event->submission_limit;
                            $used = $event->submissionsCount();
                            $percent = $total > 0 ? min(100, round(($used / $total) * 100)) : 0;
                        @endphp

                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                <span>Registrations</span>
                                <span>{{ $used }} / {{ $total }}</span>
                            </div>

                            <div class="h-2 w-full rounded-full bg-slate-200 overflow-hidden">
                                <div
                                    class="h-full rounded-full
                                        {{ $percent >= 100 ? 'bg-red-500' :
                                           ($percent >= 80 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                    style="width: {{ $percent }}%">
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ACTIONS --}}
                    <div class="mt-auto pt-4 flex flex-wrap gap-2">
                        <a href="{{ route('admin.submissions.index', ['event_id' => $event->id]) }}"
                           class="rounded bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white">
                            View Submissions ({{ $event->submissionsCount() }})
                        </a>

                        <a href="{{ route('admin.events.edit', $event) }}"
                           class="rounded bg-slate-800 px-3 py-1.5 text-xs font-medium text-white">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.events.destroy', $event) }}"
                              onsubmit="return confirm('Delete this event?')">
                            @csrf
                            @method('DELETE')
                            <button class="rounded bg-red-600 px-3 py-1.5 text-xs font-medium text-white">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-8">
        {{ $events->links() }}
    </div>

</div>
@endsection
