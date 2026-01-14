{{-- <section class="rounded-xl border border-slate-200 bg-white p-5 space-y-4">

    <h3 class="text-sm font-semibold text-slate-800">
        Gallery Images
    </h3>

    <input
        type="file"
        name="gallery_images[]"
        multiple
        class="block w-full text-sm"
    >

    @if($package && $package->gallery->count())
        <div class="grid grid-cols-3 gap-4 mt-4">
            @foreach($package->gallery as $img)
                <div class="relative">
                    <img
                        src="{{ asset('storage/'.$img->image_path) }}"
                        class="h-32 w-full rounded-lg object-cover border"
                    >
                    <label class="absolute top-2 right-2 bg-white rounded px-2 py-1 text-xs">
                        <input
                            type="checkbox"
                            name="delete_gallery[]"
                            value="{{ $img->id }}"
                        >
                        Delete
                    </label>
                </div>
            @endforeach
        </div>
    @endif

</section> --}}


<section class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">
    <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
        Gallery Images
    </h3>

    {{-- Upload new images --}}
    <input
        type="file"
        name="gallery_images[]"
        multiple
        class="block w-full text-sm file:rounded-lg file:border-0
               file:bg-slate-100 file:px-4 file:py-2
               file:text-slate-700 hover:file:bg-slate-200"
    >

    {{-- Existing gallery --}}
    @if(!empty($package['gallery']))
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            @foreach($package['gallery'] as $img)
                <div class="relative group">
                    <img
                        src="{{ asset('storage/'.$img->image_path) }}"
                        class="h-32 w-full rounded-lg object-cover border"
                    >

                    {{-- Delete toggle --}}
                    <label class="absolute top-2 right-2 flex items-center gap-1
                                  bg-white/90 rounded px-2 py-1 text-xs shadow">
                        <input
                            type="checkbox"
                            name="delete_gallery_ids[]"
                            value="{{ $img->id }}"
                            class="text-red-600"
                        >
                        Delete
                    </label>
                </div>
            @endforeach
        </div>
    @endif
</section>

