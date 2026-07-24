<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasMedia
{
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function addMedia(UploadedFile $file, ?string $disk = null): Media
    {
        $disk = $disk ?? config('filesystems.default', 'public');
        $path = $file->store('uploads/' . class_basename($this) . '/' . strtolower($this->getTable()), $disk);

        return $this->media()->create([
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
            'disk' => $disk,
            'created_by' => auth()->id(),
        ]);
    }

    public function addMediaFromRequest(string $fieldName, ?string $disk = null): ?Media
    {
        if (!request()->hasFile($fieldName)) {
            return null;
        }

        return $this->addMedia(request()->file($fieldName), $disk);
    }

    public function addMultipleMedia(array $fieldNames, ?string $disk = null): array
    {
        $media = [];
        foreach ($fieldNames as $fieldName) {
            $result = $this->addMediaFromRequest($fieldName, $disk);
            if ($result) {
                $media[] = $result;
            }
        }
        return $media;
    }

    public function getFirstMedia(string $type = null): ?Media
    {
        $query = $this->media();
        if ($type) {
            $query->where('mime_type', 'like', $type . '%');
        }
        return $query->latest()->first();
    }

    public function getMediaByType(string $mimeType): \Illuminate\Database\Eloquent\Collection
    {
        return $this->media()->where('mime_type', 'like', $mimeType . '%')->get();
    }

    public function getImages(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->media()->where('mime_type', 'like', 'image/%')->get();
    }

    public function getFiles(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->media()->where('mime_type', 'not like', 'image/%')->get();
    }

    public function clearMedia(): bool
    {
        foreach ($this->media as $item) {
            Storage::disk($item->disk)->delete($item->path);
        }
        return $this->media()->delete();
    }

    public function removeMedia(Media $media): bool
    {
        Storage::disk($media->disk)->delete($media->path);
        return $media->delete();
    }
}
