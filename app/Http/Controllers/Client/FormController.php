<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Helpers\EmailTemplateHelper;
use App\Mail\FormSubmissionConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Support\FormAutoEmailService;
use App\Services\EmailTemplateService;
use App\Mail\GenericSubmissionMail;

class FormController extends Controller
{
    public function show($slug)
    {
        $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $fields = $form->fields()->orderBy('sort_order')->get();
        $sections = $fields->groupBy(fn($f) => $f->section_title ?: 'Form');

        return view('client.forms.show', compact('form', 'sections'));
    }



    // public function submit(Request $request, string $slug)
    // {
    //     $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();

    //     $fields = $form->fields()->orderBy('sort_order')->get();

    //     $rules = [];
    //     foreach ($fields as $field) {
    //         $rules[$field->name] = $field->required ? 'required' : 'nullable';
    //     }

    //     $validated = $request->validate($rules);

    //     $submission = FormSubmission::create([
    //         'form_id' => $form->id,
    //         'event_id' => null,
    //         'data' => $validated,
    //         'status' => 'pending',
    //         'ip_address' => $request->ip(),
    //         'user_agent' => $request->userAgent(),
    //     ]);

    //     // AUTO EMAIL
    //     if ($form->auto_email_confirmation && $form->confirmation_email_template) {
    //         $email = $validated['email'] ?? null;

    //         if ($email) {
    //             $content = EmailTemplateHelper::render(
    //                 $form->confirmation_email_template,
    //                 $validated
    //             );

    //             Mail::to($email)
    //                 ->bcc(config('mail.admin_email'))
    //                 ->send(new FormSubmissionConfirmationMail($content));
    //         }
    //     }

    //     return back()->with('success', 'Thank you! Your submission has been received.');
    // }


public function submit(Request $request, $slug)
{
    $form = Form::where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

    $fields = $form->fields()->orderBy('sort_order')->get();

    $rules = [];
    $labels = [];

    foreach ($fields as $field) {
        $rule = $field->required ? ['required'] : ['nullable'];

        if ($field->type === 'email') $rule[] = 'email';
        if ($field->type === 'number') $rule[] = 'numeric';
        if ($field->type === 'date') $rule[] = 'date';

        $rules[$field->name] = implode('|', $rule);
        $labels[$field->name] = $field->label;
    }

    $validated = $request->validate($rules, [], $labels);

    $submission = FormSubmission::create([
        'form_id'    => $form->id,
        'data'       => $validated,
        'status'     => 'confirmed', // standalone forms auto-confirmed
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    /*
    |--------------------------------------------------------------------------
    | AUTO EMAIL CONFIRMATION (FORM LEVEL)
    |--------------------------------------------------------------------------
    */
    if ($form->auto_email_confirmation && $form->confirmation_email_template) {

        // Detect user email dynamically
        $userEmail = null;
        foreach ($submission->data as $key => $value) {
            if (
                str_contains(strtolower($key), 'email') &&
                filter_var($value, FILTER_VALIDATE_EMAIL)
            ) {
                $userEmail = $value;
                break;
            }
        }

        if ($userEmail) {
            
            $subject = EmailTemplateService::render(
                $form->confirmation_email_subject ?: 'Form Submitted',
                $submission
            );

            $body = EmailTemplateService::render(
                $form->confirmation_email_template,
                $submission
            );

            Mail::to($userEmail)
                ->bcc(config('mail.admin_email'))
                ->send(new GenericSubmissionMail($subject, nl2br($body)));
        }
    }


    if ($form->redirect_url) {
             return redirect()->away($form->redirect_url);
    }

    return back()->with(
        'success',
        $form->success_message ?: 'Thank you. Your submission has been received.'
    );
}








}
