<div class="w-full max-w-6xl mx-auto p-4 md:p-6 space-y-8" x-data="packageBuilder(@js($package))">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
                {{ $title }}
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                Create and manage travel packages with itinerary and gallery
            </p>
        </div>
    </div>

    @if ($errors->any())
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-semibold mb-2">
            Please fix the errors below:
        </p>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" @submit="serializeItinerary"
        class="bg-white rounded-2xl border border-slate-200 shadow-sm space-y-8">
        @csrf
        @if($method !== 'POST') @method($method) @endif

        {{-- ================= BASIC INFO ================= --}}
        <section class="px-6 pt-6 space-y-4">
            <h2 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
                Basic Information
            </h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Package Name <span class="text-red-500">*</span>
                    </label>
                    <input name="name" x-model="name" required placeholder="Meghalaya Explorer – 7 Days" class="w-full h-11 rounded-lg border border-slate-300 px-4 text-sm
                               focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Subtitle
                    </label>
                    <input name="subtitle" x-model="subtitle" placeholder="Waterfalls • Culture • Adventure" class="w-full h-11 rounded-lg border border-slate-300 px-4 text-sm
                               focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Duration (Days)
                    </label>
                    <input type="number" name="duration_days" x-model="duration_days" placeholder="7" class="w-full h-11 rounded-lg border border-slate-300 px-4 text-sm
                               focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <input type="checkbox" name="is_active" value="1" x-model="is_active"
                        class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-sm font-medium text-slate-700">
                        Active (visible on public site)
                    </span>
                </div>
            </div>
        </section>



{{-- ENQUIRY FORM --}}
<section class="rounded-xl border border-slate-200 bg-white p-5 space-y-3">
    <h3 class="text-sm font-semibold text-slate-800">
        Enquiry Form
    </h3>

    <p class="text-xs text-slate-500">
        Select a form to be shown when users click “Enquire Now” on this package.
    </p>

    <select
        name="form_id"
        class="w-full h-11 rounded-lg border border-slate-300 px-3 text-sm"
    >
        <option value="">— No form —</option>

        @foreach($forms as $form)
            <option value="{{ $form->id }}"
                @selected(old('form_id', $package->form_id ?? null) == $form->id)
            >
                {{ $form->name }}
            </option>
        @endforeach
    </select>
</section>











        {{-- ================= DESCRIPTION ================= --}}
        <section class="px-6 space-y-3">
            <h2 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
                Package Description
            </h2>

            <div class="rounded-xl border border-slate-300 overflow-hidden
                        focus-within:ring-2 focus-within:ring-emerald-200">
                <textarea id="package-description" name="description" rows="8"
                    class="w-full px-4 py-3 text-sm text-slate-800 leading-relaxed">{{ old('description', $package->description ?? '') }}</textarea>
            </div>

            <p class="text-xs text-slate-500">
                This content appears on the public package detail page.
            </p>
        </section>

        {{-- ================= IMAGES ================= --}}
        <section class="px-6 space-y-3">
            <h2 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
                Images
            </h2>

            @include('admin.packages._images')
        </section>

        {{-- ================= ITINERARY ================= --}}
        <section class="px-6 space-y-3">
            <h2 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
                Itinerary Builder
            </h2>

            @include('admin.packages._itinerary')
        </section>

        {{-- ================= GALLERY ================= --}}
        <section class="px-6 space-y-3">
            <h2 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
                Gallery
            </h2>

            @include('admin.packages._gallery')
        </section>

        {{-- Hidden --}}
        <input type="hidden" name="itinerary_json" x-model="itineraryJson">

        {{-- ================= ACTIONS ================= --}}
        <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-200 bg-slate-50 rounded-b-2xl">
            <a href="{{ route('admin.packages.index') }}"
                class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                Cancel
            </a>

            <button type="submit"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                Save Package
            </button>
        </div>
    </form>
</div>