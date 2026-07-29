<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'subscribed_at',
        'unsubscribed_at',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotNull('subscribed_at')->whereNull('unsubscribed_at');
    }

    public function isActive(): bool
    {
        return $this->subscribed_at && !$this->unsubscribed_at;
    }
}
