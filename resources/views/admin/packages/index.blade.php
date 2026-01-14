@extends('admin-layout')

@section('page-content')
<div class="w-full max-w-6xl mx-auto p-4">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Packages</h1>
            <p class="text-sm text-slate-600">Manage tour packages and itineraries</p>
        </div>
        <a href="{{ route('admin.packages.create') }}"
           class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
            + New Package
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($packages as $package)
            <article class="rounded-2xl border bg-white shadow-sm overflow-hidden">
                <img
                    src="{{ $package->thumbnail_image
                        ? asset('storage/'.$package->thumbnail_image)
                        : 'https://via.placeholder.com/600x400' }}"
                    class="h-40 w-full object-cover">

                <div class="p-4">
                    <h3 class="font-semibold text-lg">{{ $package->name }}</h3>
                    <p class="text-sm text-slate-600 mt-1">
                        {{ $package->subtitle }}
                    </p>

                    <div class="mt-3 flex justify-between text-xs text-slate-500">
                        <span>{{ $package->duration_days }} Days</span>
                        <span>{{ $package->is_active ? 'Active' : 'Draft' }}</span>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('admin.packages.edit', $package) }}"
                        class="px-3 py-1 text-xs rounded bg-slate-900 text-white">
                            Edit
                        </a>

                        <a href="{{ route('admin.packages.show', $package) }}"
                        class="px-3 py-1 text-xs rounded border">
                            View
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.packages.destroy', $package) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this package? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-3 py-1 text-xs rounded bg-red-600 text-white hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            </article>
        @empty
            <p class="text-slate-500">No packages created yet.</p>
        @endforelse
    </div>
</div>
@endsection
