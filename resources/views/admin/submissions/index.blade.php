@extends('admin-layout')

@section('page-content')
<div class="w-full max-w-6xl mx-auto p-4">
    {{-- Header --}}
    <div class="flex flex-col gap-4 mb-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Form Submissions</h1>
            <p class="text-sm text-slate-500">
                View and manage all form and event submissions
            </p>
        </div>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-2 items-center">
            <select name="form_id" class="h-9 rounded-lg border px-3 text-sm">
                <option value="">All Forms</option>
                @foreach($forms as $f)
                    <option value="{{ $f->id }}" @selected(request('form_id') == $f->id)>
                        {{ $f->name }}
                    </option>
                @endforeach
            </select>

            <select name="event_id" class="h-9 rounded-lg border px-3 text-sm">
                <option value="">All Events</option>
                @foreach($events as $e)
                    <option value="{{ $e->id }}" @selected(request('event_id') == $e->id)>
                        {{ $e->title }}
                    </option>
                @endforeach
            </select>

            {{-- Status filter --}}
            <select name="status" class="h-9 rounded-lg border px-3 text-sm">
                <option value="">All Status</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmed</option>
            </select>

            <button class="h-9 rounded-lg bg-slate-800 px-4 text-sm font-semibold text-white hover:bg-slate-700">
                Filter
            </button>
        </form>
    </div>

    {{-- Bulk actions --}}
    <div class="mb-3 flex flex-wrap items-center justify-between gap-3">

        {{-- CSV Export --}}
        <a href="{{ route('admin.submissions.export.csv', request()->query()) }}"
            class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
            Export CSV
        </a>

        <a href="{{ route('admin.submissions.export.excel', request()->query()) }}"
            class="rounded-lg border px-3 py-1.5 text-sm">
            Export Excel
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                
             
                    <th class="p-3 text-left font-medium text-slate-600">When</th>
                    <th class="p-3 text-left font-medium text-slate-600">Form</th>
                    <th class="p-3 text-left font-medium text-slate-600">Event</th>
                    <th class="p-3 text-left font-medium text-slate-600">Status</th>
                    <th class="p-3 text-left font-medium text-slate-600">Summary</th>
                    <th class="p-3 text-right font-medium text-slate-600">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($submissions as $s)
                    <tr class="hover:bg-slate-50">
                        {{-- Row checkbox --}}
              

                        <td class="p-3 whitespace-nowrap">
                            {{ $s->created_at->format('d M Y') }}
                            <div class="text-xs text-slate-400">
                                {{ $s->created_at->format('H:i') }}
                            </div>
                        </td>

                        <td class="p-3">
                            {{ $s->form->name ?? '—' }}
                        </td>

                        <td class="p-3">
                            {{ $s->event->title ?? '—' }}
                        </td>

                        {{-- Status --}}
                        <td class="p-3">
                            @php
                                $statusClasses = match ($s->status) {
                                    'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                                    default     => 'bg-slate-100 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                {{ ucfirst($s->status) }}
                            </span>
                        </td>

                        {{-- Summary --}}
                        <td class="p-3 text-xs text-slate-600 max-w-xs">
                            @php
                                $preview = collect($s->data)->take(3)->map(function($v, $k) {
                                    return $k . ': ' . (is_array($v) ? implode(',', $v) : $v);
                                })->join(' | ');
                            @endphp
                            {{ $preview }}
                        </td>

                        {{-- Actions --}}
                        <td class="p-3 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-2">
                                <a
                                    href="{{ route('admin.submissions.show', $s) }}"
                                    class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('admin.submissions.edit', $s) }}"
                                    class="inline-flex items-center rounded-lg border border-blue-300 bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.submissions.destroy', $s) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Delete submission?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center rounded-lg border border-red-300 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-slate-500">
                            No submissions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $submissions->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
