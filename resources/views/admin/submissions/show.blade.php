{{-- @extends('admin-layout')

@section('page-content')
<div class="max-w-3xl mx-auto p-4 bg-white rounded-xl border">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-lg font-semibold">Submission #{{ $submission->id }}</h1>
            <p class="text-sm text-slate-500">Form: {{ $submission->form->name ?? '—' }} • Event: {{ $submission->event->title ?? '—' }}</p>
            <p class="text-xs text-slate-400 mt-1">Submitted at: {{ $submission->created_at }}</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.submissions.edit', $submission) }}" class="inline-flex items-center px-3 py-1 border rounded">Edit</a>
            <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Delete submission?');">
                @csrf @method('DELETE')
                <button class="inline-flex items-center px-3 py-1 rounded bg-red-50 text-red-700">Delete</button>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <h2 class="text-sm font-medium">Answers</h2>
        <pre class="mt-2 p-3 bg-slate-50 rounded text-xs">{{ json_encode($submission->data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
</div>
@endsection --}}

@extends('admin-layout')

@section('page-content')

<div class="w-full mx-auto max-w-4xl px-4 py-8 lg:py-10">

    {{-- HEADER --}}
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Submission #{{ $submission->id }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Form: {{ $submission->form->name ?? '—' }}
                @if($submission->event)
                    • Event: {{ $submission->event->title }}
                @endif
            </p>
            <p class="text-xs text-slate-400 mt-1">
                Submitted at {{ $submission->created_at->format('d M Y, h:i A') }}
            </p>
        </div>

        {{-- STATUS + ACTIONS --}}
        <div class="flex gap-2 items-center">

            @php
                $status = $submission->status ?? 'pending';
                $statusClasses = match ($status) {
                    'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                    default     => 'bg-slate-50 text-slate-700 border-slate-200',
                };
            @endphp

            <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                Status: {{ ucfirst($status) }}
            </span>

            <a href="{{ route('admin.submissions.edit', $submission) }}"
               class="inline-flex items-center rounded-lg border border-blue-300 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50">
                Edit
            </a>

            <form action="{{ route('admin.submissions.destroy', $submission) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this submission?');">
                @csrf
                @method('DELETE')
                <button class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- FORM DATA (SECTION WISE) --}}
    @foreach($sections as $sectionTitle => $fields)
        <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <h2 class="mb-3 text-sm font-semibold text-slate-800">
                {{ $sectionTitle }}
            </h2>

            <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                @foreach($fields as $field)
                    @php
                        $value = $submission->data[$field->name] ?? null;

                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
                    @endphp

                    <div class="{{ $field->width === 'full' ? 'sm:col-span-2' : '' }}">
                        <dt class="text-slate-500">
                            {{ $field->label }}
                        </dt>
                        <dd class="mt-1 font-medium text-slate-900 whitespace-pre-line">
                            {{ $value ?: '—' }}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    @endforeach

    {{-- CONFIRM ACTION --}}
    {{-- @if(($submission->status ?? 'pending') === 'pending')
        <div class="mt-6 flex justify-end">
            <form method="POST"
                  action="{{ route('admin.submissions.confirm', $submission) }}"
                  onsubmit="return confirm('Confirm this submission?');">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500"
                >
                    Confirm Submission
                </button>
            </form>
        </div>
    @endif --}}

    @if($submission->status === 'pending' && $submission->event)
        <form
            method="POST"
            action="{{ route('admin.submissions.confirm', $submission) }}"
            class="mt-6 flex justify-end"
        >
            @csrf
            <button
                type="submit"
                class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white"
            >
                Confirm & Send Email
            </button>
        </form>
    @endif

</div>

@endsection

