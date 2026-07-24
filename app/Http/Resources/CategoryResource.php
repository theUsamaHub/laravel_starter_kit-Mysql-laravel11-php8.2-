<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'created_by' => $this->createdBy?->name,
            'updated_by' => $this->updatedBy?->name,
            'media' => $this->whenLoaded('media', function () {
                return $this->media->map(fn ($item) => [
                    'id' => $item->id,
                    'name' => $item->original_name,
                    'mime_type' => $item->mime_type,
                    'size' => $item->size,
                    'size_formatted' => $item->size_formatted,
                    'url' => $item->url,
                    'is_image' => $item->isImage(),
                ]);
            }),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
