<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public static function getRules(string $formName): array
    {
        $record = static::where('form_name', $formName)->first();
        return $record?->rules ?? [];
    }

    public static function getMessages(string $formName): array
    {
        $record = static::where('form_name', $formName)->first();
        return $record?->custom_messages ?? [];
    }
}
