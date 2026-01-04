<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query
            ->orderBy('created_at', 'desc')
            ->paginate(12)      // ← pagination
            ->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $forms = Form::where('is_active', true)->orderBy('name')->get();
        $event = new Event();
        return view('admin.events.create', compact('event', 'forms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                   => 'required|string|max:255',
            'slug'                    => 'nullable|string|max:255|unique:events,slug',
            'subtitle'                => 'nullable|string|max:255',
            'description'             => 'nullable|string',

            'start_date'              => 'nullable|date',
            'end_date'                => 'nullable|date|after_or_equal:start_date',

            'submission_start_date'   => 'nullable|date',
            'submission_end_date'     => 'nullable|date|after_or_equal:submission_start_date',

            'fee'                     => 'nullable|string|max:50',
            'status'                  => 'nullable|in:active,upcoming,expired',

            'form_id'                 => 'nullable|exists:forms,id',

            // Advanced
            'auto_close_submission'   => 'nullable|boolean',
            'submission_limit'        => 'nullable|integer|min:1',
            'show_remaining_seats'    => 'nullable|boolean',

            'photo'                   => 'nullable|image|max:2048',

            'admin_confirmation_email_subject' => ['nullable', 'string', 'max:255'],

        ]);

        $data['auto_close_submission'] = $request->boolean('auto_close_submission');
        $data['show_remaining_seats']  = $request->boolean('show_remaining_seats');
        $data['submission_limit']      = $request->input('submission_limit', 100);

        $data['admin_confirmation_enabled'] = $request->boolean('admin_confirmation_enabled');

        $data['admin_confirmation_email_template'] = $request->admin_confirmation_email_template;

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('events', 'public');
            $data['photo_path'] = $path;
        }

       // $data['is_active'] = $request->boolean('is_active');

        $event = Event::create($data);

        // Auto-status if admin did not force it
        if (!$request->filled('status')) {
            $event->update([
                'status' => $event->computeStatus(),
            ]);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function edit(Event $event)
    {
        $forms = Form::where('is_active', true)->orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'forms'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
                'title'                   => 'required|string|max:255',
                'slug'                    => 'nullable|string|max:255|unique:events,slug,' . $event->id,
                'subtitle'                => 'nullable|string|max:255',
                'description'             => 'nullable|string',

                'start_date'              => 'nullable|date',
                'end_date'                => 'nullable|date|after_or_equal:start_date',

                'submission_start_date'   => 'nullable|date',
                'submission_end_date'     => 'nullable|date|after_or_equal:submission_start_date',

                'fee'                     => 'nullable|string|max:50',
                'status'                  => 'nullable|in:active,upcoming,expired',

                'form_id'                 => 'nullable|exists:forms,id',

                'auto_close_submission'   => 'nullable|boolean',
                'submission_limit'        => 'nullable|integer|min:1',
                'show_remaining_seats'    => 'nullable|boolean',

                'photo'                   => 'nullable|image|max:2048',
                'admin_confirmation_email_subject' => ['nullable', 'string', 'max:255'],

        ]);

            $data['auto_close_submission'] = $request->boolean('auto_close_submission');
            $data['show_remaining_seats']  = $request->boolean('show_remaining_seats');
            $data['submission_limit']      = $request->input('submission_limit', 100);

            $data['admin_confirmation_enabled'] = $request->boolean('admin_confirmation_enabled');

            $data['admin_confirmation_email_template'] = $request->admin_confirmation_email_template;

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('photo')) {
            // delete old
            if ($event->photo_path) {
                Storage::disk('public')->delete($event->photo_path);
            }
            $path = $request->file('photo')->store('events', 'public');
            $data['photo_path'] = $path;
        }

       // $data['is_active'] = $request->boolean('is_active');

        $event->update($data);

        if (!$request->filled('status')) {
        $event->update([
            'status' => $event->computeStatus(),
        ]);
    }

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        if ($event->photo_path) {
            Storage::disk('public')->delete($event->photo_path);
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }
}
