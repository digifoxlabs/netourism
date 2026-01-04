<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-5 rounded-xl border">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-slate-800">Title</label>
            <input name="title" value="{{ old('title', $event->title ?? '') }}" required class="mt-1 block w-full h-11 rounded-lg border px-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-800">Slug</label>
            <input name="slug" value="{{ old('slug', $event->slug ?? '') }}" class="mt-1 block w-full h-11 rounded-lg border px-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-800">Subtitle</label>
            <input name="subtitle" value="{{ old('subtitle', $event->subtitle ?? '') }}" class="mt-1 block w-full h-11 rounded-lg border px-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-800">Attach Form (optional)</label>
            <select name="form_id" class="mt-1 block w-full h-11 rounded-lg border px-3">
                <option value="">-- none --</option>
                @foreach($forms as $f)
                    <option value="{{ $f->id }}" @selected(old('form_id', $event->form_id ?? '') == $f->id)>{{ $f->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- <div>
            <label class="block text-sm font-medium text-slate-800">Photo</label>
            <input type="file" name="photo" class="mt-1 block w-full">
            @if(!empty($event->photo_path))
                <img src="{{ asset('storage/'.$event->photo_path) }}" alt="" class="mt-2 w-40 h-auto rounded">
            @endif
        </div> --}}

        <div
    x-data="{
        preview: '{{ !empty($event->photo_path) ? asset('storage/'.$event->photo_path) : '' }}',
        pick(e) {
            const file = e.target.files[0];
            if (!file) return;
            this.preview = URL.createObjectURL(file);
        }
    }"
>
    <label class="block text-sm font-medium text-slate-800 mb-1">
        Event Photo
    </label>

    <div class="flex items-start gap-4">
        {{-- Preview --}}
        <div class="h-24 w-36 rounded-lg border border-dashed bg-slate-50 flex items-center justify-center overflow-hidden">
            <template x-if="preview">
                <img :src="preview" class="h-full w-full object-cover">
            </template>

            <template x-if="!preview">
                <span class="text-xs text-slate-400 text-center px-2">
                    No image selected
                </span>
            </template>
        </div>

        {{-- Input --}}
        <div class="flex-1">
            <label
                class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 16l4-4a3 3 0 014 0l4 4m-7-7l1-1a3 3 0 014 0l1 1m4 5V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7"/>
                </svg>
                Choose Image
                <input
                    type="file"
                    name="photo"
                    accept="image/*"
                    class="hidden"
                    @change="pick"
                >
            </label>

            <p class="mt-1 text-xs text-slate-500">
                JPG, PNG, WEBP up to 2MB
            </p>
        </div>
    </div>
</div>


        <div>
            <label class="block text-sm font-medium text-slate-800">Status</label>
            <select name="status" class="mt-1 block w-full h-11 rounded-lg border px-3">
                <option value="active" @selected(old('status', $event->status ?? '') === 'active')>Active</option>
                <option value="upcoming" @selected(old('status', $event->status ?? '') === 'upcoming')>Upcoming</option>
                <option value="expired" @selected(old('status', $event->status ?? '') === 'expired')>Expired</option>
            </select>
            <p class="text-xs text-slate-500 mt-1">Select status explicitly or leave to be computed from start/end dates (if your controller supports it).</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-800">Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date', optional($event->start_date)->toDateString() ?? '') }}" class="mt-1 block w-full h-11 rounded-lg border px-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-800">End Date</label>
            <input type="date" name="end_date" value="{{ old('end_date', optional($event->end_date)->toDateString() ?? '') }}" class="mt-1 block w-full h-11 rounded-lg border px-3">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-800">Description</label>
            <textarea name="description" rows="4" class="mt-1 block w-full rounded-lg border px-3">{{ old('description', $event->description ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-800">Fee (optional)</label>
            {{-- <input type="number" name="fee" value="{{ old('fee', $event->fee ?? '') }}" class="mt-1 block w-full h-11 rounded-lg border px-3" step="1" min="0"> --}}
            <input name="fee" value="{{ old('fee', $event->fee ?? '') }}" class="mt-1 block w-full h-11 rounded-lg border px-3" placeholder="₹2,299 / Free / Pay at venue">
        </div>
    </div>



{{-- ADVANCED SETTINGS --}}
<div class="mt-6 rounded-xl border border-dashed p-5 bg-slate-50">
    <h3 class="text-sm font-semibold mb-3 text-slate-700">
        Advanced Submission Settings
    </h3>

    <div
        x-data="{
            autoClose: {{ old('auto_close_submission', $event->auto_close_submission ?? false) ? 'true' : 'false' }}
        }"
        class="space-y-4"
    >

        {{-- Auto Close Toggle --}}
        <label class="flex items-center gap-2 text-sm">
            <input
                type="checkbox"
                name="auto_close_submission"
                value="1"
                x-model="autoClose"
                class="text-emerald-600"
            >
            Enable auto-close registrations
        </label>

        {{-- Submission Window --}}
        <div x-show="autoClose" x-cloak class="grid gap-4 md:grid-cols-2">

            <div>
                <label class="block text-sm font-medium text-slate-800">
                    Submission Start Date
                </label>
                <input
                    type="date"
                    name="submission_start_date"
                    value="{{ old('submission_start_date', optional($event->submission_start_date)->toDateString() ?? '') }}"
                    class="mt-1 block w-full h-11 rounded-lg border px-3"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800">
                    Submission End Date
                </label>
                <input
                    type="date"
                    name="submission_end_date"
                    value="{{ old('submission_end_date', optional($event->submission_end_date)->toDateString() ?? '') }}"
                    class="mt-1 block w-full h-11 rounded-lg border px-3"
                >
            </div>

        </div>

        {{-- Submission Limit --}}
        <div x-show="autoClose" x-cloak>
            <label class="block text-sm font-medium text-slate-800">
                Maximum submissions allowed
            </label>
            <input
                type="number"
                name="submission_limit"
                value="{{ old('submission_limit', $event->submission_limit ?? 100) }}"
                min="1"
                class="mt-1 block w-40 h-11 rounded-lg border px-3"
            >
        </div>

        {{-- Show Remaining Seats --}}
        <label class="flex items-center gap-2 text-sm">
            <input
                type="checkbox"
                name="show_remaining_seats"
                value="1"
                {{ old('show_remaining_seats', $event->show_remaining_seats ?? false) ? 'checked' : '' }}
                class="text-emerald-600"
            >
            Show remaining seats publicly
        </label>

    </div>












{{-- Event Confirmation Email --}}
<div class="mt-6 rounded-xl border border-dashed bg-slate-50 p-5 space-y-4">
    <h3 class="text-sm font-semibold text-slate-700">
        Event Confirmation Email (Admin Action)
    </h3>

    <label class="flex items-center gap-2 text-sm">
        <input
            type="checkbox"
            name="admin_confirmation_enabled"
            value="1"
            @checked(old(
                'admin_confirmation_enabled',
                $event->admin_confirmation_enabled ?? false
            ))
            class="h-4 w-4 rounded border-slate-300 text-emerald-600"
        >
        Send confirmation email when admin confirms registration
    </label>

    <div class="mb-3">
        <label class="block text-sm font-medium text-slate-700">
            Confirmation Email Subject
        </label>
        <input type="text" name="admin_confirmation_email_subject"
            value="{{ old('admin_confirmation_email_subject', $event->admin_confirmation_email_subject ?? '') }}"
            class="mt-1 w-full rounded-lg border px-3 py-2 text-sm"
            placeholder="Your registration for @{{event_title}} is confirmed">
    </div>


    <textarea
        name="admin_confirmation_email_template"
        rows="6"
        class="w-full rounded-lg border px-3 py-2 text-sm"
        placeholder="Hello @{{full_name}}, your registration for @{{event_title}} has been confirmed."
    >{{ old(
        'admin_confirmation_email_template',
        $event->admin_confirmation_email_template ?? ''
    ) }}</textarea>

    <p class="text-xs text-slate-500">
        Available placeholders: @{{full_name}}, @{{email}}, @{{mobile}}, @{{event_title}}
    </p>
</div>



















</div>


    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-4 py-2 border rounded">Cancel</a>
        <button type="submit" class="inline-flex items-center bg-emerald-600 px-4 py-2 text-white rounded">Save</button>
    </div>






</form>
