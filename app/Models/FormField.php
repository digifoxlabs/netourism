<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
     protected $fillable = [
        'form_id',
        'section_title',   // <-- add this
        'label',
        'name',
        'type',
        'placeholder',
        'help_text',
        'required',
        'options',
        'validation_rules',
        'sort_order',
        'width',
        'conditional_enabled',
        'conditional_field',
        'conditional_operator',
        'conditional_value',
    ];

    protected $casts = [
        'required'         => 'boolean',
        'options'          => 'array',
        'validation_rules' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
