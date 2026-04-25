@extends('admin-layout')

@section('page-content')
<div class="mx-auto w-full max-w-4xl px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Settings</h1>
        <p class="mt-2 text-sm text-slate-600">
            Control which sections are shown on the client home page.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Event Sections</h2>
            <p class="mt-1 text-sm text-slate-600">
                Show or hide the event blocks on the home page.
            </p>

            <div class="mt-5 space-y-4">
                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4">
                    <input type="hidden" name="home_show_active_events" value="0">
                    <input
                        type="checkbox"
                        name="home_show_active_events"
                        value="1"
                        @checked($settings['home_show_active_events'])
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span>
                        <span class="block font-medium text-slate-900">Active events section</span>
                        <span class="block text-sm text-slate-600">Display the active events cards on the client home page.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4">
                    <input type="hidden" name="home_show_upcoming_events" value="0">
                    <input
                        type="checkbox"
                        name="home_show_upcoming_events"
                        value="1"
                        @checked($settings['home_show_upcoming_events'])
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span>
                        <span class="block font-medium text-slate-900">Upcoming events section</span>
                        <span class="block text-sm text-slate-600">Display the upcoming events cards on the client home page.</span>
                    </span>
                </label>
            </div>
        </section>

        <section class="rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Home Content Sections</h2>
            <p class="mt-1 text-sm text-slate-600">
                Toggle the informational sections that appear below the event area.
            </p>

            <div class="mt-5 space-y-4">
                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4">
                    <input type="hidden" name="home_show_seven_sisters" value="0">
                    <input
                        type="checkbox"
                        name="home_show_seven_sisters"
                        value="1"
                        @checked($settings['home_show_seven_sisters'])
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span>
                        <span class="block font-medium text-slate-900">Seven Sisters section</span>
                        <span class="block text-sm text-slate-600">Display the Seven Sisters state overview cards.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4">
                    <input type="hidden" name="home_show_best_time_to_travel" value="0">
                    <input
                        type="checkbox"
                        name="home_show_best_time_to_travel"
                        value="1"
                        @checked($settings['home_show_best_time_to_travel'])
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span>
                        <span class="block font-medium text-slate-900">Best time to travel section</span>
                        <span class="block text-sm text-slate-600">Display the seasonal travel guidance section.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4">
                    <input type="hidden" name="home_show_planning_your_trip" value="0">
                    <input
                        type="checkbox"
                        name="home_show_planning_your_trip"
                        value="1"
                        @checked($settings['home_show_planning_your_trip'])
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span>
                        <span class="block font-medium text-slate-900">Planning your trip section</span>
                        <span class="block text-sm text-slate-600">Display the trip planning cards section.</span>
                    </span>
                </label>
            </div>
        </section>

        <section class="rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Package Section Layout</h2>
            <p class="mt-1 text-sm text-slate-600">
                Choose how package categories are displayed on the client home page.
            </p>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-medium text-slate-700">Home package layout</label>
                <select
                    name="home_packages_layout"
                    class="h-11 w-full rounded-lg border border-slate-300 px-3 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-200"
                >
                    <option value="tabs" @selected(($settings['home_packages_layout'] ?? 'tabs') === 'tabs')>Tabbed view</option>
                    <option value="grid" @selected(($settings['home_packages_layout'] ?? 'tabs') === 'grid')>Grid sections</option>
                </select>
            </div>
        </section>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">
                Cancel
            </a>
            <button type="submit" class="rounded-lg bg-brand-600 px-5 py-2 text-sm font-semibold text-white">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
