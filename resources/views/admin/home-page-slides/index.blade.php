@extends('admin-layout')

@section('page-content')
<div class="mx-auto w-full max-w-7xl px-4 py-8">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Home Page Slide Show</h1>
            <p class="text-sm text-slate-600">Manage the hero slides shown on the public home page.</p>
        </div>

        <a href="{{ route('admin.home-page-slides.create') }}"
            class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
            + Add Slide
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($slides->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
            <h2 class="text-lg font-semibold text-slate-900">No slides added yet</h2>
            <p class="mt-2 text-sm text-slate-600">Create your first slide to replace the default hero banner content.</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($slides as $slide)
                <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
                    <div class="aspect-video overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('storage/' . $slide->image_path) }}"
                            alt="{{ $slide->title }}"
                            class="h-full w-full object-cover"
                        >
                    </div>

                    <div class="space-y-3 p-5">
                        <div class="flex items-center justify-between gap-3">
                            <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-sky-700">
                                Sort: {{ $slide->sort_order }}
                            </span>
                            <span class="text-xs text-slate-400">#{{ $slide->id }}</span>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $slide->title }}</h2>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $slide->subtitle }}</p>
                        </div>

                        <div class="flex flex-wrap gap-2 pt-2">
                            <a href="{{ route('admin.home-page-slides.edit', $slide) }}"
                                class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-medium text-white">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.home-page-slides.destroy', $slide) }}"
                                onsubmit="return confirm('Delete this slide?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $slides->links() }}
        </div>
    @endif
</div>
@endsection
