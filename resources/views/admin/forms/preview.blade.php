@extends('admin-layout')

@section('page-content')
<div class="mx-auto w-full max-w-5xl p-4 md:p-6" x-data="conditionalForm()">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-slate-900">
                Preview: {{ $form->name }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">
                Interactive preview of the form. Inputs are clickable; submit is disabled.
            </p>
        </div>
    </div>

    @if($form->description)
        <div class="mb-4 rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm text-slate-700">
            {{ $form->description }}
        </div>
    @endif

    {{-- No real action/CSRF needed here; this is just UI preview --}}
    <form class="space-y-6" @submit.prevent>
        @foreach($sections as $sectionTitle => $fields)
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 md:p-6">
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-slate-900">
                        {{ $sectionTitle }}
                    </h2>
                    <div class="mt-1 h-px w-10 bg-emerald-500 rounded-full"></div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    @foreach($fields as $field)
                        @php
                            $colClass   = ($field->width === 'half') ? '' : 'md:col-span-2';
                            $name       = $field->name;
                            $condField  = $field->conditional_enabled ? $field->conditional_field : null;
                            $condOp     = $field->conditional_enabled ? $field->conditional_operator : null;
                            $condVal    = $field->conditional_enabled ? $field->conditional_value : null;

                            $type = 'text';
                            if ($field->type === 'tel')    $type = 'tel';
                            if ($field->type === 'number') $type = 'number';
                            if ($field->type === 'date')   $type = 'date';
                            if ($field->type === 'email')  $type = 'email';
                        @endphp

                        <div
                            class="{{ $colClass }}"
                            @if($condField && $condOp && $condVal)
                                x-show="checkCondition('{{ $condField }}', '{{ $condOp }}', '{{ addslashes($condVal) }}')"
                                x-cloak
                            @endif
                        >
                            <label class="block text-sm font-medium text-slate-800 mb-1">
                                {{ $field->label }}
                                @if($field->required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            @switch($field->type)
                                @case('textarea')
                                    <textarea
                                        rows="3"
                                        x-model="formData['{{ $name }}']"
                                        class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-800 bg-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                        placeholder="{{ $field->placeholder }}"
                                    ></textarea>
                                    @break

                                @case('select')
                                    <select
                                        x-model="formData['{{ $name }}']"
                                        class="mt-1 block w-full h-11 md:h-12 rounded-lg border border-slate-300 px-3 md:px-4 text-sm text-slate-800 bg-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    >
                                        <option value="">
                                            {{ $field->placeholder ?: 'Select an option' }}
                                        </option>
                                        @if(is_array($field->options))
                                            @foreach($field->options as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @break

                                @case('radio')
                                    <div class="mt-1 space-y-1">
                                        @if(is_array($field->options))
                                            @foreach($field->options as $opt)
                                                <label class="flex items-center gap-2 text-sm text-slate-800">
                                                    <input
                                                        type="radio"
                                                        value="{{ $opt }}"
                                                        x-model="formData['{{ $name }}']"
                                                        class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                    >
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                    @break

                                @case('checkbox')
                                    <div class="mt-1 space-y-1">
                                        @if(is_array($field->options) && count($field->options))
                                            @foreach($field->options as $opt)
                                                <label class="flex items-center gap-2 text-sm text-slate-800">
                                                    <input
                                                        type="checkbox"
                                                        value="{{ $opt }}"
                                                        x-model="formData['{{ $name }}']"
                                                        class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                    >
                                                    <span>{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        @else
                                            <label class="flex items-center gap-2 text-sm text-slate-800">
                                                <input
                                                    type="checkbox"
                                                    value="1"
                                                    x-model="formData['{{ $name }}']"
                                                    class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                >
                                                <span>{{ $field->placeholder ?: 'Checkbox' }}</span>
                                            </label>
                                        @endif
                                    </div>
                                    @break

                                @case('email')
                                @case('number')
                                @case('tel')
                                @case('date')
                                @case('text')
                                @default
                                    <input
                                        type="{{ $type }}"
                                        x-model="formData['{{ $name }}']"
                                        class="mt-1 block w-full h-11 md:h-12 rounded-lg border border-slate-300 px-3 md:px-4 text-sm text-slate-800 bg-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                        placeholder="{{ $field->placeholder }}"
                                    >
                            @endswitch

                            @if($field->help_text)
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $field->help_text }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="pt-4 border-t border-dashed border-slate-200 mt-4 flex justify-end">
            <button
                type="button"
                disabled
                class="inline-flex items-center rounded-lg bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm opacity-60 cursor-not-allowed"
            >
                Submit (preview only)
            </button>
        </div>
    </form>
</div>

{{-- Alpine helpers for conditional preview --}}
<script>
    function conditionalForm() {
        return {
            formData: {},

            /**
             * Decide whether to show a field based on another field's value.
             * field: controlling field name
             * op:    equals | not_equals | contains | not_contains
             * value: string to compare against
             */
            checkCondition(field, op, value) {
                const current = this.formData[field];

                // Checkbox groups: arrays
                if (Array.isArray(current)) {
                    if (op === 'contains')      return current.includes(value);
                    if (op === 'not_contains')  return !current.includes(value);

                    const joined = current.join(',');
                    if (op === 'equals')        return joined === value;
                    if (op === 'not_equals')    return joined !== value;

                    return true;
                }

                // Single values: text, select, radio, single checkbox
                switch (op) {
                    case 'equals':
                        return current == value;
                    case 'not_equals':
                        return current != value;
                    case 'contains':
                        return (current ?? '').toString().includes(value);
                    case 'not_contains':
                        return !(current ?? '').toString().includes(value);
                    default:
                        return true;
                }
            },
        };
    }
</script>
@endsection
