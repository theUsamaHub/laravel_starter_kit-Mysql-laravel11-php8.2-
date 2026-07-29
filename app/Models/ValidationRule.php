<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class ValidationRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_name',
        'rules',
        'custom_messages',
    ];

    protected $casts = [
        'rules' => 'array',
        'custom_messages' => 'array',
    ];

    public static function getRecord(string $formName): ?static
    {
        return Cache::remember("validation_rule.{$formName}", 3600, function () use ($formName) {
            return static::where('form_name', $formName)->first();
        });
    }

    public static function getRules(string $formName): array
    {
        return self::getRecord($formName)?->rules ?? [];
    }

    public static function getMessages(string $formName): array
    {
        return self::getRecord($formName)?->custom_messages ?? [];
    }

    protected static function booted(): void
    {
        static::saved(fn() => Cache::forget("validation_rule." . request('form_name') ?? ''));
        static::deleted(fn() => Cache::forget("validation_rule." . request('form_name') ?? ''));
    }
}
