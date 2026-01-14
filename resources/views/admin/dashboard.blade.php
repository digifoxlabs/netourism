@extends('admin-layout')

@section('page-content')



<div class="mx-auto max-w-6xl px-4 py-8 lg:py-10">
    {{-- Page Heading --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-semibold text-slate-900">
                Admin Dashboard
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Quickly access and manage key sections of the NE Tourism admin panel.
            </p>
        </div>
    </div>

    {{-- Cards Grid --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {{-- Event Management --}}
        <a href="{{ route('admin.events.index') }}"
           class="group relative flex flex-col rounded-2xl border border-slate-200 bg-white/80
                  shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-sky-500 via-cyan-500 to-emerald-400"></div>

            <div class="flex-1 p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl
                               bg-sky-100 text-sky-600 group-hover:bg-sky-200">
                        {{-- Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             class="h-6 w-6">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium uppercase tracking-wide text-sky-600 bg-sky-50 px-2 py-1 rounded-full">
                        Events
                    </span>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-900 group-hover:text-sky-600">
                        Event Management
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Create, update, and manage tourism events, schedules, and details.
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50/80 px-5 py-3 flex items-center justify-between text-xs text-slate-500">
                <span>Go to Events</span>
                <span class="inline-flex items-center gap-1 text-sky-600 group-hover:translate-x-0.5 transition-transform">
                    Manage
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         class="h-4 w-4">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </span>
            </div>
        </a>


       {{-- Form Management --}}
        <a href="{{ route('admin.forms.index') }}"
           class="group relative flex flex-col rounded-2xl border border-slate-200 bg-white/80
                  shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-sky-500 via-cyan-500 to-emerald-400"></div>

            <div class="flex-1 p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl
                               bg-sky-100 text-sky-600 group-hover:bg-sky-200">
                        {{-- Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             class="h-6 w-6">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium uppercase tracking-wide text-sky-600 bg-sky-50 px-2 py-1 rounded-full">
                        Forms
                    </span>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-900 group-hover:text-sky-600">
                        Form Management
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Create, update, and manage forms.
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50/80 px-5 py-3 flex items-center justify-between text-xs text-slate-500">
                <span>Go to Forms</span>
                <span class="inline-flex items-center gap-1 text-sky-600 group-hover:translate-x-0.5 transition-transform">
                    Manage
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         class="h-4 w-4">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </span>
            </div>
        </a>




        {{-- Package Management --}}
        <a href="{{ route('admin.packages.index') }}"
           class="group relative flex flex-col rounded-2xl border border-slate-200 bg-white/80
                  shadow-sm hover:shadow-lg transition-shadow overflow-hidden">


            {{-- <x-coming-soon-card /> --}}

            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-violet-500 via-indigo-500 to-blue-400"></div>

            <div class="flex-1 p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl
                               bg-violet-100 text-violet-600 group-hover:bg-violet-200">
                        {{-- Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             class="h-6 w-6">
                            <path d="M3 7l9-4 9 4-9 4-9-4z" />
                            <path d="M3 17l9 4 9-4" />
                            <path d="M3 12l9 4 9-4" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium uppercase tracking-wide text-violet-600 bg-violet-50 px-2 py-1 rounded-full">
                        Packages
                    </span>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-900 group-hover:text-violet-600">
                        Package Management
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Manage tour packages, pricing, itineraries, and availability.
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50/80 px-5 py-3 flex items-center justify-between text-xs text-slate-500">
                <span>Go to Packages</span>
                <span class="inline-flex items-center gap-1 text-violet-600 group-hover:translate-x-0.5 transition-transform">
                    Manage
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         class="h-4 w-4">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Booking Enquiry --}}
        <a href="#"
           class="group relative flex flex-col rounded-2xl border border-slate-200 bg-white/80
                  shadow-sm hover:shadow-lg transition-shadow overflow-hidden">

         <x-coming-soon-card />
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 via-green-500 to-lime-400"></div>

            <div class="flex-1 p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl
                               bg-emerald-100 text-emerald-600 group-hover:bg-emerald-200">
                        {{-- Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             class="h-6 w-6">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium uppercase tracking-wide text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                        Enquiries
                    </span>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-900 group-hover:text-emerald-600">
                        Booking Enquiry
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        View and manage booking enquiries and customer messages.
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50/80 px-5 py-3 flex items-center justify-between text-xs text-slate-500">
                <span>Go to Enquiries</span>
                <span class="inline-flex items-center gap-1 text-emerald-600 group-hover:translate-x-0.5 transition-transform">
                    Manage
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         class="h-4 w-4">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </span>
            </div>
        </a>
    </div>
</div>



@endsection