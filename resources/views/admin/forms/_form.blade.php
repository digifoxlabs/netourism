{{-- resources/views/admin/forms/_form.blade.php --}}
<div
    class="mx-auto max-w-6xl p-4 md:p-6"
    x-data="formBuilder()"
    x-init='init(@json($sections ?? []))'
>
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-slate-900">
                {{ $title }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">
                Build a reusable form with sections, flexible layout and conditional logic. You can embed this form anywhere using its slug.
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <p class="font-semibold mb-1">Please fix the errors below:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ $action }}"
        method="POST"
        class="space-y-6"
        @submit="serializeFields"
    >
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        {{-- Hidden JSON for fields --}}
        <input type="hidden" name="fields_json" x-model="fieldsJson">

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- LEFT: Form settings --}}
            <div class="space-y-6 lg:col-span-1">
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wide mb-4">
                        Form Settings
                    </h2>

                    {{-- Form Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-slate-800 mb-1">
                            Form Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            x-model="formName"
                            @input="if (autoSlug) generateSlug()"
                            required
                            class="mt-1 block w-full h-12 px-4 rounded-lg border border-slate-300 bg-white text-base text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Contact Form, Event Registration Form, etc."
                        >
                    </div>

                    {{-- Slug --}}
                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-slate-800 mb-1">
                            Slug
                        </label>
                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            x-model="slug"
                            class="mt-1 block w-full h-12 px-4 rounded-lg border border-slate-300 bg-white text-base text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="contact-form"
                        >
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-[11px] text-slate-500">
                                Use this in routes or Blade to render the form.
                            </p>
                            <label class="inline-flex items-center gap-1 text-[11px] text-slate-600">
                                <input
                                    type="checkbox"
                                    class="h-3 w-3 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                    x-model="autoSlug"
                                >
                                <span>Auto from name</span>
                            </label>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-slate-800 mb-1">
                            Description
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >{{ old('description', $form->description ?? '') }}</textarea>
                    </div>

                    {{-- Success Message --}}
                    <div class="mb-4">
                        <label for="success_message" class="block text-sm font-medium text-slate-800 mb-1">
                            Success Message
                        </label>
                        <textarea
                            id="success_message"
                            name="success_message"
                            rows="2"
                            class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Thanks for contacting us. We will get back to you shortly."
                        >{{ old('success_message', $form->success_message ?? '') }}</textarea>
                    </div>

                    {{-- Redirect URL --}}
                    <div class="mb-4">
                        <label for="redirect_url" class="block text-sm font-medium text-slate-800 mb-1">
                            Redirect URL (optional)
                        </label>
                        <input
                            type="url"
                            id="redirect_url"
                            name="redirect_url"
                            value="{{ old('redirect_url', $form->redirect_url ?? '') }}"
                            class="mt-1 block w-full h-12 px-4 rounded-lg border border-slate-300 bg-white text-base text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="https://your-site.com/thank-you"
                        >
                    </div>

                    {{-- Active --}}
                    <div class="mb-2">
                        <label class="flex items-center justify-between gap-2 cursor-pointer">
                            <span class="text-sm font-medium text-slate-800">
                                Active
                            </span>
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $form->is_active ?? true))
                                class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            >
                        </label>
                        <p class="mt-1 text-[11px] text-slate-500">
                            Only active forms should be used on public pages.
                        </p>
                    </div>
                </section>


                          {{-- EMAIL CONFIRMATION SETTINGS --}}
            @include('admin.forms._email', [
                'form' => $form ?? null
            ])


            </div>

            {{-- RIGHT: Sections + Fields --}}
            <div class="space-y-6 lg:col-span-2">
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">
                            Sections & Fields
                        </h2>
                        <button
                            type="button"
                            @click="addSection()"
                            class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-slate-800"
                        >
                            + Add Section
                        </button>
                    </div>

                    <template x-if="sections.length === 0">
                        <p class="text-sm text-slate-500">
                            No sections yet. Click “Add Section” to start building your form layout.
                        </p>
                    </template>

                    <div class="space-y-4">
                        <template x-for="(section, sectionIndex) in sections" :key="sectionIndex">
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 md:p-5">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                                    <div class="flex-1 space-y-2">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-800 mb-1">
                                                Section Title
                                            </label>
                                            <input
                                                type="text"
                                                x-model="section.title"
                                                class="block w-full h-11 px-3 rounded-lg border border-slate-300 bg-white text-sm text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                placeholder="Personal Details"
                                            >
                                        </div>
                                        <p class="text-[11px] text-slate-500">
                                            You can mix full-width and half-width fields in the same section.
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-end gap-2">
                                        <button
                                            type="button"
                                            @click="removeSection(sectionIndex)"
                                            class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-[11px] font-medium text-red-700 hover:bg-red-100"
                                        >
                                            Remove Section
                                        </button>
                                        <div class="flex gap-1 text-[11px] text-slate-500">
                                            <button
                                                type="button"
                                                @click="moveSectionUp(sectionIndex)"
                                                class="inline-flex items-center justify-center rounded border border-slate-200 bg-white px-2 py-1 hover:bg-slate-50"
                                            >
                                                ↑
                                            </button>
                                            <button
                                                type="button"
                                                @click="moveSectionDown(sectionIndex)"
                                                class="inline-flex items-center justify-center rounded border border-slate-200 bg-white px-2 py-1 hover:bg-slate-50"
                                            >
                                                ↓
                                            </button>
                                        </div>
                                        <button
                                            type="button"
                                            @click="addField(sectionIndex)"
                                            class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-[11px] font-medium text-slate-800 hover:bg-slate-100"
                                        >
                                            + Add Field
                                        </button>
                                    </div>
                                </div>

                                {{-- Fields grid with per-field width --}}
                                <div class="grid gap-3 md:grid-cols-2">
                                    <template x-for="(field, fieldIndex) in section.fields" :key="fieldIndex">
                                        <div
                                            class="border border-slate-200 rounded-xl bg-white p-3 space-y-2"
                                            :class="field.width === 'full' ? 'md:col-span-2' : ''"
                                        >
                                            <div class="flex items-start justify-between gap-2">
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-[11px] font-semibold text-slate-500">
                                                            Field @{{ fieldIndex + 1 }}
                                                        </span>
                                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-700 border border-slate-200">
                                                            @{{ field.type || 'type not set' }}
                                                        </span>
                                                    </div>

                                                    {{-- Label --}}
                                                    <div class="mb-2">
                                                        <label class="block text-[11px] font-medium text-slate-800 mb-1">
                                                            Label
                                                        </label>
                                                        <input
                                                            type="text"
                                                            x-model="field.label"
                                                            class="block w-full h-10 px-3 rounded-lg border border-slate-300 bg-white text-xs text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                            placeholder="Full Name"
                                                        >
                                                    </div>

                                                    {{-- Name + Type --}}
                                                    <div class="grid gap-2 md:grid-cols-2 mb-2">
                                                        <div>
                                                            <label class="block text-[11px] font-medium text-slate-800 mb-1">
                                                                Name (field key)
                                                            </label>
                                                            <input
                                                                type="text"
                                                                x-model="field.name"
                                                                class="block w-full h-10 px-3 rounded-lg border border-slate-300 bg-white text-xs text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                                placeholder="full_name"
                                                            >
                                                        </div>
                                                        <div>
                                                            <label class="block text-[11px] font-medium text-slate-800 mb-1">
                                                                Type
                                                            </label>
                                                            <select
                                                                x-model="field.type"
                                                                class="block w-full h-10 rounded-lg border border-slate-300 bg-white text-xs text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                            >
                                                                <option value="text">Text</option>
                                                                <option value="email">Email</option>
                                                                <option value="textarea">Textarea</option>
                                                                <option value="number">Number</option>
                                                                <option value="tel">Phone</option>
                                                                <option value="date">Date</option>
                                                                <option value="select">Select (Dropdown)</option>
                                                                <option value="radio">Radio</option>
                                                                <option value="checkbox">Checkbox</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Placeholder --}}
                                                    <div class="mb-2">
                                                        <label class="block text-[11px] font-medium text-slate-800 mb-1">
                                                            Placeholder
                                                        </label>
                                                        <input
                                                            type="text"
                                                            x-model="field.placeholder"
                                                            class="block w-full h-10 px-3 rounded-lg border border-slate-300 bg-white text-xs text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                        >
                                                    </div>

                                                    {{-- Help Text + Required --}}
                                                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                                                        <div class="flex-1">
                                                            <label class="block text-[11px] font-medium text-slate-800 mb-1">
                                                                Help Text
                                                            </label>
                                                            <input
                                                                type="text"
                                                                x-model="field.help_text"
                                                                class="block w-full h-10 px-3 rounded-lg border border-slate-300 bg-white text-xs text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                            >
                                                        </div>
                                                        <div class="flex items-center gap-2 mt-1 md:mt-6">
                                                            <input
                                                                type="checkbox"
                                                                x-model="field.required"
                                                                class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                            >
                                                            <span class="text-[11px] text-slate-700">Required</span>
                                                        </div>
                                                    </div>

                                                    {{-- Width controls --}}
                                                    <div class="mt-2 flex flex-wrap gap-2 text-[11px]">
                                                        <span class="text-slate-500">Width:</span>
                                                        <button
                                                            type="button"
                                                            @click="field.width = 'full'"
                                                            :class="field.width === 'full'
                                                                ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                                                                : 'border-slate-200 bg-white text-slate-700'"
                                                            class="inline-flex items-center rounded-lg border px-3 py-1 font-medium"
                                                        >
                                                            Full row
                                                        </button>
                                                        <button
                                                            type="button"
                                                            @click="field.width = 'half'"
                                                            :class="field.width === 'half'
                                                                ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                                                                : 'border-slate-200 bg-white text-slate-700'"
                                                            class="inline-flex items-center rounded-lg border px-3 py-1 font-medium"
                                                        >
                                                            Half width
                                                        </button>
                                                    </div>

                                                    {{-- Options (for select/radio/checkbox) --}}
                                                    <template x-if="['select','radio','checkbox'].includes(field.type)">
                                                        <div class="mt-2">
                                                            <label class="block text-[11px] font-medium text-slate-800 mb-1">
                                                                Options (one per line)
                                                            </label>
                                                            <textarea
                                                                x-model="field.options_raw"
                                                                rows="3"
                                                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                                                placeholder="Option 1&#10;Option 2&#10;Option 3"
                                                            ></textarea>
                                                        </div>
                                                    </template>

                                                    {{-- Conditional Logic --}}
                                                    <div class="mt-3 pt-3 border-t border-dashed border-slate-200 space-y-2">
                                                        <div class="flex items-center justify-between">
                                                            <p class="text-[11px] font-semibold text-slate-700">
                                                                Conditional Logic
                                                            </p>
                                                            <label class="inline-flex items-center gap-1 text-[11px] text-slate-600">
                                                                <input
                                                                    type="checkbox"
                                                                    x-model="field.conditional_enabled"
                                                                    class="h-3.5 w-3.5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                                                >
                                                                <span>Enable</span>
                                                            </label>
                                                        </div>

                                                        <template x-if="field.conditional_enabled">
                                                            <div class="space-y-2 text-[11px]">
                                                                <p class="text-slate-500">
                                                                    Show this field only when another field matches a value.
                                                                </p>

                                                                <div class="grid gap-2 md:grid-cols-3">
                                                                    {{-- Field --}}
                                                                    <div class="md:col-span-1">
                                                                        <label class="block mb-1 font-medium text-slate-800">
                                                                            If field
                                                                        </label>
                                                                        <select
                                                                            x-model="field.conditional_field"
                                                                            class="block w-full h-9 rounded-lg border border-slate-300 bg-white px-2 text-[11px] text-slate-800 focus:border-emerald-500 focus:ring-emerald-500"
                                                                        >
                                                                            <option value="">Select field</option>
                                                                            <template x-for="f in allFields()" :key="f.key">
                                                                                <option
                                                                                    :value="f.name"
                                                                                    x-text="f.label"
                                                                                ></option>
                                                                            </template>
                                                                        </select>
                                                                    </div>

                                                                    {{-- Operator --}}
                                                                    <div class="md:col-span-1">
                                                                        <label class="block mb-1 font-medium text-slate-800">
                                                                            Operator
                                                                        </label>
                                                                        <select
                                                                            x-model="field.conditional_operator"
                                                                            class="block w-full h-9 rounded-lg border border-slate-300 bg-white px-2 text-[11px] text-slate-800 focus:border-emerald-500 focus:ring-emerald-500"
                                                                        >
                                                                            <option value="equals">equals</option>
                                                                            <option value="not_equals">does not equal</option>
                                                                            <option value="contains">contains (checkbox)</option>
                                                                            <option value="not_contains">does not contain</option>
                                                                        </select>
                                                                    </div>

                                                                    {{-- Value --}}
                                                                    <div class="md:col-span-1">
                                                                        <label class="block mb-1 font-medium text-slate-800">
                                                                            Value
                                                                        </label>
                                                                        <input
                                                                            type="text"
                                                                            x-model="field.conditional_value"
                                                                            class="block w-full h-9 px-2 rounded-lg border border-slate-300 bg-white text-[11px] text-slate-800 focus:border-emerald-500 focus:ring-emerald-500"
                                                                            placeholder="e.g. Motorcycle"
                                                                        >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>

                                                {{-- Field controls --}}
                                                <div class="flex flex-col items-end gap-2">
                                                    <button
                                                        type="button"
                                                        @click="removeField(sectionIndex, fieldIndex)"
                                                        class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-2.5 py-1 text-[10px] font-medium text-red-700 hover:bg-red-100"
                                                    >
                                                        Remove
                                                    </button>
                                                    <div class="flex gap-1 text-[10px] text-slate-500">
                                                        <button
                                                            type="button"
                                                            @click="moveFieldUp(sectionIndex, fieldIndex)"
                                                            class="inline-flex items-center justify-center rounded border border-slate-200 bg-white px-2 py-1 hover:bg-slate-50"
                                                        >
                                                            ↑
                                                        </button>
                                                        <button
                                                            type="button"
                                                            @click="moveFieldDown(sectionIndex, fieldIndex)"
                                                            class="inline-flex items-center justify-center rounded border border-slate-200 bg-white px-2 py-1 hover:bg-slate-50"
                                                        >
                                                            ↓
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <template x-if="section.fields.length === 0">
                                    <div class="mt-3 text-xs text-slate-500">
                                        No fields in this section yet. Click “Add Field”.
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </section>
            </div>




                  
  
   

        </div>



  


        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.forms.index') }}"
                class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700"
            >
                Save Form
            </button>
        </div>
    </form>
</div>

<script>
    function formBuilder() {
        return {
            formName: @json(old('name', $form->name ?? '')),
            slug: @json(old('slug', $form->slug ?? '')),
            autoSlug: true,
            sections: [],
            fieldsJson: '',

            init(initialSections) {
                // If returning from validation error, rebuild from flat fields_json
                @if(old('fields_json'))
                    try {
                        const flat = JSON.parse(@json(old('fields_json')));
                        this.sections = this.buildSectionsFromFlat(flat);
                        return;
                    } catch (e) {
                        console.error('Failed to parse old fields_json', e);
                    }
                @endif

                this.sections = initialSections || [];
            },

            buildSectionsFromFlat(flatFields) {
                if (!flatFields || !flatFields.length) return [];
                return [{
                    title: flatFields[0].section_title || 'Main Section',
                    fields: flatFields.map(f => ({
                        label: f.label || '',
                        name: f.name || '',
                        type: f.type || 'text',
                        placeholder: f.placeholder || '',
                        help_text: f.help_text || '',
                        required: !!f.required,
                        options_raw: f.options_raw || '',
                        width: f.width || 'full',

                        conditional_enabled: !!f.conditional_enabled,
                        conditional_field: f.conditional_field || '',
                        conditional_operator: f.conditional_operator || 'equals',
                        conditional_value: f.conditional_value || '',
                    })),
                }];
            },

            generateSlug() {
                if (!this.formName) return;
                this.slug = this.formName
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/[\s_]+/g, '-')
                    .replace(/[^a-z0-9\-]/g, '')
                    .replace(/\-+/g, '-');
            },

            // Helper: list all fields for conditional dropdown
            allFields() {
                const list = [];
                this.sections.forEach((section, sIndex) => {
                    section.fields.forEach((field, fIndex) => {
                        if (!field.name) return;
                        list.push({
                            name: field.name,
                            label: field.label || field.name,
                            key: `${sIndex}-${fIndex}`,
                        });
                    });
                });
                return list;
            },

            // Sections
            addSection() {
                this.sections.push({ title: '', fields: [] });
            },
            removeSection(i) {
                this.sections.splice(i, 1);
            },
            moveSectionUp(i) {
                if (i === 0) return;
                [this.sections[i - 1], this.sections[i]] = [this.sections[i], this.sections[i - 1]];
            },
            moveSectionDown(i) {
                if (i === this.sections.length - 1) return;
                [this.sections[i + 1], this.sections[i]] = [this.sections[i], this.sections[i + 1]];
            },

            // Fields
            addField(si) {
                this.sections[si].fields.push({
                    label: '',
                    name: '',
                    type: 'text',
                    placeholder: '',
                    help_text: '',
                    required: false,
                    options_raw: '',
                    width: 'full',

                    conditional_enabled: false,
                    conditional_field: '',
                    conditional_operator: 'equals',
                    conditional_value: '',
                });
            },
            removeField(si, fi) {
                this.sections[si].fields.splice(fi, 1);
            },
            moveFieldUp(si, fi) {
                if (fi === 0) return;
                const f = this.sections[si].fields;
                [f[fi - 1], f[fi]] = [f[fi], f[fi - 1]];
            },
            moveFieldDown(si, fi) {
                const f = this.sections[si].fields;
                if (fi === f.length - 1) return;
                [f[fi + 1], f[fi]] = [f[fi], f[fi + 1]];
            },

            // Serialize sections -> flat list for backend
            serializeFields() {
                const flat = [];
                this.sections.forEach((section, sIndex) => {
                    section.fields.forEach((field) => {
                        flat.push({
                            section_title: section.title || `Section ${sIndex + 1}`,
                            label: field.label,
                            name: field.name,
                            type: field.type,
                            placeholder: field.placeholder,
                            help_text: field.help_text,
                            required: field.required,
                            options_raw: field.options_raw,
                            width: field.width || 'full',

                            conditional_enabled: field.conditional_enabled || false,
                            conditional_field: field.conditional_field || '',
                            conditional_operator: field.conditional_operator || 'equals',
                            conditional_value: field.conditional_value || '',
                        });
                    });
                });
                this.fieldsJson = JSON.stringify(flat);
            },
        };
    }
</script>
