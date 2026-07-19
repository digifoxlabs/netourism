<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PackageGallery;
use App\Models\PackageCategory;


class Package extends Model
{
    protected $fillable = [
        'name',
        'subtitle',
        'category_id',
        'description',
        'thumbnail_image',
        'hero_image',
        'itinerary',
        'duration_days',
        'is_active',
        'form_id',
        'payment_required',
        'payment_amount',
    ];

    protected $casts = [
        'highlights' => 'array',
        'is_active'  => 'boolean',
        'payment_required' => 'boolean',
        'payment_amount' => 'decimal:2',
         'itinerary' => 'array',
    ];

    public function gallery()
    {
        return $this->hasMany(PackageGallery::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function category()
    {
        return $this->belongsTo(PackageCategory::class, 'category_id');
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
