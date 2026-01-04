<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventRegistrationConfirmed;

class AdminEventRegistrationController extends Controller
{

    public function index(Request $request){
            $query = EventRegistration::query();

            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('city_state', 'like', "%{$search}%");
                });
            }

            $registrations = $query->latest()->paginate(15)->appends($request->query());

            return view('admin.events-registration.index', compact('registrations', 'search'));
    }


    public function show(EventRegistration $event_registration)
    {
        return view('admin.events-registration.registrations', compact('event_registration'));
    }

    public function edit(EventRegistration $event_registration)
    {
        return view('admin.events-registration.registrations-edit', compact('event_registration'));
    }

    public function update(Request $request, EventRegistration $event_registration)
    {
        $validated = $request->validate([
            'event_code'               => ['required', 'string', 'max:255'],
            'event_name'               => ['required', 'string', 'max:255'],
            'full_name'                => ['required', 'string', 'max:255'],
            'email'                    => ['required', 'email', 'max:255'],
            'mobile'                   => ['required', 'string', 'max:50'],
            'city_state'               => ['required', 'string', 'max:255'],
            'date_of_birth'            => ['required', 'date'],
            'emergency_contact_person' => ['required', 'string', 'max:255'],
            'emergency_contact_number' => ['required', 'string', 'max:50'],

            'mode_of_transport'        => ['required', 'in:motorcycle,pillion,other'],
            'motorcycle_make_model'    => ['nullable', 'string', 'max:255'],
            'license_plate_number'     => ['nullable', 'string', 'max:255'],
            'is_pillion'               => ['nullable', 'boolean'],
            'primary_rider_name'       => ['nullable', 'string', 'max:255'],
            'accommodation_preference' => ['required', 'in:tent_sharing,separate_tent'],
            'allergies_dietary'        => ['nullable', 'string'],

            'payment_method'           => ['required', 'in:upi,bank_transfer'],
            'transaction_id'           => ['required', 'string', 'max:255'],
            'payment_date'             => ['required', 'date'],

            'terms_accepted'           => ['nullable', 'boolean'],
            'status'                   => ['required', 'in:pending,confirmed'],
        ]);

        // Checkboxes / booleans
        $validated['is_pillion'] = $request->boolean('is_pillion');
        $validated['terms_accepted'] = $request->boolean('terms_accepted');

        $event_registration->update($validated);

        return redirect()
            ->route('admin.event-registrations.index')
            ->with('success', 'Event registration updated successfully.');
    }

    public function destroy(EventRegistration $event_registration)
    {
        $event_registration->delete();

        return redirect()
            ->route('admin.event-registrations.index')
            ->with('success', 'Event registration deleted successfully.');
    }


    //Confirm Registration and send email
    public function confirm(EventRegistration $event_registration)
    {
        if ($event_registration->status === 'confirmed') {
            return redirect()
                ->route('admin.event-registrations.show', $event_registration)
                ->with('success', 'This registration is already confirmed.');
        }

        $event_registration->status = 'confirmed';
        $event_registration->save();

        Mail::to($event_registration->email)
            ->send(new EventRegistrationConfirmed($event_registration));

        return redirect()
            ->route('admin.event-registrations.show', $event_registration)
            ->with('success', 'Registration confirmed and confirmation email sent.');
    }



}
