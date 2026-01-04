@extends('client-layout')

@section('page-content')

{{-- <div class="max-w-6xl mx-auto px-4 py-8">



@include('client.forms._render', [
'form' => $form,
'sections' => $sections,
'action' => route('forms.submit', $form->slug),
'enable_conditional_js' => true
])



</div> --}}

{{-- ================= HERO ================= --}}
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-teal-800 to-indigo-900"></div>
    <div class="absolute inset-0 bg-black/40"></div>

    {{-- Decorative blobs --}}
    <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-emerald-400/30 blur-3xl"></div>
    <div class="absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-indigo-400/30 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 py-32 text-white">
        <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-1 text-xs font-semibold tracking-wide">
            Partner Program
        </span>

        <h1 class="mt-6 text-4xl md:text-6xl font-extrabold leading-tight">
            Partner with Us<br>
            <span class="text-emerald-300">Explore the Unexplored</span>
        </h1>

        <p class="mt-6 max-w-2xl text-lg text-white/90">
            Join the Northeast India Tourism Affiliate Program and help tell
            authentic stories from the Seven Sisters and Sikkim.
        </p>
    </div>
</section>

{{-- ================= INTRO ================= --}}
<section class="bg-gradient-to-b from-white via-slate-50 to-white">
    <div class="max-w-6xl mx-auto px-4 py-20">
        <div class="grid gap-12 lg:grid-cols-2 items-center">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">
                    Join the Northeast India Tourism Affiliate Program
                </h2>

                <p class="mt-4 text-slate-600 leading-relaxed">
                    Are you a travel blogger, content creator, or a passionate explorer
                    of the Seven Sisters and Sikkim? Do you have an audience that craves
                    authentic, offbeat experiences?
                </p>

                <p class="mt-4 text-slate-600 leading-relaxed">
                    At <strong>NE Tourism</strong>, we believe the beauty of Northeast India
                    is best shared through authentic voices. We work with partners who
                    care about culture, community, and responsible travel.
                </p>
            </div>

            {{-- Highlight Card --}}
            <div class="rounded-3xl bg-white shadow-xl border p-8">
                <h3 class="text-lg font-semibold text-emerald-700">
                    Why This Matters
                </h3>

                <p class="mt-3 text-sm text-slate-600">
                    You’re not just promoting trips — you’re helping sustain
                    local communities, preserve traditions, and spotlight
                    destinations still untouched by mass tourism.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ================= BENEFITS ================= --}}
<section class="bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 py-20">
        <h2 class="text-3xl font-bold text-center text-slate-900">
            Why Partner With Us?
        </h2>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @php
            $benefits = [
            ['title' => 'Generative Commissions', 'color' => 'emerald', 'text' => 'Earn competitive commissions on every
            successful booking.'],
            ['title' => 'Exclusive Experiences', 'color' => 'indigo', 'text' => 'Get early access to new itineraries and
            fam trips.'],
            ['title' => 'Marketing Support', 'color' => 'teal', 'text' => 'We provide banners, photos, and insider
            travel content.'],
            ['title' => 'Cultural Impact', 'color' => 'amber', 'text' => 'Support sustainable tourism benefiting local
            communities.'],
            ];
            @endphp

            @foreach($benefits as $b)
            <div class="rounded-2xl bg-white border shadow-sm p-6 hover:shadow-lg transition">
                <h4 class="font-semibold text-{{ $b['color'] }}-700">
                    {{ $b['title'] }}
                </h4>
                <p class="mt-3 text-sm text-slate-600">
                    {{ $b['text'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= WHO WE WANT ================= --}}
<section class="bg-white">
    <div class="max-w-5xl mx-auto px-4 py-20">
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-10">
            <h2 class="text-2xl font-bold text-emerald-900">
                Who We Are Looking For
            </h2>

            <p class="mt-4 text-slate-700 leading-relaxed">
                We value quality and storytelling over numbers. Whether you are a
                YouTuber, blogger, website owner, or Instagram creator — if you
                genuinely love the Northeast, we want to hear from you.
            </p>

            <p class="mt-4 text-sm italic text-emerald-800">
                Note: We prioritize partners with a real connection to travel,
                culture, or North Eastern heritage.
            </p>
        </div>
    </div>
</section>

{{-- ================= FORM ================= --}}
<section class="bg-gradient-to-br from-slate-900 to-slate-800">
    <div class="max-w-6xl mx-auto px-4 py-24">
        <div class="rounded-3xl bg-white shadow-2xl p-8 md:p-12">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900">
                    Become a Partner Today
                </h2>
                <p class="mt-2 text-slate-600">
                    Fill out the form below. Our team personally reviews every application.
                </p>
            </div>

            @if($form)
            {{-- render form --}}
            {{-- FORM --}}
            @include('client.forms._render', [
            'form' => $form,
            'sections' => $sections,
            'action' => route('forms.submit', $form->slug),
            'enable_conditional_js' => true
            ])
            @else
            <div class="mt-6 rounded-xl border bg-yellow-50 p-4 text-sm text-yellow-800">
                Partner application form is currently unavailable. Please check back later.
            </div>
            @endif

        </div>

        {{-- How It Works --}}
        <div class="mt-10 rounded-2xl border bg-white p-6 md:p-8">
            <h2 class="text-xl font-semibold text-slate-900">
                How It Works
            </h2>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="flex gap-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700">
                        1
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900">
                            Sign Up
                        </h4>
                        <p class="mt-1 text-sm text-slate-600">
                            Submit your details using the partner application form.
                        </p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700">
                        2
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900">
                            Get Approved
                        </h4>
                        <p class="mt-1 text-sm text-slate-600">
                            Our team reviews your profile and Instagram or content channels.
                        </p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700">
                        3
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900">
                            Share & Earn
                        </h4>
                        <p class="mt-1 text-sm text-slate-600">
                            Promote using your unique link across bio, stories, or blog posts.
                        </p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700">
                        4
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900">
                            Track Results
                        </h4>
                        <p class="mt-1 text-sm text-slate-600">
                            Access your partner dashboard to monitor clicks and earnings in real time.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Closing CTA --}}
        <div class="mt-8 rounded-2xl border border-emerald-200 bg-emerald-50 p-6 md:p-8 text-center">
            <h3 class="text-lg font-semibold text-emerald-900">
                Ready to put the Northeast on the map?
            </h3>
            <p class="mt-2 text-sm text-emerald-800 max-w-2xl mx-auto">
                Submit your information and let’s start a journey together — sharing authentic stories
                and experiences from one of India’s most beautiful regions.
            </p>
        </div>

    </div>
</section>

@endsection