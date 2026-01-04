@extends('admin-layout')

@section('page-content')

<div class="w-full mx-auto max-w-4xl px-4 py-8 lg:py-10">

    {{-- HEADER --}}
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Edit Submission #{{ $submission->id }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Form: {{ $submission->form->name ?? '—' }}
                @if($submission->event)
                    • Event: {{ $submission->event->title }}
                @endif
            </p>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Submission Status
            </label>
            <select
                name="status"
                form="submissionForm"
                class="h-9 rounded-lg border border-slate-300 px-3 text-sm"
            >
                <option value="pending" @selected(($submission->status ?? 'pending') === 'pending')>
                    Pending
                </option>
                <option value="confirmed" @selected($submission->status === 'confirmed')>
                    Confirmed
                </option>
            </select>
        </div>
    </div>

    {{-- FORM --}}
    <form
        id="submissionForm"
        action="{{ route('admin.submissions.update', $submission) }}"
        method="POST"
        class="space-y-6"
    >
        @csrf
        @method('PUT')

        {{-- SECTION-WISE FIELDS --}}
        @foreach($sections as $sectionTitle => $fields)
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h2 class="mb-4 text-sm font-semibold text-slate-800">
                    {{ $sectionTitle }}
                </h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($fields as $field)
                        @php
                            $value = $submission->data[$field->name] ?? null;
                        @endphp

                        <div class="{{ $field->width === 'full' ? 'sm:col-span-2' : '' }}">
                            <label class="block text-sm font-medium text-slate-800 mb-1">
                                {{ $field->label }}
                                @if($field->required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            {{-- TEXT / EMAIL / NUMBER / DATE --}}
                            @if(in_array($field->type, ['text','email','number','date']))
                                <input
                                    type="{{ $field->type }}"
                                    name="{{ $field->name }}"
                                    value="{{ old($field->name, $value) }}"
                                    class="block w-full h-11 rounded-lg border px-3"
                                >

                            {{-- TEXTAREA --}}
                            @elseif($field->type === 'textarea')
                                <textarea
                                    name="{{ $field->name }}"
                                    rows="3"
                                    class="block w-full rounded-lg border px-3"
                                >{{ old($field->name, $value) }}</textarea>

                            {{-- SELECT --}}
                            @elseif($field->type === 'select')
                                <select
                                    name="{{ $field->name }}"
                                    class="block w-full h-11 rounded-lg border px-3"
                                >
                                    <option value="">— Select —</option>
                                    @foreach($field->options ?? [] as $option)
                                        <option value="{{ $option }}"
                                            @selected($value == $option)>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>

                            {{-- RADIO --}}
                            @elseif($field->type === 'radio')
                                <div class="space-y-1">
                                    @foreach($field->options ?? [] as $option)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input
                                                type="radio"
                                                name="{{ $field->name }}"
                                                value="{{ $option }}"
                                                @checked($value == $option)
                                            >
                                            {{ $option }}
                                        </label>
                                    @endforeach
                                </div>

                            {{-- CHECKBOX --}}
                            @elseif($field->type === 'checkbox')
                                @php
                                    $valueArray = is_array($value) ? $value : [];
                                @endphp
                                <div class="space-y-1">
                                    @foreach($field->options ?? [] as $option)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input
                                                type="checkbox"
                                                name="{{ $field->name }}[]"
                                                value="{{ $option }}"
                                                @checked(in_array($option, $valueArray))
                                            >
                                            {{ $option }}
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            @if($field->help_text)
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $field->help_text }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- ACTIONS --}}
        <div class="flex justify-end gap-2 pt-4">
            <a href="{{ route('admin.submissions.show', $submission) }}"
               class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500"
            >
                Save Changes
            </button>
        </div>

    </form>

</div>

@endsection
