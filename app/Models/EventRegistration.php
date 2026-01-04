<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_code',
        'event_name',
        'full_name',
        'email',
        'mobile',
        'city_state',
        'date_of_birth',
        'emergency_contact_person',
        'emergency_contact_number',
        'mode_of_transport',
        'motorcycle_make_model',
        'license_plate_number',
        'is_pillion',
        'primary_rider_name',
        'accommodation_preference',
        'allergies_dietary',
        'payment_method',
        'transaction_id',
        'payment_date',
        'terms_accepted',
        'status'
    ];

    protected $casts = [
        'date_of_birth'    => 'date',
        'payment_date'     => 'date',
        'is_pillion'       => 'boolean',
        'terms_accepted'   => 'boolean',
    ];
}