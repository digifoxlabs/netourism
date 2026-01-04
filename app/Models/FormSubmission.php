<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'form_id',
        'event_id',
        'data',
        'ip_address',
        'user_agent',
        'status'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}