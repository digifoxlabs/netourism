@extends('admin-layout')

@section('page-content')
<div class="w-full mx-auto max-w-6xl p-4 md:p-6">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-slate-900">
                Forms
            </h1>
            <p class="mt-2 text-sm text-slate-600">
                Manage reusable forms for contact, events, enquiries, and feedback.
            </p>
        </div>

        <a href="{{ route('admin.forms.create') }}"
           class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
            + New Form
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Form</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Slug</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Fields</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Submissions</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($forms as $form)

                    @php
                        $submissionCount = $form->submissions()->count();
                        $isAttachedToEvent = $form->events()->exists();
                    @endphp

                    <tr class="hover:bg-slate-50">
                        {{-- FORM INFO --}}
                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-900">
                                {{ $form->name }}
                            </div>
                            @if($form->description)
                                <div class="mt-1 text-xs text-slate-500 line-clamp-1">
                                    {{ $form->description }}
                                </div>
                            @endif
                        </td>

                        {{-- SLUG --}}
                        <td class="px-4 py-3 align-top text-xs text-slate-600">
                            <span class="font-mono text-[11px] bg-slate-100 px-2 py-1 rounded-lg">
                                {{ $form->slug }}
                            </span>
                        </td>

                        {{-- FIELDS --}}
                        <td class="px-4 py-3 text-center text-xs text-slate-600">
                            {{ $form->fields()->count() }}
                        </td>

                        {{-- SUBMISSIONS --}}
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-medium text-indigo-700 border border-indigo-100">
                                {{ $submissionCount }}
                            </span>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-3 text-center text-xs">
                            @if($form->is_active)
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-1 text-[11px] font-medium text-emerald-700 border border-emerald-100">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-600 border border-slate-200">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-4 py-3 text-right text-xs">
                            <div class="inline-flex flex-wrap justify-end gap-2">

                                {{-- VIEW SUBMISSIONS --}}
                                <a href="{{ route('admin.submissions.index', ['form_id' => $form->id]) }}"
                                   class="rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 font-medium text-indigo-700 hover:bg-indigo-100">
                                    Submissions
                                </a>

                                {{-- PREVIEW --}}
                                <a href="{{ route('admin.forms.preview', $form) }}"
                                   target="_blank"
                                   class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 font-medium text-slate-700 hover:bg-slate-50">
                                    Preview
                                </a>

                                {{-- CLONE --}}
                                <form action="{{ route('admin.forms.clone', $form) }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5 text-[11px] font-medium text-amber-700 hover:bg-amber-100"
                                        onclick="return confirm('Clone this form including all fields?')"
                                    >
                                        Clone
                                    </button>
                                </form>

                                {{-- EDIT --}}
                                <a href="{{ route('admin.forms.edit', $form) }}"
                                   class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 font-medium text-slate-700 hover:bg-slate-50">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                @if($isAttachedToEvent)
                                    <span
                                        class="rounded-lg border border-slate-200 bg-slate-100 px-3 py-1.5 text-[11px] font-medium text-slate-400 cursor-not-allowed"
                                        title="This form is attached to one or more events."
                                    >
                                        Delete
                                    </span>
                                @else
                                    <form action="{{ route('admin.forms.destroy', $form) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this form permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-[11px] font-medium text-red-700 hover:bg-red-100"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">
                            No forms created yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $forms->links() }}
        </div>
    </div>
</div>
@endsection
