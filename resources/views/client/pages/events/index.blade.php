@extends('client-layout')

@section('page-content')






<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- Page Header --}}
    <header class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                    Events & Rides
                </h1>
                <p class="mt-2 text-sm md:text-base text-slate-600">
                    Explore active, upcoming, and past events curated by Netourism and partner communities.
                </p>
            </div>
        </div>
    </header>

    <div class="space-y-10">

        {{-- ACTIVE EVENTS (Highlighted) --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    Active Events
                </h2>
                <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 border border-emerald-100">
                    Currently running
                </span>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                {{-- Active Event Card: Alfresco 2.0 --}}
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-emerald-300 bg-emerald-50/80 shadow-sm ring-1 ring-emerald-200">
                    {{-- Badge --}}
                    <div class="absolute left-3 top-3 z-10 inline-flex items-center gap-1 rounded-full bg-emerald-600/95 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-50 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-200 animate-pulse"></span>
                        Active
                    </div>

                    {{-- Image --}}
                    <div class="relative h-40 w-full overflow-hidden">
                        <img
                            src="https://images.pexels.com/photos/1005417/pexels-photo-1005417.jpeg?auto=compress&cs=tinysrgb&w=1200"
                            alt="Alfresco 2.0 - Embracing the Call of the Wild, Kaziranga"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        >
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent opacity-80"></div>

                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-xs text-slate-50">
                            <div class="flex flex-col">
                                <span class="font-semibold">
                                    20–21 Dec 2025 · 2D/1N Ride & Camp
                                </span>
                                <span class="text-[11px] text-slate-200">
                                    Kaziranga · Assam
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                            Alfresco 2.0 – Embracing the Call of the Wild, Kaziranga
                        </h3>

                        <p class="mt-2 text-sm text-slate-700 line-clamp-3">
                            A curated wilderness escape with The Hind Riders Motorcycle Community. Ride, camp and connect with nature in the heart of Kaziranga.
                        </p>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-700">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center rounded-full bg-white/90 px-2 py-1 text-[11px] font-medium text-emerald-700 border border-emerald-100">
                                    Registration Open
                                </span>
                                <span class="inline-flex items-center rounded-full bg-emerald-100/80 px-2 py-1 text-[11px] font-medium text-emerald-900">
                                    Limited Seats
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <a
                                href="{{ route('events.create') }}"
                                class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-xs md:text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                            >
                                Register now
                            </a>
                            <span class="text-xs text-slate-500">
                                ₹2,299/- per head
                            </span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- UPCOMING EVENTS --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    Upcoming Events
                </h2>
                <span class="inline-flex items-center rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-700 border border-sky-100">
                    Plan ahead
                </span>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
               
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative h-40 w-full overflow-hidden">
                        <img
                            src="https://images.pexels.com/photos/2101154/pexels-photo-2101154.jpeg?auto=compress&cs=tinysrgb&w=1200"
                            alt="Brahmaputra Riverside Sundown Ride"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        >
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/55 via-slate-950/5 to-transparent opacity-80"></div>

                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-xs text-slate-50">
                            <div class="flex flex-col">
                                <span class="font-semibold">
                                    10 Jan 2026 · Evening Ride
                                </span>
                                <span class="text-[11px] text-slate-200">
                                    Guwahati · Assam
                                </span>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-sky-500/95 px-2 py-1 text-[11px] font-semibold uppercase tracking-wide">
                                Upcoming
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                            Brahmaputra Riverside Sundown Ride
                        </h3>

                        <p class="mt-2 text-sm text-slate-700 line-clamp-3">
                            A relaxed riverside spin to welcome the new year with fellow riders. Sunset views, light snacks, and photo stops included.
                        </p>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-600">
                            <span>Starts: <span class="font-medium">10 Jan 2026</span></span>
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-700">
                                Easy · 60–80 km
                            </span>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <a
                                href="#"
                                class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-xs md:text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
                            >
                                View details
                            </a>
                            <span class="text-xs text-slate-500">
                                Registrations opening soon
                            </span>
                        </div>
                    </div>
                </article>

         
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative h-40 w-full overflow-hidden">
                        <img
                            src="https://images.pexels.com/photos/243989/pexels-photo-243989.jpeg?auto=compress&cs=tinysrgb&w=1200"
                            alt="Meghalaya Monsoon Trail"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        >
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/55 via-slate-950/5 to-transparent opacity-80"></div>

                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-xs text-slate-50">
                            <div class="flex flex-col">
                                <span class="font-semibold">
                                    Jul 2026 · 3D/2N Ride & Stay
                                </span>
                                <span class="text-[11px] text-slate-200">
                                    Shillong · Cherrapunjee · Dawki
                                </span>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-sky-500/95 px-2 py-1 text-[11px] font-semibold uppercase tracking-wide">
                                Upcoming
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                            Meghalaya Monsoon Trail
                        </h3>

                        <p class="mt-2 text-sm text-slate-700 line-clamp-3">
                            Waterfalls, misty hills and winding roads. A curated ride through Meghalaya’s iconic monsoon landscapes.
                        </p>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-600">
                            <span>Registrations: <span class="font-medium">Opening in May 2026</span></span>
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-700">
                                Intermediate · 400+ km
                            </span>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <a
                                href="#"
                                class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-xs md:text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
                            >
                                Get notified
                            </a>
                            <span class="text-xs text-slate-500">
                                Tentative dates
                            </span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

      
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    Past Events
                </h2>
                <span class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600 border border-slate-200">
                    Completed journeys
                </span>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                    <div class="relative h-40 w-full overflow-hidden grayscale group-hover:grayscale-0 transition">
                        <img
                            src="https://images.pexels.com/photos/3729464/pexels-photo-3729464.jpeg?auto=compress&cs=tinysrgb&w=1200"
                            alt="Highlands Dawn Ride 2024"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        >
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent opacity-80"></div>

                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-xs text-slate-50">
                            <div class="flex flex-col">
                                <span class="font-semibold">
                                    12–14 Apr 2024 · 3D/2N
                                </span>
                                <span class="text-[11px] text-slate-200">
                                    Arunachal Highlands
                                </span>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-slate-700/95 px-2 py-1 text-[11px] font-semibold uppercase tracking-wide">
                                Completed
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                            Highlands Dawn Ride 2024
                        </h3>

                        <p class="mt-2 text-sm text-slate-700 line-clamp-3">
                            Early morning mountain passes, chill air and unforgettable vistas. A flagship ride across the Eastern Himalayas.
                        </p>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-600">
                            <span>12–14 Apr 2024</span>
                            <span class="inline-flex items-center rounded-full bg-white px-2 py-1 text-[11px] font-medium text-slate-500 border border-slate-200">
                                Archive
                            </span>
                        </div>
                    </div>
                </article>

               
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                    <div class="relative h-40 w-full overflow-hidden grayscale group-hover:grayscale-0 transition">
                        <img
                            src="https://images.pexels.com/photos/1544636/pexels-photo-1544636.jpeg?auto=compress&cs=tinysrgb&w=1200"
                            alt="Tea Garden Trails 2023"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        >
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent opacity-80"></div>

                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-xs text-slate-50">
                            <div class="flex flex-col">
                                <span class="font-semibold">
                                    03–04 Sep 2023 · Weekend Ride
                                </span>
                                <span class="text-[11px] text-slate-200">
                                    Assam Tea Estates
                                </span>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-slate-700/95 px-2 py-1 text-[11px] font-semibold uppercase tracking-wide">
                                Completed
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-900 line-clamp-2">
                            Tea Garden Trails 2023
                        </h3>

                        <p class="mt-2 text-sm text-slate-700 line-clamp-3">
                            Gentle curves through endless tea gardens, with curated halts inside working estates and local food experiences.
                        </p>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-600">
                            <span>03–04 Sep 2023</span>
                            <span class="inline-flex items-center rounded-full bg-white px-2 py-1 text-[11px] font-medium text-slate-500 border border-slate-200">
                                Archive
                            </span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

    </div>
</div>




@endsection