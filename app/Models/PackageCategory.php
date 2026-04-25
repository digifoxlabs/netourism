<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PackageCategory extends Model
{
    public const DEFAULT_CATEGORY_NAMES = [
        'India Trip',
        'North East India',
        'International Trip',
    ];

    protected $fillable = [
        'name',
        'slug',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'category_id');
    }

    protected static function booted(): void
    {
        static::saving(function (self $category) {
            if (blank($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public static function defaultCategory(): self
    {
        return static::firstOrCreate(
            ['slug' => Str::slug('India Trip')],
            ['name' => 'India Trip']
        );
    }
}
