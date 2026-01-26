@extends('client-layout')

@section('page-content')
<div class="w-full max-w-6xl mx-auto px-4 py-10 space-y-10">

    {{-- Hero --}}
    <div class="rounded-2xl overflow-hidden">
        <img src="{{ $package->hero_image
? asset('storage/'.$package->hero_image)
: 'https://via.placeholder.com/1200x600' }}" class="w-full h-[420px] object-cover">
    </div>

    {{-- Info --}}
    <div class="grid lg:grid-cols-3 gap-10">

        {{-- Left --}}
        <div class="lg:col-span-2 space-y-6">
            <h1 class="text-3xl font-bold">{{ $package->name }}</h1>

            <p class="text-slate-600 text-lg">
                {{ $package->subtitle }}
            </p>

            <div class="prose max-w-none">
                {!! $package->description !!}
            </div>

            {{-- Itinerary --}}
            @if(!empty($package->itinerary))
            <div class="space-y-4">
                <h2 class="text-xl font-semibold">Itinerary</h2>

                @foreach($package->itinerary as $i => $day)
                <div class="rounded-xl border p-4">
                    <h3 class="font-semibold">
                        Day {{ $i + 1 }} – {{ $day['title'] }}
                    </h3>
                    <p class="text-sm text-slate-600 mt-1">
                        {{ $day['description'] }}
                    </p>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Right --}}
        <aside class="space-y-4">
            <div class="rounded-xl border p-5">
                <p class="text-sm text-slate-500">Duration</p>
                <p class="text-lg font-semibold">
                    {{ $package->duration_days }} Days
                </p>
            </div>

            @if($package->form)


            {{-- Enquiry Modal --}}
            <div x-data="{ open: false }" x-cloak>
                {{-- Button --}}
                <button @click="open = true"
                    class="inline-flex items-center rounded-xl bg-brand-600 px-6 py-3 font-semibold text-white hover:bg-brand-500">
                    Enquire Now
                </button>

                {{-- Modal --}}
                {{-- <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
                    <div @click.outside="open = false"
                        class="relative w-full max-w-3xl rounded-2xl bg-white p-6 shadow-xl">
                        <button @click="open = false"
                            class="absolute right-4 top-4 text-slate-400 hover:text-slate-700">
                            ✕
                        </button>

                        <h2 class="mb-4 text-xl font-semibold">
                            Enquire about {{ $package->name }}
                        </h2>

                        @if($form)
                        @include('client.forms._render', [
                        'form' => $form,
                        'sections' => $sections,
                        'action' => route('forms.submit',$package->form->slug),
                        'enable_conditional_js' => true,
                        ])
                        @else
                        <div class="rounded-lg border bg-slate-50 p-4 text-sm text-slate-600">
                            Enquiry form is not available for this package.
                        </div>
                        @endif
                    </div>
                </div> --}}


{{-- Modal --}}
<div
    x-show="open"
    x-transition.opacity
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-3 sm:px-6"
>
    <div
        @click.outside="open = true"
        class="relative w-full max-w-3xl bg-white rounded-2xl shadow-xl
               max-h-[90vh] flex flex-col overflow-hidden"
    >

        {{-- Header --}}
        <div class="sticky top-0 z-10 flex items-center justify-between
                    border-b bg-white px-6 py-4">
            <h2 class="text-sm font-semibold">
                Enquire about {{ $package->name }}
            </h2>

            <button
                @click="open = false"
                class="text-slate-400 hover:text-slate-700 text-2xl leading-none"
                aria-label="Close"
            >
                &times;
            </button>
        </div>

        {{-- Scrollable Content --}}
        <div class="flex-1 overflow-y-auto px-6 py-4">
            @if($form)
                @include('client.forms._render', [
                    'form' => $form,
                    'sections' => $sections,
                    'action' => route('forms.submit',$package->form->slug),
                    'enable_conditional_js' => true,
                ])
            @else
                <div class="rounded-lg border bg-slate-50 p-4 text-sm text-slate-600">
                    Enquiry form is not available for this package.
                </div>
            @endif
        </div>

    </div>
</div>


            </div>
            @endif

        </aside>
    </div>

{{-- Gallery --}}
@if($package->gallery->count())
<div
    x-data="{
        open: false,
        images: @js($package->gallery->map(fn($g) => asset('storage/'.$g->image_path))),
        index: 0,

        show(i) {
            this.index = i;
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        close() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        },
        next() {
            this.index = (this.index + 1) % this.images.length;
        },
        prev() {
            this.index = (this.index - 1 + this.images.length) % this.images.length;
        }
    }"
    @keydown.escape.window="close"
    @keydown.arrow-right.window="next"
    @keydown.arrow-left.window="prev"
    class="mt-10"
>
    <h2 class="text-xl font-semibold mb-4">Gallery</h2>

    {{-- Thumbnails --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($package->gallery as $i => $img)
            <button
                type="button"
                @click="show({{ $i }})"
                class="group relative overflow-hidden rounded-xl border bg-slate-100"
            >
                <img
                    src="{{ asset('storage/'.$img->image_path) }}"
                    class="h-40 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    alt="Gallery image"
                >

                {{-- Hover overlay --}}
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                    <span class="text-white text-xs font-semibold opacity-0 group-hover:opacity-100">
                        View
                    </span>
                </div>
            </button>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <div
        x-show="open"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/90"
    >
        {{-- Close --}}
        <button
            @click="close"
            class="absolute top-5 right-5 text-white/80 hover:text-white text-3xl"
        >
            ×
        </button>

        {{-- Prev --}}
        <button
            @click="prev"
            class="absolute left-4 md:left-10 text-white/80 hover:text-white text-4xl"
        >
            ‹
        </button>

        {{-- Image --}}
        <div class="max-w-6xl w-full px-4">
            <img
                :src="images[index]"
                class="mx-auto max-h-[85vh] rounded-xl shadow-2xl"
                alt="Preview"
            >

            {{-- Counter --}}
            <div class="mt-3 text-center text-xs text-white/70">
                <span x-text="index + 1"></span> / <span x-text="images.length"></span>
            </div>
        </div>

        {{-- Next --}}
        <button
            @click="next"
            class="absolute right-4 md:right-10 text-white/80 hover:text-white text-4xl"
        >
            ›
        </button>
    </div>
</div>
@endif


</div>
@endsection