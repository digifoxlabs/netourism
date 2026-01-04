<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventRegistration;

class EventRegistrationController extends Controller
{

    public function index()
    {
      
        return view('client.pages.events.index');
    //     $events = Event::orderBy('start_date')->get();

    // $today = now()->startOfDay();

    // $activeEvents = $events->filter(function ($event) use ($today) {
    //     return $event->start_date <= $today && $event->end_date >= $today;
    // });

    // $upcomingEvents = $events->filter(function ($event) use ($today) {
    //     return $event->start_date > $today;
    // });

    // $expiredEvents = $events->filter(function ($event) use ($today) {
    //     return $event->end_date < $today;
    // });

    // return view('events.index', compact('activeEvents', 'upcomingEvents', 'expiredEvents'));

    }


    public function create()
    {
        return view('client.pages.events.registration');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 1. Personal Details
            'full_name'                 => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'email', 'max:255'],
            'mobile'                    => ['required', 'string', 'max:20'],
            'city_state'                => ['required', 'string', 'max:255'],
            'date_of_birth'             => ['required', 'date'],
            'emergency_contact_person'  => ['required', 'string', 'max:255'],
            'emergency_contact_number'  => ['required', 'string', 'max:20'],

            // 2. Event & Ride Details
            'mode_of_transport'         => ['required', 'in:motorcycle,pillion,other'],
            'motorcycle_make_model'     => ['nullable', 'string', 'max:255'],
            'license_plate_number'      => ['nullable', 'string', 'max:50'],
            'is_pillion'                => ['nullable', 'boolean'],
            'primary_rider_name'        => ['nullable', 'string', 'max:255'],
            'accommodation_preference'  => ['required', 'in:tent_sharing,separate_tent'],
            'allergies_dietary'         => ['nullable', 'string'],

            // 3. Payment & Confirmation
            'payment_method'            => ['required', 'in:upi,bank_transfer'],
            'transaction_id'            => ['required', 'string', 'max:255'],
            'payment_date'              => ['required', 'date'],

            // 4. Terms & Conditions
            'terms_accepted'            => ['accepted'],
        ]);

        // Conditional validation: if mode_of_transport is motorcycle, motorcycle fields required
        if ($request->mode_of_transport === 'motorcycle') {
            $request->validate([
                'motorcycle_make_model' => ['required', 'string', 'max:255'],
                'license_plate_number'  => ['required', 'string', 'max:50'],
            ]);
        }

        // Conditional validation: if is_pillion = 1
        if ((bool) $request->boolean('is_pillion')) {
            $request->validate([
                'primary_rider_name' => ['required', 'string', 'max:255'],
            ]);
        }

        EventRegistration::create([
            'event_code'                => 'alfresco_2_2025',
            'event_name'                => 'Alfresco 2.0 - Embracing the Call of the Wild Kaziranga',

            'full_name'                 => $request->full_name,
            'email'                     => $request->email,
            'mobile'                    => $request->mobile,
            'city_state'                => $request->city_state,
            'date_of_birth'             => $request->date_of_birth,
            'emergency_contact_person'  => $request->emergency_contact_person,
            'emergency_contact_number'  => $request->emergency_contact_number,

            'mode_of_transport'         => $request->mode_of_transport,
            'motorcycle_make_model'     => $request->motorcycle_make_model,
            'license_plate_number'      => $request->license_plate_number,
            'is_pillion'                => $request->boolean('is_pillion'),
            'primary_rider_name'        => $request->primary_rider_name,
            'accommodation_preference'  => $request->accommodation_preference,
            'allergies_dietary'         => $request->allergies_dietary,

            'payment_method'            => $request->payment_method,
            'transaction_id'            => $request->transaction_id,
            'payment_date'              => $request->payment_date,

            'terms_accepted'            => $request->boolean('terms_accepted'),
        ]);

        return redirect()
            ->route('events.create')
            ->with('success', 'Thank you for registering! Your Alfresco 2.0 entry has been recorded.');
    }
}