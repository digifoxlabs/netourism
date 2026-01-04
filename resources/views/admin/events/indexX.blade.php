@extends('admin-layout')

@section('page-content')
<div class="max-w-7xl mx-auto p-4">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Events</h1>
            <p class="text-sm text-slate-600">Manage events and view registrations</p>
        </div>
        <a href="{{ route('admin.events.create') }}"
           class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
            + New Event
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach($events as $event)
            <article class="group relative flex flex-col overflow-hidden rounded-2xl border bg-white shadow-sm">

                {{-- STATUS BADGE --}}
                <div class="absolute left-3 top-3 z-10 rounded-full px-3 py-1 text-xs font-semibold uppercase
                    {{ $event->status === 'active' ? 'bg-emerald-600 text-white' :
                       ($event->status === 'upcoming' ? 'bg-sky-600 text-white' :
                        'bg-slate-700 text-white') }}">
                    {{ ucfirst($event->status) }}
                </div>

                {{-- SUBMISSION OPEN / CLOSED --}}
                <div class="absolute right-3 top-3 z-10 rounded-full px-3 py-1 text-xs font-semibold
                    {{ $event->submissionsOpen() ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                    {{ $event->submissionsOpen() ? 'Submissions Open' : 'Submissions Closed' }}
                </div>

                {{-- IMAGE --}}
                <div class="h-40 overflow-hidden">
                    <img src="{{ $event->photo_path ? asset('storage/'.$event->photo_path) : 'https://via.placeholder.com/600x400' }}"
                         class="h-full w-full object-cover group-hover:scale-105 transition">
                </div>

                {{-- BODY --}}
                <div class="flex flex-1 flex-col p-4">
                    <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
                    <p class="text-sm text-slate-600">{{ $event->subtitle }}</p>

                    {{-- EVENT DATES --}}
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

                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                              onsubmit="return confirm('Delete this event?')">
                            @csrf @method('DELETE')
                            <button class="rounded bg-red-600 px-3 py-1.5 text-xs font-medium text-white">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>
@endsection
