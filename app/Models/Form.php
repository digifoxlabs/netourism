<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
        protected $fillable = [
        'name',
        'slug',
        'description',
        'success_message',
        'redirect_url',
        'is_active',
        'auto_email_confirmation',
        'confirmation_email_template',
        'confirmation_email_subject',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function submissions()
    {
     return $this->hasMany(FormSubmission::class);
    }
}
