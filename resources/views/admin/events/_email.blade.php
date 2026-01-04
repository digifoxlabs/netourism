<div
    x-data="emailTemplateEditor({
        initialTemplate: @js(old(
            'confirmation_email_template',
            $event->confirmation_email_template ?? ''
        )),
        placeholders: @js($event->form?->fields->pluck('name') ?? []),
        systemPlaceholders: ['event_title', 'fee']
    })"
    class="mt-6 rounded-xl border border-dashed bg-slate-50 p-5 space-y-4"
>

    <h3 class="text-sm font-semibold text-slate-700">
        Event Confirmation Email
    </h3>

    <p class="text-xs text-slate-500">
        This email will be sent when admin confirms a registration.
    </p>

    <textarea
        name="confirmation_email_template"
        x-model="template"
        rows="6"
        class="w-full rounded-lg border px-3 py-2 text-sm"
        placeholder="Hello {{full_name}}, your registration for {{event_title}} is confirmed…"
    ></textarea>

    {{-- PLACEHOLDER PICKER --}}
    <div class="flex flex-wrap gap-2">
        <template x-for="ph in allPlaceholders" :key="ph">
            <button
                type="button"
                @click="insert(ph)"
                class="rounded-full bg-slate-200 px-3 py-1 text-[11px] font-medium"
            >
                {{ '{{' }}<span x-text="ph"></span>{{ '}}' }}
            </button>
        </template>
    </div>

    {{-- LIVE PREVIEW --}}
    <div class="rounded-lg border bg-white p-4">
        <p class="mb-2 text-xs font-semibold text-slate-500">
            Live Email Preview
        </p>
        <div
            class="text-sm text-slate-800 whitespace-pre-line"
            x-html="preview"
        ></div>
    </div>

</div>
