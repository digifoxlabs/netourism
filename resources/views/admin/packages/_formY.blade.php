<div class="max-w-6xl mx-auto p-4 space-y-6" x-data="packageBuilder(@js($package ?? null))" x-init="init()">
    <h1 class="text-2xl font-bold">{{ $title }}</h1>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" @submit="serializeItinerary"
        class="bg-white rounded-2xl border p-6 space-y-6">
        @csrf
        @if($method !== 'POST') @method($method) @endif

        {{-- BASIC INFO --}}
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="label">Package Name</label>
                <input name="name" x-model="name" class="input w-full" required>
            </div>

            <div>
                <label class="label">Subtitle</label>
                <input name="subtitle" x-model="subtitle" class="input w-full">
            </div>

            <div>
                <label class="label">Duration (Days)</label>
                <input type="number" name="duration_days" x-model="duration_days" class="input w-full">
            </div>

            <label class="flex items-center gap-2 mt-6">
                <input type="checkbox" name="is_active" value="1" x-model="is_active">
                Active
            </label>
        </div>

        {{-- DESCRIPTION --}}
        <section class="rounded-xl border border-slate-200 bg-white p-5 space-y-3">
            <h3 class="text-sm font-semibold text-slate-800">
                Package Description
            </h3>

            <textarea id="package-description" name="description" rows="8"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description', $package->description ?? '') }}</textarea>
        </section>

        {{-- IMAGES --}}
        @include('admin.packages._images')

        {{-- ITINERARY --}}
        @include('admin.packages._itinerary')

        {{-- GALLERY --}}
        @include('admin.packages._gallery')

        {{-- HIDDEN --}}
        <input type="hidden" name="itinerary_json" x-model="itineraryJson">

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.packages.index') }}" class="btn-secondary">
                Cancel
            </a>
            <button class="btn-primary">
                Save Package
            </button>
        </div>
    </form>
</div>