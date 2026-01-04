@extends('client-layout')

@section('page-content')



<!-- ================= HERO SLIDER (FULL WIDTH) ================= -->
  <section class="relative z-0 w-full">
    <div class="relative overflow-hidden bg-gray-100">
      <div id="sliderTrack" class="flex transition-transform duration-500 ease-out will-change-transform">
        <div class="relative min-w-full h-[60vh] md:h-[80vh]">
          <img src="images/image1.jpg" alt="Slide 1" class="absolute inset-0 w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/40"></div>
          <div class="relative z-10 h-full flex flex-col items-start justify-center p-6 md:p-20 text-white">
            <h1 class="text-3xl md:text-6xl font-extrabold leading-tight">Explore the Untouched Northeast</h1>
            <p class="mt-4 md:mt-6 text-lg md:text-xl max-w-2xl text-white/90">From misty mountains to living root bridges—experience landscapes and culture found nowhere else in the world.</p>
          </div>
        </div>
        <div class="relative min-w-full h-[60vh] md:h-[80vh]">
          <img src="images/image2.jpg" alt="Slide 2" class="absolute inset-0 w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/40"></div>
          <div class="relative z-10 h-full flex flex-col items-start justify-center p-6 md:p-20 text-white">
            <h2 class="text-3xl md:text-6xl font-extrabold leading-tight">Adventure Meets Serenity</h2>
            <p class="mt-4 md:mt-6 text-lg md:text-xl max-w-2xl text-white/90">Curated journeys across mountains, forests, waterfalls, and festivals—crafted for explorers of all kinds.</p>
          </div>
        </div>
        <div class="relative min-w-full h-[60vh] md:h-[80vh]">
          <img src="images/image3.jpg" alt="Slide 3" class="absolute inset-0 w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/40"></div>
          <div class="relative z-10 h-full flex flex-col items-start justify-center p-6 md:p-20 text-white">
            <h2 class="text-3xl md:text-6xl font-extrabold leading-tight">Travel Beyond the Ordinary</h2>
            <p class="mt-4 md:mt-6 text-lg md:text-xl max-w-2xl text-white/90">Personalized trips with trusted local experts—adventure, culture, wildlife, and pristine natural beauty.</p>
          </div>
        </div>
      </div>

      <button id="prevBtn" class="absolute left-3 top-1/2 -translate-y-1/2 inline-flex items-center justify-center h-10 w-10 rounded-full bg-white/90 hover:bg-white shadow" title="Previous slide" aria-label="Previous slide">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button id="nextBtn" class="absolute right-3 top-1/2 -translate-y-1/2 inline-flex items-center justify-center h-10 w-10 rounded-full bg-white/90 hover:bg-white shadow" title="Next slide" aria-label="Next slide">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg>
      </button>

      <div id="dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2"></div>
    </div>
  </section>

  <!-- ================= CTA: Book Now ================= -->

<section id="booknow-cta" class="bg-brand-600 text-white">
    <div class="container py-8 flex flex-col sm:flex-row items-center justify-between gap-6">

        <div class="text-center sm:text-left">
            <h3 class="text-2xl font-bold">Ready to explore Northeast India?</h3>
            <p class="text-white/90">Tailor-made trips • Trusted local experts • 24×7 support</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">

            {{-- Event Registration Button --}}
            <a href="{{ route('events.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-white/40
                       px-6 py-3 font-semibold
                       bg-white/10 backdrop-blur-sm hover:bg-white/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                     <path d="M12 6v6l4 2"/>
                </svg>
                Event Registration
            </a>

            {{-- Book Now Button (kept as is) --}}
            <a href="#contact"
                class="inline-flex items-center gap-2 rounded-xl bg-white text-brand-600
                       px-6 py-3 font-semibold hover:bg-brand-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2">
                     <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
                Book Now
            </a>

        </div>
    </div>
</section>







  {{-- <!-- ================= INTRO ================= -->
  <section id="intro" class="container py-16">
    <div class="max-w-3xl">
      <h2 class="text-3xl md:text-4xl font-extrabold">Intro</h2>
      <p class="mt-4 text-gray-700 leading-relaxed">1Northeast India invites you to explore the uncharted natural beauty and rich culture across its seven unique states, from the Himalayas to tea gardens. We offer tailored itineraries, diverse accommodations, and activities like trekking and festivals to help you experience the best of our heritage, cuisine, and adventure.</p>
    </div>
  </section> --}}

  <!-- ================= PARTNERS ================= -->
<section id="partners" class="container py-16">
  <div class="max-w-6xl mx-auto">

    <!-- Heading -->
    <div class="mb-8">
      <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">
        Our Partners
      </h2>
      <p class="mt-3 max-w-2xl text-gray-700 leading-relaxed">
        We collaborate with trusted brands, communities, and local experts to deliver authentic,
        safe, and memorable experiences across Northeast India.
      </p>
    </div>

    <!-- Logos Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 items-center">

      <!-- Logo Card -->
<div class="flex items-center justify-center rounded-xl border border-slate-200 bg-white p-4 h-20
            transition-all duration-300 hover:border-emerald-400 hover:shadow-md hover:-translate-y-0.5">
    <img
        src="/images/partners/bookmyshow.png"
        alt="BookMyShow"
        class="max-h-10 transition-transform duration-300 hover:scale-105"
    >
</div>

<div class="flex items-center justify-center rounded-xl border border-slate-200 bg-white p-4 h-20
            transition-all duration-300 hover:border-emerald-400 hover:shadow-md hover:-translate-y-0.5">
    <img
        src="/images/partners/makemytrip.svg"
        alt="MakeMyTrip"
        class="max-h-10 transition-transform duration-300 hover:scale-105"
    >
</div>



    </div>

  </div>
</section>


  <!-- ================= SEVEN SISTERS ================= -->
  <section id="seven-sisters" class="bg-gray-50 border-y">
    <div class="container py-16">
      <div class="max-w-3xl mb-8">
        <h2 class="text-3xl md:text-4xl font-extrabold">Seven Sisters of Northeast India</h2>
        <p class="mt-4 text-gray-700">A quick look at each sister state—its charm and focus for travelers.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <h3 class="text-xl font-bold">Arunachal Pradesh</h3>
          <p class="text-sm text-brand-600 font-semibold mt-1">Land of the Rising Sun</p>
          <p class="mt-3 text-gray-600">The first Indian soil to greet the sun's rays.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <h3 class="text-xl font-bold">Assam</h3>
          <p class="text-sm text-brand-600 font-semibold mt-1">Tea, Wildlife, and Heritage</p>
          <p class="mt-3 text-gray-600">Home to world-famous tea gardens and the one-horned rhino.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <h3 class="text-xl font-bold">Meghalaya</h3>
          <p class="text-sm text-brand-600 font-semibold mt-1">Abode of the Clouds</p>
          <p class="mt-3 text-gray-600">Known for high rainfall, living root bridges, and waterfalls.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <h3 class="text-xl font-bold">Manipur</h3>
          <p class="text-sm text-brand-600 font-semibold mt-1">Jewel of India</p>
          <p class="mt-3 text-gray-600">Celebrated for natural beauty and classical dance forms.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <h3 class="text-xl font-bold">Mizoram</h3>
          <p class="text-sm text-brand-600 font-semibold mt-1">Land of the Highlanders</p>
          <p class="mt-3 text-gray-600">Diverse tribal culture and scenic hilly terrain.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <h3 class="text-xl font-bold">Nagaland</h3>
          <p class="text-sm text-brand-600 font-semibold mt-1">Land of Festivals</p>
          <p class="mt-3 text-gray-600">Vibrant traditional festivals, especially the Hornbill Festival.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm sm:col-span-2 lg:col-span-1">
          <h3 class="text-xl font-bold">Tripura</h3>
          <p class="text-sm text-brand-600 font-semibold mt-1">A Blend of History and Nature</p>
          <p class="mt-3 text-gray-600">Royal palaces, ancient temples, and beautiful landscapes.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ================= BEST TIME TO TRAVEL ================= -->
  <section id="best-time" class="container py-16">
    <div class="max-w-4xl">
      <h2 class="text-3xl md:text-4xl font-extrabold">Best Time to Travel</h2>
      <p class="mt-4 text-gray-700">The ideal window is generally <span class="font-semibold">October–May</span> to avoid the heaviest monsoon rains. Pick a season based on your interests.</p>

      <div class="mt-8 overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b bg-gray-50">
              <th class="py-3 px-4">Season</th>
              <th class="py-3 px-4">Months</th>
              <th class="py-3 px-4">Weather & Activities</th>
              <th class="py-3 px-4">Ideal For</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <tr class="border-b">
              <td class="py-3 px-4 font-medium">Winter (Peak)</td>
              <td class="py-3 px-4">Oct–Feb</td>
              <td class="py-3 px-4">Dry, clear skies; cool/cold; snow at higher elevations.</td>
              <td class="py-3 px-4">Festivals (Hornbill), safaris (Kaziranga), photography, snow.</td>
            </tr>
            <tr class="border-b">
              <td class="py-3 px-4 font-medium">Spring/Summer</td>
              <td class="py-3 px-4">Mar–May</td>
              <td class="py-3 px-4">Pleasant temps; flowers in bloom.</td>
              <td class="py-3 px-4">Trekking, adventure sports, culture.</td>
            </tr>
            <tr>
              <td class="py-3 px-4 font-medium">Monsoon (Low)</td>
              <td class="py-3 px-4">Jun–Sep</td>
              <td class="py-3 px-4">Heavy rain; dramatic waterfalls; possible delays/closures.</td>
              <td class="py-3 px-4">Lush landscapes, quiet travel; many parks closed.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <ul class="mt-6 space-y-2 text-gray-700 list-disc pl-6">
        <li><span class="font-semibold">Trekkers:</span> March, April, September, October for clear views and dry trails.</li>
        <li><span class="font-semibold">Wildlife:</span> October–May (Kaziranga and other parks closed in monsoon).</li>
        <li><span class="font-semibold">Festivals:</span> Late November–December for the Hornbill Festival in Nagaland.</li>
      </ul>
    </div>
  </section>

  <!-- ================= PLANNING YOUR TRIP ================= -->
  <section id="planning" class="bg-gray-50 border-y">
    <div class="container py-16">
      <div class="max-w-3xl mb-8">
        <h2 class="text-3xl md:text-4xl font-extrabold">Planning Your Trip to Northeast India</h2>
        <p class="mt-4 text-gray-700">We focus on three pillars to craft your perfect journey.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-brand-600 text-white">1</div>
          <h3 class="mt-4 text-xl font-bold">Itineraries</h3>
          <p class="mt-2 text-gray-600">Flexible, personalized plans that match your pace and passions—adventure, culture, or wildlife.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-brand-600 text-white">2</div>
          <h3 class="mt-4 text-xl font-bold">Accommodations</h3>
          <p class="mt-2 text-gray-600">From budget stays to premium resorts—we find the right comfort for your budget.</p>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
          <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-brand-600 text-white">3</div>
          <h3 class="mt-4 text-xl font-bold">Activities</h3>
          <p class="mt-2 text-gray-600">Trekking, wildlife, and adventure sports—plus culture, cuisine, and shopping on request.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ================= PACKAGES ================= -->
  <section id="packages" class="container py-16">
    <div class="flex items-end justify-between mb-6">
      <div>
        <h2 class="text-3xl md:text-4xl font-extrabold">Packages</h2>
        <p class="mt-2 text-gray-700">Hand-picked routes and experiences across the Northeast.</p>
      </div>
      <a href="#contact" class="hidden sm:inline-flex items-center rounded-xl border px-4 py-2 hover:bg-gray-50">View All</a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/meghalaya.jpg" alt="Meghalaya waterfalls" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Meghalaya Explorer</h3>
          <p class="text-sm text-gray-600 mt-1">Waterfalls • Caves • Living Root Bridges</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/assam.jpg" alt="Kaziranga Safari" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Assam Safari</h3>
          <p class="text-sm text-gray-600 mt-1">Kaziranga • Tea Gardens • River Cruise</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/arunachal.jpg" alt="Arunachal mountains" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Arunachal Peaks</h3>
          <p class="text-sm text-gray-600 mt-1">Monasteries • High Passes • Snow Views</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/nagaland.jpg" alt="Nagaland festival" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Nagaland Festivals</h3>
          <p class="text-sm text-gray-600 mt-1">Hornbill • Heritage • Hills</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/manipur.jpg" alt="Manipur lake" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Manipur Serenity</h3>
          <p class="text-sm text-gray-600 mt-1">Loktak Lake • Culture • Crafts</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/mizoram.jpg" alt="Mizoram hills" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Mizoram Trails</h3>
          <p class="text-sm text-gray-600 mt-1">Hills • Villages • Cuisine</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/tripura.jpg" alt="Tripura palace" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Tripura Heritage</h3>
          <p class="text-sm text-gray-600 mt-1">Palaces • Temples • Forests</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/bhutan.jpg" alt="Bhutan" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Bhutan</h3>
          <p class="text-sm text-gray-600 mt-1">Signature highlights across all states</p>
        </div>
      </article>

      <article class="group rounded-2xl overflow-hidden border bg-white shadow-sm">
        <div class="aspect-[3/4] overflow-hidden">
          <img class="w-full h-full object-cover group-hover:scale-105 transition" src="images/sikkim.jpg" alt="Sikkim" />
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Sikkim</h3>
          <p class="text-sm text-gray-600 mt-1">Signature highlights across all states</p>
        </div>
      </article>
    </div>

    <div class="mt-8 text-center">
      <a href="#contact" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 text-white px-6 py-3 font-semibold hover:bg-brand-500 transition">Customize Your Package</a>
    </div>
  </section>
<!-- ================= CONTACT INFO & MAP (2-column, animated map) ================= -->
<section id="contact" class="relative bg-gray-900 text-white w-full">
  <div class="py-16 px-4 md:px-8 lg:px-12 max-w-[1600px] mx-auto">

    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-3xl md:text-4xl font-extrabold">Contact</h2>
      <p class="mt-2 text-white/80">
        Tell us your dates, interests, and group size. We’ll craft a proposal tailored to you.
      </p>
    </div>

    <!-- TWO-COLUMN: Info (left) | Map (right) -->
    <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 md:items-start">

      <!-- LEFT: Info Panel -->
      <aside class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur p-6">
        <h3 class="text-xl font-semibold">Talk to a trip planner</h3>
        <p class="mt-2 text-white/80">Available 7 days a week, 9:00–19:00 IST</p>

        <div class="mt-6 space-y-4 text-sm">

          <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92V21a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2 4.18 2 2 0 0 1 4 2h4.09a1 1 0 0 1 1 .75l1 3.73a1 1 0 0 1-.27 1L8.91 9.91a16 16 0 0 0 6 6l2.43-1.91a1 1 0 0 1 1-.27l3.73 1a1 1 0 0 1 .75 1z"/></svg>
            <div>
              <p class="font-medium">Phone / WhatsApp</p>
              <p class="text-white/80">+91-6001553100</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
            <div>
              <p class="font-medium">Email</p>
              <p class="text-white/80">hello@netourism.com</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.134 2 5 5.134 5 9c0 7 7 13 7 13s7-6 7-13c0-3.866-3.134-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
            <div>
              <p class="font-medium">Office</p>
              <p class="text-white/80">Hno-42, PNGB Road, Gotanagar, Tetelia, Guwahati-781011</p>
            </div>
          </div>
        </div>

        <div class="mt-6 rounded-xl bg-white/5 border border-white/10 p-4 text-sm">
          <p class="text-white/80">We typically respond within a few hours. Your details are kept private and never shared.</p>
        </div>
      </aside>

      <!-- RIGHT: Map card (animated) -->



<div class="rounded-2xl overflow-hidden border bg-white/5 shadow-sm"
     aria-hidden="false"
     role="region"
     aria-label="Location map">

  <div class="p-4 border-b border-white/10 bg-white/5">
    <h4 class="font-semibold">Our Location</h4>
    <p class="text-sm text-white/80">Hno-42, PNGB Road, Gotanagar, Tetelia, Guwahati-781011</p>
  </div>

  <!-- Animation CSS -->
  <style>
    @media (prefers-reduced-motion: reduce) {
      .map-animate { animation: none !important; opacity: 1 !important; transform: none !important; }
    }
    @keyframes mapFadeUp {
      0%   { opacity: 0; transform: translateY(18px) scale(0.995); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    .map-animate {
      opacity: 0;
      transform: translateY(18px) scale(0.995);
      animation: mapFadeUp 700ms cubic-bezier(.22,.9,.38,1) 150ms forwards;
    }
  </style>

  <!-- Google Map with Marker via Coordinates -->
  <div class="w-full aspect-[16/8] map-animate">
    <iframe
      class="w-full h-full border-0"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      src="https://www.google.com/maps?q=26.162531399228907,91.67838533836319&z=17&output=embed"
      title="NE Tourism - Office Coordinates">
    </iframe>
  </div>

  <div class="p-4 text-sm text-white/80 bg-white/5 border-t border-white/5">
    <p>Open in
      <a href="https://www.google.com/maps/search/?api=1&query=26.162531399228907,91.67838533836319"
         target="_blank" rel="noopener noreferrer" class="underline">Google Maps</a>
    </p>
  </div>

</div>

    </div>
  </div>
</section>


<!-- ================= ENQUIRY FORM (Separate Section) ================= -->
<section id="enquiry" class="w-full bg-white">
  <div class="py-16 px-4 md:px-8 lg:px-12 max-w-[1600px] mx-auto">

    <div class="max-w-3xl mx-auto text-center mb-10">
      <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Send an Enquiry</h2>
      <p class="mt-2 text-gray-600">We will get back to you with a custom itinerary.</p>
    </div>
    <form id="enquiryForm" class="max-w-3xl mx-auto rounded-2xl bg-white text-gray-900 p-6 md:p-8 shadow-xl" novalidate>
  <div id="enquiryAlert" class="mb-4 hidden"></div>

  <!-- Success panel -->
  <div id="enquirySuccess" class="mb-4 hidden rounded-lg bg-green-50 border border-green-200 p-4 text-green-800">
    <div id="enquirySuccessMessage" class="prose prose-sm"></div>
    <div class="mt-3">
      <button type="button" id="newEnquiryBtn" class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-green-800 hover:bg-green-100 transition">
        New Enquiry
      </button>
    </div>
  </div>

  <div class="grid sm:grid-cols-2 gap-4 form-fields">
    <!-- Name (required) -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Name</label>
      <input name="name" required class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-3" placeholder="Full name" />
    </div>

    <!-- Contact (required) -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Contact</label>
      <input name="contact" required type="tel" class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-3" placeholder="+91-98765xxxxxx" />
    </div>

    <!-- Email (optional) -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Email (optional)</label>
      <input name="email" type="email" class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-3" placeholder="you@example.com" />
    </div>

    <!-- Type of Trip (required) -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Type of Trip</label>
      <select name="trip_type" id="trip_type" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 bg-white text-gray-800">
        <option value="">Select trip type</option>
        <option value="Solo Trip">Solo Trip</option>
        <option value="Adventure">Adventure</option>
        <option value="Family Vacation">Family Vacation</option>
        <option value="Co-operative Trip">Co-operative Trip</option>
        <option value="Group Trip">Group Trip</option>
        <option value="Others">Others (specify)</option>
      </select>
    </div>

    <!-- Others specify (hidden by default, full-width) -->
    <div id="otherSpecifyWrap" class="sm:col-span-2 hidden">
      <label class="block text-sm font-medium text-gray-700">If Others, please specify</label>
      <input name="trip_type_other" id="trip_type_other" type="text" class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-3" placeholder="Describe trip type" />
    </div>

    <!-- DESTINATION: full row (required) -->
    <div class="sm:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Destination (select one or more) *</label>
      <select name="destinations" id="destinations" multiple size="4" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 bg-white text-gray-800">
        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
        <option value="Assam">Assam</option>
        <option value="Meghalaya">Meghalaya</option>
        <option value="Manipur">Manipur</option>
        <option value="Mizoram">Mizoram</option>
        <option value="Nagaland">Nagaland</option>
        <option value="Tripura">Tripura</option>
      </select>
      <p class="mt-2 text-xs text-gray-500">Hold Ctrl (Windows) / Cmd (Mac) to select multiple.</p>
    </div>

    <!-- Travel Dates (new) -->
    <div class="sm:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Travel Dates (pick one or more)</label>
      <input name="dates" id="travel_dates" type="text" placeholder="Select dates" class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-3" />
      <p class="mt-2 text-xs text-gray-500">Choose one or multiple dates. Use the calendar to pick dates.</p>
    </div>

    <!-- Number of Travellers (required except forced to 1 for Solo) -->
    <div id="travellerWrap">
      <label class="block text-sm font-medium text-gray-700">Number of Travellers</label>
      <select name="travellers" id="travellers" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 bg-white text-gray-800">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10+">10+</option>
      </select>
      <p id="travellerNote" class="mt-2 text-xs text-gray-500 hidden">Not applicable for Solo Trip</p>
    </div>

    <!-- Select Vehicle (required) -->
    <div id="vehicleWrap">
      <label class="block text-sm font-medium text-gray-700">Select Vehicle</label>
      <select name="vehicle" id="vehicle" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 bg-white text-gray-800">
        <option value="">Select vehicle</option>
        <option value="2 Wheeler">2 Wheeler</option>
        <option value="4 Wheeler">4 Wheeler</option>
        <option value="Traveller">Traveller</option>
      </select>
      <p class="mt-2 text-xs text-gray-500">Traveller option is not available for Solo Trip</p>
    </div>

    <!-- Self Drive checkbox (new) -->
    <div class="flex items-center gap-3">
      <input type="checkbox" name="self_drive" id="self_drive" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500" />
      <label for="self_drive" class="text-sm text-gray-700">Self Drive</label>
    </div>

    <!-- Additional Message (small text box) -->
    <div class="sm:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Additional message (optional)</label>
      <textarea name="message" id="additional_message" rows="3" class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-3" placeholder="Any special requests or notes (optional)"></textarea>
    </div>

    <!-- Submit -->
    <div class="sm:col-span-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <p class="text-sm text-gray-600">By sending, you agree to our <a href="#" class="underline">privacy policy</a>.</p>
      <button id="enquirySubmitBtn" type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-600 text-white px-6 py-3 font-semibold hover:bg-brand-500 transition">Submit</button>
    </div>
  </div>
</form>


  </div>
</section>


@endsection


@push('scripts')



<script>
document.addEventListener('DOMContentLoaded', function () {
  // --- Flatpickr init (multiple dates) ---
  const travelDatesInput = document.getElementById('travel_dates');
  let flatpickrInstance = null;
  if (travelDatesInput) {
    flatpickrInstance = flatpickr(travelDatesInput, {
      mode: 'multiple',
      dateFormat: 'Y-m-d',        // ISO format for sending; you can change to 'd M Y' for human readable
      altInput: true,
      altFormat: 'd M Y',        // human friendly shown in input
      allowInput: true,
      // minDate: "today",       // uncomment if you want to prevent past dates
      disableMobile: true
    });
  }

  // --- existing controls referenced earlier ---
  const form = document.getElementById('enquiryForm');
  if (!form) return;

  const tripType = document.getElementById('trip_type');
  const otherWrap = document.getElementById('otherSpecifyWrap');
  const travellersSelect = document.getElementById('travellers');
  const travellerNote = document.getElementById('travellerNote');
  const vehicleSelect = document.getElementById('vehicle');
  const submitBtn = document.getElementById('enquirySubmitBtn');
  const alertBox = document.getElementById('enquiryAlert');
  const successBox = document.getElementById('enquirySuccess');
  const successMessage = document.getElementById('enquirySuccessMessage');
  const newEnquiryBtn = document.getElementById('newEnquiryBtn');

  // Self drive checkbox
  const selfDriveEl = document.getElementById('self_drive');

  // Helper: show alert
  function showAlert(type, html) {
    alertBox.className = '';
    alertBox.classList.add('mb-4', 'p-4', 'rounded-lg', 'text-sm');
    if (type === 'success') {
      alertBox.classList.add('bg-green-50', 'text-green-800', 'border', 'border-green-200');
    } else {
      alertBox.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
    }
    alertBox.innerHTML = html;
    alertBox.classList.remove('hidden');
    alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }

  function clearErrors() {
    const errorEls = form.querySelectorAll('.field-error');
    errorEls.forEach(el => el.remove());
    if (alertBox) alertBox.classList.add('hidden');
  }

  // Trip type behavior (same as before)
  function updateTripTypeBehaviour() {
    const val = tripType.value;

    if (val === 'Others') {
      otherWrap.classList.remove('hidden');
      document.getElementById('trip_type_other').setAttribute('required','required');
    } else {
      otherWrap.classList.add('hidden');
      const otherInput = document.getElementById('trip_type_other');
      if (otherInput) {
        otherInput.removeAttribute('required');
        otherInput.value = '';
      }
    }

    if (val === 'Solo Trip') {
      travellersSelect.value = '1';
      travellersSelect.setAttribute('disabled','disabled');
      travellersSelect.classList.add('opacity-60');
      if (travellerNote) travellerNote.classList.remove('hidden');

      Array.from(vehicleSelect.options).forEach(opt => {
        if (opt.value === 'Traveller') {
          opt.hidden = true;
          opt.disabled = true;
        }
      });
      if (vehicleSelect.value === 'Traveller') vehicleSelect.value = '';
    } else {
      travellersSelect.removeAttribute('disabled');
      travellersSelect.classList.remove('opacity-60');
      if (travellerNote) travellerNote.classList.add('hidden');

      Array.from(vehicleSelect.options).forEach(opt => {
        if (opt.value === 'Traveller') {
          opt.hidden = false;
          opt.disabled = false;
        }
      });
    }
  }

  tripType.addEventListener('change', updateTripTypeBehaviour);
  updateTripTypeBehaviour();

  // New enquiry button
  if (newEnquiryBtn) {
    newEnquiryBtn.addEventListener('click', function () {
      successBox.classList.add('hidden');
      Array.from(form.children).forEach(child => {
        if (child.id !== 'enquiryAlert' && child.id !== 'enquirySuccess') {
          child.classList.remove('hidden');
        }
      });
      form.reset();
      if (flatpickrInstance) flatpickrInstance.clear();
      updateTripTypeBehaviour();
      const firstInput = form.querySelector('input[name], textarea[name]');
      if (firstInput) firstInput.focus();
    });
  }

  // Client-side validation unchanged except travel dates optional
  function validateForm() {
    clearErrors();
    const errors = [];

    const name = form.querySelector('[name="name"]').value.trim();
    const contact = form.querySelector('[name="contact"]').value.trim();
    const email = form.querySelector('[name="email"]').value.trim(); // optional
    const trip_type = tripType.value;
    const destSelect = document.getElementById('destinations');
    const selectedDestinations = Array.from(destSelect.selectedOptions).map(o => o.value);
    const travellers = document.getElementById('travellers').value;
    const vehicle = document.getElementById('vehicle').value;

    if (!name) errors.push('Name is required.');
    if (!contact) errors.push('Contact is required.');
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Email appears invalid.');
    if (!trip_type) errors.push('Trip type is required.');
    if (trip_type === 'Others') {
      const otherVal = (document.getElementById('trip_type_other') || {}).value || '';
      if (!otherVal.trim()) errors.push('Please specify the trip type.');
    }
    if (selectedDestinations.length === 0) errors.push('Please select at least one destination.');
    if (!travellers || travellers.length === 0) errors.push('Number of travellers is required.');
    if (!vehicle || vehicle.length === 0) errors.push('Please select a vehicle.');
    // travel dates are optional; no check here

    return { ok: errors.length === 0, errors };
  }

  // submit handler
  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    clearErrors();

    const v = validateForm();
    if (!v.ok) {
      let html = '<strong>Please fix the following:</strong><ul class="mt-2 ml-4">';
      v.errors.forEach(msg => { html += `<li>${msg}</li>`; });
      html += '</ul>';
      showAlert('error', html);
      return;
    }

    // disable submit
    submitBtn.disabled = true;
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = 'Sending...';

    // gather data to send
    const formData = new FormData();
    formData.append('name', form.querySelector('[name="name"]').value.trim());
    formData.append('contact', form.querySelector('[name="contact"]').value.trim());
    formData.append('email', form.querySelector('[name="email"]').value.trim() || '');
    formData.append('trip_type', tripType.value);
    formData.append('trip_type_other', (document.getElementById('trip_type_other') || {}).value || '');

    // destinations (multi)
    const dests = Array.from(document.getElementById('destinations').selectedOptions).map(opt => opt.value);
    formData.append('destinations', dests.join(', '));

    // travellers & vehicle
    formData.append('travellers', document.getElementById('travellers').value);
    formData.append('vehicle', document.getElementById('vehicle').value);

    // travel dates (from flatpickr). If none selected, send empty string.
    let datesToSend = '';
    if (flatpickrInstance) {
      const selectedDates = flatpickrInstance.selectedDates || [];
      // send ISO strings (YYYY-MM-DD) separated by comma
      datesToSend = selectedDates.map(d => {
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth()+1).padStart(2,'0');
        const dd = String(d.getDate()).padStart(2,'0');
        return `${yyyy}-${mm}-${dd}`;
      }).join(', ');
    } else {
      datesToSend = (document.getElementById('travel_dates') || {}).value || '';
    }
    formData.append('dates', datesToSend);

    // self-drive: checkbox -> 'Yes' or 'No'
    formData.append('self_drive', (selfDriveEl && selfDriveEl.checked) ? 'Yes' : 'No');

    // additional message
    formData.append('message', (document.getElementById('additional_message') || {}).value || '');

    // CSRF token
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

    try {
      const res = await fetch("{{ route('enquiry.submit') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json'
        },
        body: formData
      });

      const json = await res.json();

      if (!res.ok) {
        if (res.status === 422 && json.errors) {
          // show server validation errors
          let errorHtml = '<strong>Please fix the following errors:</strong><ul class="mt-2 ml-4">';
          for (const [field, messages] of Object.entries(json.errors)) {
            errorHtml += `<li>${messages.join(', ')}</li>`;
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
              const errEl = document.createElement('div');
              errEl.className = 'field-error mt-1 text-sm text-red-600';
              errEl.innerText = messages.join(', ');
              input.parentNode.appendChild(errEl);
            }
          }
          errorHtml += '</ul>';
          showAlert('error', errorHtml);
        } else {
          showAlert('error', `<strong>Submission failed.</strong> ${json.message ?? 'Please try again later.'}`);
        }
      } else {
        // success: display success panel and hide the form content
        const successText = `<strong>Thanks —</strong> ${json.message || 'Your enquiry was sent successfully.'}`;
        successMessage.innerHTML = successText;
        successBox.classList.remove('hidden');

        Array.from(form.children).forEach(child => {
          if (child.id !== 'enquiryAlert' && child.id !== 'enquirySuccess') {
            child.classList.add('hidden');
          }
        });

        successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    } catch (err) {
      console.error(err);
      showAlert('error', '<strong>Network error.</strong> Please check your connection and try again.');
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnText;
    }
  });
});
</script>

    
@endpush