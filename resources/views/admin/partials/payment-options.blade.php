@php
    $existingOptions = old('payment_options', $model->payment_options ?? []);

    if (empty($existingOptions) && !empty($model->payment_amount)) {
        $existingOptions = [[
            'label' => 'Full payment',
            'description' => '',
            'amount' => $model->payment_amount,
            'type' => 'full',
        ]];
    }

    if (empty($existingOptions)) {
        $existingOptions = [[
            'label' => 'Full payment',
            'description' => '',
            'amount' => '',
            'type' => 'full',
        ]];
    }
@endphp

<div
    x-data="{
        required: {{ old('payment_required', $model->payment_required ?? false) ? 'true' : 'false' }},
        options: @js(array_values($existingOptions)),
        addOption() {
            this.options.push({ label: '', description: '', amount: '', type: 'full' });
        },
        removeOption(index) {
            this.options.splice(index, 1);
            if (this.options.length === 0) this.addOption();
        }
    }"
    class="{{ $class ?? '' }}"
>
    <label class="flex items-center gap-3 text-sm font-semibold text-slate-800">
        <input
            type="checkbox"
            name="payment_required"
            value="1"
            x-model="required"
            class="h-4 w-4 rounded border-slate-300 text-emerald-600"
        >
        {{ $label ?? 'Payment required after form submission' }}
    </label>

    <div x-show="required" x-cloak class="mt-4 space-y-4">
        <template x-for="(option, index) in options" :key="index">
            <div class="rounded-xl border border-emerald-200 bg-white p-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Option Text</label>
                        <input
                            type="text"
                            :name="`payment_options[${index}][label]`"
                            x-model="option.label"
                            class="mt-1 h-11 w-full rounded-lg border px-3 text-sm"
                            placeholder="Pay booking advance"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Payment Type</label>
                        <select
                            :name="`payment_options[${index}][type]`"
                            x-model="option.type"
                            class="mt-1 h-11 w-full rounded-lg border px-3 text-sm"
                        >
                            <option value="full">Full</option>
                            <option value="partial">Partial</option>
                            <option value="pay_later">Pay Later</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Amount</label>
                        <input
                            type="number"
                            :name="`payment_options[${index}][amount]`"
                            x-model="option.amount"
                            min="0"
                            step="0.01"
                            class="mt-1 h-11 w-full rounded-lg border px-3 text-sm"
                            placeholder="4999.00"
                        >
                    </div>

                    <div class="flex items-end justify-end">
                        <button
                            type="button"
                            @click="removeOption(index)"
                            class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100"
                        >
                            Remove
                        </button>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Description</label>
                        <textarea
                            :name="`payment_options[${index}][description]`"
                            x-model="option.description"
                            rows="2"
                            class="mt-1 w-full rounded-lg border px-3 py-2 text-sm"
                            placeholder="This text appears below the radio option for users."
                        ></textarea>
                    </div>
                </div>
            </div>
        </template>

        <button
            type="button"
            @click="addOption()"
            class="rounded-lg border border-emerald-300 bg-white px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-50"
        >
            Add Payment Option
        </button>

        <input type="hidden" name="payment_amount" :value="options.find(option => option.type !== 'pay_later' && parseFloat(option.amount || 0) > 0)?.amount || ''">

        <p class="text-xs text-slate-500">
            If one option is configured, users continue directly after submitting the form. If multiple options are configured, users select one radio option first.
        </p>
    </div>
</div>
