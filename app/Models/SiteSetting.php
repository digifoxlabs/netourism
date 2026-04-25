<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    public const HOME_SECTION_DEFAULTS = [
        'home_show_active_events' => true,
        'home_show_upcoming_events' => true,
        'home_show_seven_sisters' => true,
        'home_show_best_time_to_travel' => true,
        'home_show_planning_your_trip' => true,
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getSettings(array $defaults): array
    {
        if (!Schema::hasTable((new static())->getTable())) {
            return $defaults;
        }

        $storedValues = static::query()
            ->whereIn('key', array_keys($defaults))
            ->pluck('value', 'key');

        $settings = [];

        foreach ($defaults as $key => $default) {
            $value = $storedValues->get($key, $default);
            $settings[$key] = static::castValue($value, $default);
        }

        return $settings;
    }

    public static function setSettings(array $settings): void
    {
        if (!Schema::hasTable((new static())->getTable())) {
            return;
        }

        foreach ($settings as $key => $value) {
            static::query()->updateOrCreate(
                ['key' => $key],
                ['value' => is_bool($value) ? (string) (int) $value : (string) $value]
            );
        }
    }

    protected static function castValue(mixed $value, mixed $default): mixed
    {
        if (is_bool($default)) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
        }

        return $value;
    }
}
