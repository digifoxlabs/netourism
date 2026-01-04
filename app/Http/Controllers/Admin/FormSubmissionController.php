<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Event;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use App\Helpers\EmailTemplateHelper;
use App\Mail\EventRegistrationConfirmedMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericSubmissionMail;
use App\Services\EmailTemplateService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Exports\FormSubmissionsExport;
use Maatwebsite\Excel\Facades\Excel;

class FormSubmissionController extends Controller
{
    // public function index(Request $request)
    // {
    //     // optional filters: form_id, event_id
    //     $query = FormSubmission::with(['form', 'event'])->orderBy('created_at', 'desc');

    //     if ($request->filled('form_id')) {
    //         $query->where('form_id', $request->form_id);
    //     }

    //     if ($request->filled('event_id')) {
    //         $query->where('event_id', $request->event_id);
    //     }

    //     $submissions = $query->paginate(25);

    //     $forms = Form::orderBy('name')->get();
    //     $events = Event::orderBy('start_date', 'desc')->get();

    //     return view('admin.submissions.index', compact('submissions', 'forms', 'events'));
    // }


    public function index(Request $request)
    {
        $query = FormSubmission::with(['form', 'event'])->latest();

        // Filter by form
        if ($request->filled('form_id')) {
            $query->where('form_id', $request->form_id);
        }

        // Filter by event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // ✅ Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(5);

        return view('admin.submissions.index', [
            'submissions' => $submissions,
            'forms'       => Form::orderBy('name')->get(),
            'events'      => Event::orderBy('title')->get(),
        ]);
    }


    // public function show(FormSubmission $submission)
    // {
    //     $form = $submission->form;

    //     $sections = collect([]);

    //     if ($form) {
    //         $fields = $form->fields()
    //             ->orderBy('sort_order')
    //             ->get();

    //         $sections = $fields->groupBy(function ($field) {
    //             return $field->section_title ?: 'Form';
    //         });
    //     }

    //     return view('admin.submissions.show', compact(
    //         'submission',
    //         'form',
    //         'sections'
    //     ));
    // }


    // public function edit(FormSubmission $submission)
    // {
    //     $form = $submission->form;

    //     $fields = collect([]);
    //     $sections = collect([]);

    //     if ($form) {
    //         $fields = $form->fields()
    //             ->orderBy('sort_order')
    //             ->get();

    //         $sections = $fields->groupBy(function ($field) {
    //             return $field->section_title ?: 'Form';
    //         });
    //     }

    //     return view('admin.submissions.edit', compact(
    //         'submission',
    //         'form',
    //         'fields',
    //         'sections'
    //     ));
    // }


    // public function update(Request $request, FormSubmission $submission)
    // {
    //     $form = $submission->form;

    //     if (!$form) {
    //         abort(404);
    //     }

    //     $fields = $form->fields()->get();

    //     $rules = [];
    //     foreach ($fields as $field) {
    //         $rules[$field->name] = $field->required ? 'required' : 'nullable';
    //     }

    //     $validated = $request->validate($rules);

    //     $submission->update([
    //         'data' => $validated,
    //         'status' => $request->status,
    //     ]);

    //     return redirect()
    //         ->route('admin.submissions.show', $submission)
    //         ->with('success', 'Submission updated successfully.');
    // }







    // public function confirm(FormSubmission $submission)
    //     {
    //     if (($submission->status ?? 'pending') !== 'pending') {
    //         return back()->with('success', 'Submission already processed.');
    //     }

    //     $submission->update([
    //         'status' => 'confirmed',
    //     ]);

    //     // Optional (future):
    //     // Mail::to($submission->data['email'] ?? null)->send(...)

    //     return back()->with('success', 'Submission confirmed successfully.');
    // }




public function show(FormSubmission $submission)
{
    $form = $submission->form;

    $sections = collect([]);

    if ($form) {
        $sections = $form->fields()
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn($f) => $f->section_title ?: 'Form');
    }

    return view('admin.submissions.show', compact('submission','form','sections'));
}

public function edit(FormSubmission $submission)
{
    $form = $submission->form;

    $sections = $form
        ? $form->fields()->orderBy('sort_order')->get()
            ->groupBy(fn($f) => $f->section_title ?: 'Form')
        : collect();

    return view('admin.submissions.edit', compact('submission','form','sections'));
}

public function update(Request $request, FormSubmission $submission)
{
    $fields = $submission->form->fields;

    $rules = [];
    foreach ($fields as $field) {
        $rules[$field->name] = $field->required ? 'required' : 'nullable';
    }

    $validated = $request->validate($rules);

    $submission->update([
        'data' => $validated,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('admin.submissions.show', $submission)
        ->with('success', 'Submission updated.');
}

// public function confirm(FormSubmission $submission)
// {
//     if ($submission->status !== 'pending') {
//         return back();
//     }

//     $event = $submission->event;

//     if ($event && $event->confirmation_email_template) {

//         $data = array_merge(
//             $submission->data,
//             ['event_title' => $event->title, 'fee' => $event->fee]
//         );

//         $content = EmailTemplateHelper::render(
//             $event->confirmation_email_template,
//             $data
//         );

//         $email = $submission->data['email'] ?? null;

//         if ($email) {
//             Mail::to($email)
//                 ->bcc(config('mail.admin_email'))
//                 ->send(new EventRegistrationConfirmedMail($content));
//         }
//     }

//     $submission->update([
//         'status' => 'confirmed',
//         'confirmed_at' => now(),
//     ]);

//     return back()->with('success', 'Submission confirmed and email sent.');
// }



public function confirm(FormSubmission $submission)
{
    if ($submission->status === 'confirmed') {
        return back()->with('error', 'Already confirmed.');
    }

    $submission->update([
        'status' => 'confirmed',
        'confirmed_at' => now(),
    ]);

    $event = $submission->event;

    // MODEL A: Event owns confirmation email
    if (
        $event &&
        $event->admin_confirmation_enabled &&
        $event->admin_confirmation_email_template
    ) {
        $userEmail = $submission->data['email'] ?? null;

        if ($userEmail) {
            // $html = EmailTemplateService::render(
            //     $event->admin_confirmation_email_template,
            //     $submission
            // );

            // Mail::to($userEmail)
            //     ->bcc(config('mail.admin_email'))
            //     ->send(new GenericSubmissionMail(
            //         'Registration Confirmed',
            //         $html
            //     ));

            $subject = EmailTemplateService::render(
                $event->admin_confirmation_email_subject ?: 'Registration Confirmed',
                $submission
            );

            $body = EmailTemplateService::render(
                $event->admin_confirmation_email_template,
                $submission
            );

            Mail::to($userEmail)
                ->bcc(config('mail.admin_email'))
                ->send(new GenericSubmissionMail($subject, nl2br($body)));
        }
    }

    return back()->with('success', 'Registration confirmed.');
}


        public function destroy(FormSubmission $submission)
        {
            $submission->delete();

            return redirect()
                ->back()
                ->with('success', 'Submission deleted.');
    }







    public function exportCsv(Request $request): StreamedResponse
{
    $query = FormSubmission::with(['form', 'event'])->latest();

    // Apply same filters as index
    if ($request->filled('form_id')) {
        $query->where('form_id', $request->form_id);
    }

    if ($request->filled('event_id')) {
        $query->where('event_id', $request->event_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $submissions = $query->get();

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => 'attachment; filename="form-submissions.csv"',
    ];

    return response()->stream(function () use ($submissions) {
        $handle = fopen('php://output', 'w');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'Submitted At',
            'Status',
            'Form',
            'Event',
            'Data'
        ]);

        foreach ($submissions as $s) {
            fputcsv($handle, [
                $s->id,
                $s->created_at->format('Y-m-d H:i:s'),
                $s->status,
                $s->form->name ?? '',
                $s->event->title ?? '',
                json_encode($s->data, JSON_UNESCAPED_UNICODE),
            ]);
        }

        fclose($handle);
    }, 200, $headers);
}




public function exportExcel(Request $request)
{
    $query = FormSubmission::with(['form', 'event'])->latest();

    if ($request->filled('form_id')) {
        $query->where('form_id', $request->form_id);
    }

    if ($request->filled('event_id')) {
        $query->where('event_id', $request->event_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $submissions = $query->get();

    return Excel::download(
        new FormSubmissionsExport($submissions),
        'form-submissions.xlsx'
    );
}





}
