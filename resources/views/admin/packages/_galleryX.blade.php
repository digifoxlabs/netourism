<section
    class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4"
    x-data="galleryUploader()"
>

    {{-- Header --}}
    <div>
        <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
            Gallery Images
        </h3>
        <p class="mt-1 text-xs text-slate-500">
            Upload multiple images to showcase the experience. These appear on the public package page.
        </p>
    </div>

    {{-- Upload --}}
    <div>
        <label
            class="flex cursor-pointer items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center hover:bg-slate-100 transition"
        >
            <input
                type="file"
                name="gallery_images[]"
                multiple
                accept="image/*"
                class="hidden"
                @change="handleFiles"
            >
            <div>
                <p class="text-sm font-medium text-slate-700">
                    Click to upload gallery images
                </p>
                <p class="mt-1 text-xs text-slate-500">
                    JPG, PNG · Recommended 16:9 or 4:3
                </p>
            </div>
        </label>
    </div>

    {{-- NEW FILE PREVIEW --}}
    <template x-if="previews.length">
        <div>
            <p class="text-xs font-semibold text-slate-600 mb-2">
                New Images (will be uploaded)
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <template x-for="(src, index) in previews" :key="index">
                    <div class="relative group">
                        <img
                            :src="src"
                            class="h-28 w-full rounded-lg object-cover border"
                        >

                        <button
                            type="button"
                            @click="removePreview(index)"
                            class="absolute top-2 right-2 rounded-full bg-black/60 p-1 text-white opacity-0 group-hover:opacity-100 transition"
                            title="Remove"
                        >
                            ✕
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>

    {{-- EXISTING GALLERY --}}
    @if($package && $package->gallery && $package->gallery->count())
        <div>
            <p class="text-xs font-semibold text-slate-600 mb-2">
                Existing Images
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($package->gallery as $img)
                    <div class="relative group">

                        <img
                            src="{{ asset('storage/'.$img->image_path) }}"
                            class="h-28 w-full rounded-lg object-cover border"
                        >

                        {{-- Delete toggle --}}
                        <label
                            class="absolute inset-0 flex items-center justify-center bg-black/60 text-white text-xs font-semibold opacity-0 group-hover:opacity-100 transition cursor-pointer rounded-lg"
                        >
                            <input
                                type="checkbox"
                                name="delete_gallery_images[]"
                                value="{{ $img->id }}"
                                class="hidden"
                            >
                            Mark for delete
                        </label>

                    </div>
                @endforeach
            </div>

            <p class="mt-2 text-[11px] text-slate-500">
                Hover an image and click to mark it for deletion. Changes apply on save.
            </p>
        </div>
    @endif

</section>

{{-- Alpine helper --}}
<script>
    function galleryUploader() {
        return {
            previews: [],
            files: [],

            handleFiles(event) {
                const selected = Array.from(event.target.files);
                selected.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        this.previews.push(e.target.result);
                        this.files.push(file);
                    };
                    reader.readAsDataURL(file);
                });
            },

            removePreview(index) {
                this.previews.splice(index, 1);
                this.files.splice(index, 1);
            }
        };
    }
</script>
