<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function attachTags(array|int|string $tags): void
    {
        $tagIds = collect($tags)->map(function ($tag) {
            if ($tag instanceof Tag) return $tag->id;
            return Tag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tag)],
                ['name' => $tag]
            )->id;
        })->toArray();
        $this->tags()->syncWithoutDetaching($tagIds);
    }

    public function detachTags(array $tagIds): void
    {
        $this->tags()->detach($tagIds);
    }

    public function syncTags(array $tags): void
    {
        $tagIds = collect($tags)->map(function ($tag) {
            if ($tag instanceof Tag) return $tag->id;
            return Tag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tag)],
                ['name' => $tag]
            )->id;
        })->toArray();
        $this->tags()->sync($tagIds);
    }
}
