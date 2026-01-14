<section
    class="rounded-2xl border border-slate-200 bg-white p-6 space-y-6"
    x-data="packageImagePreview()"
>

    <div>
        <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
            Package Images
        </h3>
        <p class="mt-1 text-xs text-slate-500">
            Control how the package appears across listings and detail pages.
        </p>
    </div>

    <div class="grid gap-6 md:grid-cols-2">

        {{-- ================= THUMBNAIL IMAGE ================= --}}
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-slate-700">
                    Thumbnail Image
                </label>
                <p class="text-xs text-slate-400">
                    Card view image · Recommended ratio <strong>4:3</strong>
                </p>
            </div>

            <div
                class="relative overflow-hidden rounded-xl border-2 border-dashed border-slate-300
                       bg-slate-50 hover:border-emerald-400 transition cursor-pointer"
                @click="$refs.thumbnail.click()"
            >
                <input
                    type="file"
                    name="thumbnail_image"
                    accept="image/*"
                    x-ref="thumbnail"
                    @change="previewImage($event, 'thumbnail')"
                    class="hidden"
                >

                {{-- Preview --}}
                <template x-if="thumbnailPreview">
                    <div class="relative">
                        <img
                            :src="thumbnailPreview"
                            class="h-44 w-full object-cover"
                        >

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition">
                            <span class="rounded-lg bg-white px-3 py-1 text-xs font-semibold text-slate-800">
                                Replace Image
                            </span>
                        </div>

                        {{-- Ratio Hint --}}
                        <div class="absolute top-2 left-2 rounded-full bg-black/60 px-2 py-0.5 text-[10px] text-white">
                            4 : 3
                        </div>
                    </div>
                </template>

                {{-- Empty State --}}
                <template x-if="!thumbnailPreview">
                    <div class="flex flex-col items-center justify-center h-44 text-center px-4">
                        <div class="text-sm font-medium text-slate-700">
                            Click to upload thumbnail
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            PNG / JPG · Max 5MB
                        </div>
                    </div>
                </template>
            </div>

            {{-- Existing Image (edit mode) --}}
            @if(!empty($package?->thumbnail_image))
                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.store('existingThumbnail', '{{ asset('storage/'.$package->thumbnail_image) }}');
                    });
                </script>
            @endif
        </div>

        {{-- ================= HERO IMAGE ================= --}}
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-slate-700">
                    Hero Image
                </label>
                <p class="text-xs text-slate-400">
                    Package header image · Recommended ratio <strong>16:9</strong>
                </p>
            </div>

            <div
                class="relative overflow-hidden rounded-xl border-2 border-dashed border-slate-300
                       bg-slate-50 hover:border-emerald-400 transition cursor-pointer"
                @click="$refs.hero.click()"
            >
                <input
                    type="file"
                    name="hero_image"
                    accept="image/*"
                    x-ref="hero"
                    @change="previewImage($event, 'hero')"
                    class="hidden"
                >

                {{-- Preview --}}
                <template x-if="heroPreview">
                    <div class="relative">
                        <img
                            :src="heroPreview"
                            class="h-44 w-full object-cover"
                        >

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition">
                            <span class="rounded-lg bg-white px-3 py-1 text-xs font-semibold text-slate-800">
                                Replace Image
                            </span>
                        </div>

                        {{-- Ratio Hint --}}
                        <div class="absolute top-2 left-2 rounded-full bg-black/60 px-2 py-0.5 text-[10px] text-white">
                            16 : 9
                        </div>
                    </div>
                </template>

                {{-- Empty State --}}
                <template x-if="!heroPreview">
                    <div class="flex flex-col items-center justify-center h-44 text-center px-4">
                        <div class="text-sm font-medium text-slate-700">
                            Click to upload hero image
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            Wide image recommended
                        </div>
                    </div>
                </template>
            </div>

            {{-- Existing Image (edit mode) --}}
            @if(!empty($package?->hero_image))
                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.store('existingHero', '{{ asset('storage/'.$package->hero_image) }}');
                    });
                </script>
            @endif
        </div>

    </div>

</section>

{{-- ================= Alpine Helper ================= --}}
<script>
function packageImagePreview() {
    return {
        thumbnailPreview: Alpine.store('existingThumbnail') || null,
        heroPreview: Alpine.store('existingHero') || null,

        previewImage(event, type) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => {
                if (type === 'thumbnail') this.thumbnailPreview = e.target.result;
                if (type === 'hero') this.heroPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>
