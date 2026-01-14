<section class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
                Itinerary Builder
            </h3>
            <p class="mt-1 text-xs text-slate-500">
                Define the day-wise travel plan shown on the public package page.
            </p>
        </div>

        <button
            type="button"
            @click="addDay"
            class="inline-flex items-center gap-1 rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800"
        >
            + Add Day
        </button>
    </div>

    {{-- Days --}}
    <div class="space-y-4">
        <template x-for="(day, index) in itinerary" :key="index">
            <div
                class="relative rounded-xl border border-slate-200 bg-slate-50 p-5 transition hover:shadow-sm"
            >

                {{-- Day Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700"
                        >
                            <span x-text="index + 1"></span>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">
                                Day <span x-text="index + 1"></span>
                            </p>
                            <p class="text-xs text-slate-500">
                                Itinerary details for this day
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="removeDay(index)"
                        class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-[11px] font-medium text-red-700 hover:bg-red-100"
                    >
                        Remove
                    </button>
                </div>

                {{-- Day Title --}}
                <div class="mb-3">
                    <label class="block text-[11px] font-medium text-slate-700 mb-1">
                        Day Title
                    </label>
                    <input
                        type="text"
                        x-model="day.title"
                        class="block w-full h-11 rounded-lg border border-slate-300 bg-white px-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Arrival in Guwahati / Transfer to Shillong"
                    >
                </div>

                {{-- Day Description --}}
                <div>
                    <label class="block text-[11px] font-medium text-slate-700 mb-1">
                        Description
                    </label>
                    <textarea
                        x-model="day.description"
                        rows="4"
                        class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Detailed activities, sightseeing, meals, overnight stay, etc."
                    ></textarea>
                </div>

            </div>
        </template>
    </div>

    {{-- Empty State --}}
    <div
        x-show="itinerary.length === 0"
        class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500"
    >
        No itinerary added yet. Click <strong>“Add Day”</strong> to start building.
    </div>

</section>
