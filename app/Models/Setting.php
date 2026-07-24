<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? $default;

        // Cast based on type
        $record = static::where('key', $key)->first();
        if ($record) {
            return match ($record->type) {
                'boolean' => (bool) $value,
                'number' => (int) $value,
                'json' => json_decode($value, true),
                default => $value,
            };
        }

        return $default;
    }

    public static function set(string $key, mixed $value, string $type = 'text'): static
    {
        Cache::forget('settings');

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'type' => $type,
            ]
        );
    }

    public static function group(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group)->get();
    }
}
