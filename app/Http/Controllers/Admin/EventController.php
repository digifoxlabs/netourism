<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Form;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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

        $eventSectionSettings = SiteSetting::getSettings([
            'home_show_active_events' => SiteSetting::HOME_SECTION_DEFAULTS['home_show_active_events'],
            'home_show_upcoming_events' => SiteSetting::HOME_SECTION_DEFAULTS['home_show_upcoming_events'],
        ]);

        return view('admin.events.index', compact('events', 'eventSectionSettings'));
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
            'payment_required'        => 'nullable|boolean',
            'payment_amount'          => 'nullable|numeric|min:1',
            'payment_options'         => ['nullable', 'array'],
            'payment_options.*.label' => ['nullable', 'string', 'max:255'],
            'payment_options.*.description' => ['nullable', 'string'],
            'payment_options.*.amount' => ['nullable', 'numeric', 'min:0'],
            'payment_options.*.type' => ['nullable', 'in:partial,full,pay_later'],
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
        $data['payment_required'] = $request->boolean('payment_required');
        $data['payment_options'] = $this->normalizePaymentOptions($request);
        $data['payment_amount'] = $data['payment_required'] ? $this->firstPayableAmount($data['payment_options']) : null;
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
                'payment_required'        => 'nullable|boolean',
                'payment_amount'          => 'nullable|numeric|min:1',
                'payment_options'         => ['nullable', 'array'],
                'payment_options.*.label' => ['nullable', 'string', 'max:255'],
                'payment_options.*.description' => ['nullable', 'string'],
                'payment_options.*.amount' => ['nullable', 'numeric', 'min:0'],
                'payment_options.*.type' => ['nullable', 'in:partial,full,pay_later'],
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
            $data['payment_required'] = $request->boolean('payment_required');
            $data['payment_options'] = $this->normalizePaymentOptions($request);
            $data['payment_amount'] = $data['payment_required'] ? $this->firstPayableAmount($data['payment_options']) : null;
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

    public function uploadEditorImage(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('file')->store('events/editor', 'public');

        return response()->json([
            'location' => Storage::url($path),
        ]);
    }

    public function destroy(Event $event)
    {
        if ($event->photo_path) {
            Storage::disk('public')->delete($event->photo_path);
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }

    private function normalizePaymentOptions(Request $request): ?array
    {
        if (!$request->boolean('payment_required')) {
            return null;
        }

        $options = collect($request->input('payment_options', []))
            ->map(function ($option) {
                $type = in_array(($option['type'] ?? 'full'), ['partial', 'full', 'pay_later'])
                    ? $option['type']
                    : 'full';

                return [
                    'label' => trim((string) ($option['label'] ?? '')),
                    'description' => trim((string) ($option['description'] ?? '')),
                    'amount' => $type === 'pay_later' ? (float) ($option['amount'] ?? 0) : (float) ($option['amount'] ?? 0),
                    'type' => $type,
                ];
            })
            ->filter(fn ($option) => $option['label'] !== '' && ($option['type'] === 'pay_later' || $option['amount'] > 0))
            ->values()
            ->all();

        if (!$options && (float) $request->input('payment_amount') > 0) {
            $options[] = [
                'label' => 'Full payment',
                'description' => '',
                'amount' => (float) $request->input('payment_amount'),
                'type' => 'full',
            ];
        }

        if (!$options) {
            throw ValidationException::withMessages([
                'payment_options' => 'Add at least one payment option or disable payment required.',
            ]);
        }

        return $options;
    }

    private function firstPayableAmount(?array $options): ?float
    {
        foreach ($options ?? [] as $option) {
            if (($option['type'] ?? null) !== 'pay_later' && (float) ($option['amount'] ?? 0) > 0) {
                return (float) $option['amount'];
            }
        }

        return null;
    }
}
