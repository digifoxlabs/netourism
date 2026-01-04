<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class FormBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Form::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form = new Form();

        // No sections yet on create
        $sections = [];

        return view('admin.forms.create', ['form' =>null, 'sections' => [],'placeholders' => []]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    //     {
    //         // Basic form validation
    //         $data = $request->validate([
    //             'name'            => ['required', 'string', 'max:255'],
    //             'slug'            => ['nullable', 'string', 'max:255', 'unique:forms,slug'],
    //             'description'     => ['nullable', 'string'],
    //             'success_message' => ['nullable', 'string'],
    //             'redirect_url'    => ['nullable', 'url'],
    //             'is_active'       => ['nullable', 'boolean'],
    //             // fields handled separately
    //         ]);

    //         if (empty($data['slug'])) {
    //             $data['slug'] = Str::slug($data['name']);
    //         }

    //         $data['is_active'] = $request->boolean('is_active');

    //         $form = Form::create($data);

    //         // Handle fields (JSON from hidden input)
    //         $this->syncFields($form, $request);

    //         return redirect()
    //             ->route('admin.forms.index')
    //             ->with('success', 'Form created successfully.');
    //     }

    public function store(Request $request)
    {
        // Basic form validation
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'slug'            => ['nullable', 'string', 'max:255', 'unique:forms,slug'],
            'description'     => ['nullable', 'string'],
            'success_message' => ['nullable', 'string'],
            'redirect_url'    => ['nullable', 'url'],
            'is_active'       => ['nullable', 'boolean'],

            // 🔹 EMAIL SETTINGS
            'auto_email_confirmation'      => ['nullable', 'boolean'],
            'confirmation_email_template'  => ['nullable', 'string'],

            'confirmation_email_subject' => ['nullable', 'string', 'max:255'],


            // fields handled separately
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_active'] = $request->boolean('is_active');

        // 🔹 EMAIL FLAGS (important for checkbox handling)
        $data['auto_email_confirmation'] =
            $request->boolean('auto_email_confirmation');

        $data['confirmation_email_template'] =
            $data['confirmation_email_template'] ?? null;

        $form = Form::create($data);

        // Handle fields (JSON from hidden input)
        $this->syncFields($form, $request);

        return redirect()
            ->route('admin.forms.index')
            ->with('success', 'Form created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Form $form)
    // {
    //     $fields = $form->fields()->orderBy('sort_order')->get();

    //     $sections = [];

    //     if ($fields->isNotEmpty()) {
    //         $sections[] = [
    //             'title'  => 'Main Section',
    //             'fields' => $fields->map(function (FormField $field) {
    //                 return [
    //                     'label'       => $field->label,
    //                     'name'        => $field->name,
    //                     'type'        => $field->type,
    //                     'placeholder' => $field->placeholder,
    //                     'help_text'   => $field->help_text,
    //                     'required'    => $field->required,
    //                     'options_raw' => $field->options ? implode("\n", $field->options) : '',
    //                     'width'       => $field->width ?? 'full',
    //                     'conditional_enabled'  => $field->conditional_enabled,
    //                     'conditional_field'    => $field->conditional_field,
    //                     'conditional_operator' => $field->conditional_operator,
    //                     'conditional_value'    => $field->conditional_value,
    //                 ];
    //             })->values()->toArray(),
    //         ];
    //     }

    //     return view('admin.forms.edit', compact('form', 'sections'));
    // }


    // public function edit(Form $form)
    // {
    //     $form->load('fields');

    //     return view('admin.forms.edit', [
    //         'form' => $form,
    //         'sections' => $form->fields
    //             ->groupBy(fn($f) => $f->section_title ?: 'Main')
    //             ->map(fn($fields, $title) => [
    //                 'title' => $title,
    //                 'fields' => $fields->map(fn($f) => [
    //                     'label' => $f->label,
    //                     'name' => $f->name,
    //                     'type' => $f->type,
    //                     'placeholder' => $f->placeholder,
    //                     'help_text' => $f->help_text,
    //                     'required' => $f->required,
    //                     'options_raw' => $f->options_raw,
    //                     'width' => $f->width,
    //                     'conditional_enabled' => $f->conditional_enabled,
    //                     'conditional_field' => $f->conditional_field,
    //                     'conditional_operator' => $f->conditional_operator,
    //                     'conditional_value' => $f->conditional_value,
    //                 ]),
    //             ])->values(),
    //     ]);
    // }


    public function edit(Form $form)
{
    $form->load('fields');

    $sections = $form->fields
        ->groupBy(fn ($f) => $f->section_title ?: 'Main')
        ->map(fn ($fields, $title) => [
            'title' => $title,
            'fields' => $fields->map(fn ($f) => [
                'label'                => $f->label,
                'name'                 => $f->name,
                'type'                 => $f->type,
                'placeholder'          => $f->placeholder,
                'help_text'            => $f->help_text,
                'required'             => $f->required,
                'options_raw'          => $f->options_raw,
                'width'                => $f->width,
                'conditional_enabled'  => $f->conditional_enabled,
                'conditional_field'    => $f->conditional_field,
                'conditional_operator' => $f->conditional_operator,
                'conditional_value'    => $f->conditional_value,
            ]),
        ])->values();

    // ✅ ADD THIS — FLAT LIST OF FIELD NAMES
    $placeholders = $form->fields
        ->pluck('name')
        ->filter()
        ->values();

    return view('admin.forms.edit', [
        'form'         => $form,
        'sections'     => $sections,
        'placeholders' => $placeholders, // ✅ PASS TO VIEW
    ]);
}



    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Form $form)
    //     {
    //         $data = $request->validate([
    //             'name'            => ['required', 'string', 'max:255'],
    //             'slug'            => ['nullable', 'string', 'max:255', 'unique:forms,slug,' . $form->id],
    //             'description'     => ['nullable', 'string'],
    //             'success_message' => ['nullable', 'string'],
    //             'redirect_url'    => ['nullable', 'url'],
    //             'is_active'       => ['nullable', 'boolean'],
    //         ]);

    //         if (empty($data['slug'])) {
    //             $data['slug'] = Str::slug($data['name']);
    //         }

    //         $data['is_active'] = $request->boolean('is_active');

    //         $form->update($data);

    //         // Re-sync fields from builder JSON
    //         $this->syncFields($form, $request);

    //         return redirect()
    //             ->route('admin.forms.index')
    //             ->with('success', 'Form updated successfully.');
    // }

    public function update(Request $request, Form $form)
    {
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'slug'            => ['nullable', 'string', 'max:255', 'unique:forms,slug,' . $form->id],
            'description'     => ['nullable', 'string'],
            'success_message' => ['nullable', 'string'],
            'redirect_url'    => ['nullable', 'url'],
            'is_active'       => ['nullable', 'boolean'],

            // 🔹 EMAIL SETTINGS
            'auto_email_confirmation'     => ['nullable', 'boolean'],
            'confirmation_email_template' => ['nullable', 'string'],
            'confirmation_email_subject' => ['nullable', 'string', 'max:255'],

        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_active'] = $request->boolean('is_active');

        // 🔹 EMAIL FLAGS (checkbox-safe)
        $data['auto_email_confirmation'] =
            $request->boolean('auto_email_confirmation');

        $data['confirmation_email_template'] =
            $data['confirmation_email_template'] ?? null;

        $form->update($data);

        // Re-sync fields from builder JSON
        $this->syncFields($form, $request);

        return redirect()
            ->route('admin.forms.index')
            ->with('success', 'Form updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {

    if ($form->events()->exists()) {
        return back()->with('success', 'Form is attached to an event and cannot be deleted.');
    }

        $form->delete();

        return redirect()
            ->route('admin.forms.index')
            ->with('success', 'Form deleted successfully.');
    }

 
/**
     * Preview form – read-only UI.
     */
    public function preview(Form $form)
    {
        // Get fields ordered for display
        $fields = $form->fields()->orderBy('sort_order')->get();

        // Group by section_title (fallback to 'Form')
        $sections = $fields->groupBy(function ($field) {
            return $field->section_title ?: 'Form';
        });

        return view('admin.forms.preview', [
            'form'     => $form,
            'sections' => $sections,
        ]);
    }

    /**
     * Sync fields from request JSON.
     */
    protected function syncFields(Form $form, Request $request): void
    {
        $fieldsJson = $request->input('fields_json');

        if (!$fieldsJson) {
            $form->fields()->delete();
            return;
        }

        $fields = json_decode($fieldsJson, true) ?? [];

        $form->fields()->delete();

        foreach ($fields as $index => $field) {
            if (empty($field['label']) || empty($field['name']) || empty($field['type'])) {
                continue;
            }

            $options = null;
            if (in_array($field['type'], ['select', 'radio', 'checkbox']) && !empty($field['options_raw'])) {
                $options = collect(preg_split("/\r\n|\n|\r/", $field['options_raw']))
                    ->filter()
                    ->values()
                    ->all();
            }

            FormField::create([
                'form_id'       => $form->id,
                'section_title' => $field['section_title'] ?? null,  // <-- new
                'label'         => $field['label'],
                'name'          => $field['name'],
                'type'          => $field['type'],
                'placeholder'   => $field['placeholder'] ?? null,
                'help_text'     => $field['help_text'] ?? null,
                'required'      => !empty($field['required']),
                'options'       => $options,
                'validation_rules' => null,
                'sort_order'    => $index,
                'width'         => $field['width'] ?? 'full',

                  // NEW:
                'conditional_enabled'  => !empty($field['conditional_enabled']),
                'conditional_field'    => $field['conditional_field'] ?? null,
                'conditional_operator' => $field['conditional_operator'] ?? null,
                'conditional_value'    => $field['conditional_value'] ?? null,
            ]);
        }
    }


    //Form Clone
    public function clone(Form $form)
    {
        DB::transaction(function () use ($form) {

            $newForm = $form->replicate();
            $newForm->name = $form->name . ' (Copy)';
            $newForm->slug = $form->slug . '-copy-' . now()->timestamp;
            $newForm->is_active = false;
            $newForm->save();

            foreach ($form->fields as $field) {
                $newField = $field->replicate();
                $newField->form_id = $newForm->id;
                $newField->save();
            }
        });

        return redirect()
            ->route('admin.forms.index')
            ->with('success', 'Form cloned successfully.');
    }




}
