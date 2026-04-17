<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-xl border bg-white p-5"
    x-data="slideImageCropper({
        initialPreview: @js(old('cropped_image') ?: (!empty($slide->image_path) ? asset('storage/' . $slide->image_path) : '')),
        initialCroppedImage: @js(old('cropped_image', '')),
        outputWidth: 1600,
        outputHeight: 900
    })">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-slate-800">Title</label>
            <input name="title" value="{{ old('title', $slide->title ?? '') }}" required
                class="mt-1 block h-11 w-full rounded-lg border px-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-800">Sort Order</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $slide->sort_order ?? 0) }}" required
                class="mt-1 block h-11 w-full rounded-lg border px-3">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-800">Sub-title</label>
            <textarea name="subtitle" rows="3" class="mt-1 block w-full rounded-lg border px-3 py-3">{{ old('subtitle', $slide->subtitle ?? '') }}</textarea>
        </div>

        <div class="md:col-span-2">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start">
                <div class="w-full max-w-xl">
                    <label class="block text-sm font-medium text-slate-800">Slide Image</label>
                    <div class="mt-2 aspect-video overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-slate-100">
                        <template x-if="preview">
                            <img :src="preview" alt="Slide preview" class="h-full w-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="flex h-full items-center justify-center px-4 text-center text-sm text-slate-400">
                                Upload an image to preview the hero slide.
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <label
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16l4-4a3 3 0 014 0l4 4m-7-7l1-1a3 3 0 014 0l1 1m4 5V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7" />
                            </svg>
                            Choose Image
                            <input type="file" name="photo" accept="image/*" class="hidden" x-ref="fileInput"
                                @change="handleFileChange">
                        </label>

                        <button type="button" x-show="sourceImage && !isCropping" x-cloak @click="openCropper()"
                            class="mt-3 inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-white">
                            Adjust Crop
                        </button>

                        <input type="hidden" name="cropped_image" x-model="croppedImage">

                        <p class="mt-3 text-xs leading-relaxed text-slate-500">
                            Every hero image is cropped to a fixed 16:9 ratio so all slides keep the same framing.
                            Upload JPG, PNG, or WEBP up to 5MB.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-show="isCropping"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/75 px-4 py-6"
        @keydown.window.escape="closeCropper()">
        <div class="w-full max-w-5xl rounded-3xl bg-white p-5 shadow-2xl">
            <div class="flex flex-col gap-4 lg:flex-row">
                <div class="flex-1">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Crop Slide Image</h2>
                            <p class="text-sm text-slate-500">Drag to reposition and use zoom to fit the hero frame.</p>
                        </div>
                        <button type="button" @click="closeCropper()" class="rounded-full p-2 text-slate-500 hover:bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="overflow-hidden rounded-2xl bg-slate-950">
                        <div x-ref="cropFrame" class="relative mx-auto aspect-video w-full max-w-4xl overflow-hidden cursor-grab active:cursor-grabbing touch-none"
                            @pointerdown="startDrag" @pointermove="onDrag" @pointerup="stopDrag" @pointerleave="stopDrag"
                            @pointercancel="stopDrag">
                            <template x-if="sourceImage">
                                <img :src="sourceImage" alt="Crop source"
                                    class="pointer-events-none absolute max-w-none select-none"
                                    :style="imageStyle">
                            </template>
                            <div class="pointer-events-none absolute inset-0 ring-1 ring-white/20"></div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-80">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <label class="block text-sm font-medium text-slate-800">Zoom</label>
                        <input type="range" min="1" max="3" step="0.01" x-model="zoomLevel" @input="updateZoom"
                            class="mt-3 w-full">

                        <div class="mt-4 aspect-video overflow-hidden rounded-2xl border bg-slate-200">
                            <template x-if="preview">
                                <img :src="preview" alt="Cropped preview" class="h-full w-full object-cover">
                            </template>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <button type="button" @click="resetCrop()"
                                class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-white">
                                Reset
                            </button>
                            <button type="button" @click="applyCrop()"
                                class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">
                                Apply Crop
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.home-page-slides.index') }}" class="inline-flex items-center rounded border px-4 py-2">
            Cancel
        </a>
        <button type="submit" class="inline-flex items-center rounded bg-emerald-600 px-4 py-2 text-white">
            Save
        </button>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('slideImageCropper', (config) => ({
        preview: config.initialPreview || '',
        croppedImage: config.initialCroppedImage || '',
        sourceImage: config.initialCroppedImage || config.initialPreview || '',
        originalImage: null,
        imageWidth: 0,
        imageHeight: 0,
        baseScale: 1,
        scale: 1,
        zoomLevel: 1,
        offsetX: 0,
        offsetY: 0,
        isCropping: false,
        dragging: false,
        dragStartX: 0,
        dragStartY: 0,
        dragOriginX: 0,
        dragOriginY: 0,
        outputWidth: config.outputWidth,
        outputHeight: config.outputHeight,

        get frameWidth() {
            return this.$refs.cropFrame?.clientWidth || 1;
        },

        get frameHeight() {
            return this.$refs.cropFrame?.clientHeight || 1;
        },

        get imageStyle() {
            return `width:${this.imageWidth * this.scale}px;height:${this.imageHeight * this.scale}px;transform:translate(${this.offsetX}px, ${this.offsetY}px);`;
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                this.sourceImage = e.target.result;
                this.openCropper();
            };
            reader.readAsDataURL(file);
        },

        openCropper() {
            if (!this.sourceImage) {
                return;
            }

            this.isCropping = true;
            this.$nextTick(() => this.prepareImage(this.sourceImage, true));
        },

        closeCropper() {
            this.isCropping = false;
            this.stopDrag();
        },

        prepareImage(src, refreshPreview = false) {
            const image = new Image();
            image.onload = () => {
                this.originalImage = image;
                this.imageWidth = image.naturalWidth;
                this.imageHeight = image.naturalHeight;

                this.baseScale = Math.max(this.frameWidth / this.imageWidth, this.frameHeight / this.imageHeight);
                this.scale = this.baseScale;
                this.zoomLevel = 1;

                const renderedWidth = this.imageWidth * this.scale;
                const renderedHeight = this.imageHeight * this.scale;
                this.offsetX = (this.frameWidth - renderedWidth) / 2;
                this.offsetY = (this.frameHeight - renderedHeight) / 2;

                this.constrainOffsets();

                if (refreshPreview || !this.croppedImage) {
                    this.generateCroppedPreview();
                }
            };
            image.src = src;
        },

        resetCrop() {
            if (this.sourceImage) {
                this.prepareImage(this.sourceImage, true);
            }
        },

        updateZoom() {
            if (!this.originalImage) {
                return;
            }

            const oldScale = this.scale;
            const oldWidth = this.imageWidth * oldScale;
            const oldHeight = this.imageHeight * oldScale;
            const centerX = (this.frameWidth / 2 - this.offsetX) / oldWidth;
            const centerY = (this.frameHeight / 2 - this.offsetY) / oldHeight;

            this.scale = this.baseScale * Number(this.zoomLevel);

            const newWidth = this.imageWidth * this.scale;
            const newHeight = this.imageHeight * this.scale;
            this.offsetX = this.frameWidth / 2 - centerX * newWidth;
            this.offsetY = this.frameHeight / 2 - centerY * newHeight;

            this.constrainOffsets();
            this.generateCroppedPreview();
        },

        startDrag(event) {
            if (!this.originalImage) {
                return;
            }

            this.dragging = true;
            this.dragStartX = event.clientX;
            this.dragStartY = event.clientY;
            this.dragOriginX = this.offsetX;
            this.dragOriginY = this.offsetY;
        },

        onDrag(event) {
            if (!this.dragging) {
                return;
            }

            this.offsetX = this.dragOriginX + (event.clientX - this.dragStartX);
            this.offsetY = this.dragOriginY + (event.clientY - this.dragStartY);
            this.constrainOffsets();
            this.generateCroppedPreview();
        },

        stopDrag() {
            this.dragging = false;
        },

        constrainOffsets() {
            const renderedWidth = this.imageWidth * this.scale;
            const renderedHeight = this.imageHeight * this.scale;
            const minX = Math.min(0, this.frameWidth - renderedWidth);
            const minY = Math.min(0, this.frameHeight - renderedHeight);

            this.offsetX = Math.max(minX, Math.min(0, this.offsetX));
            this.offsetY = Math.max(minY, Math.min(0, this.offsetY));
        },

        generateCroppedPreview() {
            if (!this.originalImage) {
                return;
            }

            const canvas = document.createElement('canvas');
            canvas.width = this.outputWidth;
            canvas.height = this.outputHeight;

            const ctx = canvas.getContext('2d');
            const ratio = this.outputWidth / this.frameWidth;

            ctx.drawImage(
                this.originalImage,
                this.offsetX * ratio,
                this.offsetY * ratio,
                this.imageWidth * this.scale * ratio,
                this.imageHeight * this.scale * ratio
            );

            this.preview = canvas.toDataURL('image/jpeg', 0.92);
            this.croppedImage = this.preview;
        },

        applyCrop() {
            this.generateCroppedPreview();
            this.closeCropper();
        }
    }));
});
</script>
@endpush
