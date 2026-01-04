<div
    x-data="emailTemplateEditor({
        initialTemplate: @js(old(
            'confirmation_email_template',
            $form->confirmation_email_template ?? ''
        )),
        placeholders: @js(
            isset($form) && $form->relationLoaded('fields')
                ? $form->fields->pluck('name')->filter()->values()
                : []
        ),
        systemPlaceholders: []
    })"
    @class(['mt-6', 'rounded-2xl', 'border', 'border-dashed', 'bg-slate-50', 'p-5', 'space-y-4'])
>
    <h3 @class(['text-sm', 'font-semibold', 'text-slate-700'])>
        Email Confirmation (Optional)
    </h3>


    <label @class(['flex', 'items-center', 'gap-2', 'text-sm'])>
        <input
            type="checkbox"
            name="auto_email_confirmation"
            value="1"
            @checked(old('auto_email_confirmation', $form->auto_email_confirmation ?? false))
            @class(['h-4', 'w-4', 'rounded', 'border-slate-300', 'text-emerald-600'])
        >
        Send confirmation email after form submission
    </label>


    <div @class(['mb-3'])>
        <label @class(['block', 'text-sm' , 'font-medium' , 'text-slate-700' ])>
            Email Subject
        </label>
        <input type="text" name="confirmation_email_subject"
            value="{{ old('confirmation_email_subject', $form->confirmation_email_subject ?? '') }}"
            @class(['mt-1', 'w-full' , 'rounded-lg' , 'border' , 'px-3' , 'py-2' , 'text-sm' ])
            placeholder="Thanks @{{full_name}} for contacting us">
    </div>

    <textarea
        name="confirmation_email_template"
        x-model="template"
        rows="6"
        @class(['w-full', 'rounded-lg', 'border', 'px-3', 'py-2', 'text-sm'])
        placeholder="Hello @{{full_name}}, your submission has been received."
    ></textarea>

    {{-- Placeholder picker --}}
    <div @class(['flex', 'flex-wrap', 'gap-2'])>
        <template x-for="ph in allPlaceholders" :key="ph">
            <button
                type="button"
                @click="insert(ph)"
                @class(['rounded-full', 'bg-slate-200', 'px-3', 'py-1', 'text-[11px]', 'font-medium', 'text-slate-700', 'hover:bg-slate-300'])        >
                @{{ }}<span x-text="ph"></span>@{{ }}
            </button>
        </template>
    </div>

    {{-- Live preview --}}
    <div @class(['rounded-lg', 'border', 'bg-white', 'p-4'])>
        <p @class(['mb-2', 'text-xs', 'font-semibold', 'text-slate-500'])>
            Live Email Preview
        </p>
        <div
            @class(['text-sm', 'text-slate-800', 'whitespace-pre-line'])
            x-html="preview()"
        ></div>
    </div>
</div>
