@extends('admin-layout')

@section('page-content')
<div class="max-w-6xl mx-auto p-4 md:p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $package->name }}
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                {{ $package->subtitle }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.packages.edit', $package) }}"
               class="inline-flex items-center rounded-lg border border-blue-300 px-4 py-2 text-sm font-semibold text-blue-700 hover:bg-blue-50">
                Edit Package
            </a>

            <a href="{{ route('admin.packages.index') }}"
               class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Back to list
            </a>
        </div>
    </div>

    {{-- STATUS --}}
    <div class="flex flex-wrap gap-3 text-sm">
        <span class="inline-flex items-center rounded-full px-3 py-1 font-medium
            {{ $package->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
            {{ $package->is_active ? 'Active' : 'Inactive' }}
        </span>

        @if($package->duration_days)
            <span class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 border text-slate-700">
                {{ $package->duration_days }} Days
            </span>
        @endif
    </div>

    {{-- IMAGES --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-4">
            Package Images
        </h2>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-2">Thumbnail</p>
                @if($package->thumbnail_image)
                    <img src="{{ asset('storage/'.$package->thumbnail_image) }}"
                         class="h-40 w-full rounded-lg object-cover border">
                @else
                    <p class="text-xs text-slate-400">No thumbnail uploaded</p>
                @endif
            </div>

            <div>
                <p class="text-xs font-medium text-slate-500 mb-2">Hero Image</p>
                @if($package->hero_image)
                    <img src="{{ asset('storage/'.$package->hero_image) }}"
                         class="h-40 w-full rounded-lg object-cover border">
                @else
                    <p class="text-xs text-slate-400">No hero image uploaded</p>
                @endif
            </div>
        </div>
    </section>

    {{-- DESCRIPTION --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            Package Description
        </h2>

        <div class="prose prose-slate max-w-none text-sm">
            {!! $package->description !!}
        </div>
    </section>

    {{-- ITINERARY --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-4">
            Itinerary
        </h2>

        @forelse($itinerary as $index => $day)
            <div class="mb-4 rounded-lg border bg-slate-50 p-4">
                <div class="flex items-center justify-between mb-1">
                    <strong class="text-slate-900">
                        Day {{ $index + 1 }} – {{ $day['title'] ?? '' }}
                    </strong>
                </div>

                <p class="text-sm text-slate-700 leading-relaxed">
                    {{ $day['description'] ?? '' }}
                </p>
            </div>
        @empty
            <p class="text-sm text-slate-500">
                No itinerary added.
            </p>
        @endforelse
    </section>

    {{-- GALLERY --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-800 mb-4">
            Gallery
        </h2>

        @if($package->gallery && $package->gallery->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($package->gallery as $image)
                    <img src="{{ asset('storage/'.$image->image_path) }}"
                         class="h-32 w-full rounded-lg object-cover border">
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-500">
                No gallery images uploaded.
            </p>
        @endif
    </section>

</div>
@endsection
