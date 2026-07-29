<?php

namespace App\Models;

use App\Traits\HasMedia;
use App\Traits\HasTags;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasMedia, HasTags, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'body',
        'image',
        'is_active',
        'sort_order',
        'published_at',
        'unpublish_at',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
            'unpublish_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('published_at')
              ->orWhere('published_at', '<=', now());
        })->where(function ($q) {
            $q->whereNull('unpublish_at')
              ->orWhere('unpublish_at', '>', now());
        });
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('published_at', '>', now());
    }

    public function scopeExpiring(Builder $query): Builder
    {
        return $query->whereNotNull('unpublish_at')
            ->where('unpublish_at', '<=', now());
    }

    public function getIsPublishedAttribute(): bool
    {
        if ($this->published_at && $this->published_at->isFuture()) {
            return false;
        }
        if ($this->unpublish_at && $this->unpublish_at->isPast()) {
            return false;
        }
        return true;
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
            $category->created_by = auth()->id() ?? $category->created_by;
        });

        static::updating(function (Category $category) {
            if ($category->isDirty('name') && !$category->slug) {
                $category->slug = Str::slug($category->name);
            }
            $category->updated_by = auth()->id() ?? $category->updated_by;
        });
    }
}
