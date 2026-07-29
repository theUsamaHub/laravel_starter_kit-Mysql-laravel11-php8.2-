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
            return static::all()->mapWithKeys(fn($s) => [
                $s->key => ['value' => $s->value, 'type' => $s->type],
            ])->toArray();
        });

        $record = $settings[$key] ?? null;

        if ($record === null) {
            return $default;
        }

        return match ($record['type']) {
            'boolean' => (bool) $record['value'],
            'number' => (int) $record['value'],
            'json' => json_decode($record['value'], true),
            default => $record['value'],
        };
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
