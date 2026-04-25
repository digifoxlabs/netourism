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
    ];

    protected $casts = [
        'highlights' => 'array',
        'is_active'  => 'boolean',
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

}
