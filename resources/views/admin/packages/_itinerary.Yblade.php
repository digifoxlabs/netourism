<section class="rounded-2xl border border-slate-200 bg-white p-6 space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">
                Itinerary Builder
            </h3>
            <p class="mt-1 text-xs text-slate-500">
                Day-wise travel plan
            </p>
        </div>

        <button
            type="button"
            @click="addDay"
            class="inline-flex rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white"
        >
            + Add Day
        </button>
    </div>

    <div class="space-y-4">
        <template x-for="(day, index) in itinerary" :key="index">
            <div class="rounded-xl border bg-slate-50 p-5">

                <div class="flex justify-between mb-3">
                    <strong>Day <span x-text="index + 1"></span></strong>
                    <button
                        type="button"
                        @click="removeDay(index)"
                        class="text-xs text-red-600"
                    >
                        Remove
                    </button>
                </div>

                <input
                    type="text"
                    x-model="day.title"
                    class="input w-full mb-2"
                    placeholder="Day title"
                >

                <textarea
                    x-model="day.description"
                    rows="4"
                    class="input w-full"
                    placeholder="Day description"
                ></textarea>

            </div>
        </template>
    </div>

    <div
        x-show="itinerary.length === 0"
        class="text-sm text-slate-500 text-center"
    >
        No itinerary added yet.
    </div>

</section>
