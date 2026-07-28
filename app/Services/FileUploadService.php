<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Allowed file types organized by category.
     */
    public const FILE_TYPES = [
        'images' => [
            'mime_types' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'],
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
            'max_size' => 5120, // 5MB
        ],
        'documents' => [
            'mime_types' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'text/plain',
            ],
            'extensions' => ['pdf', 'doc', 'docx', 'txt'],
            'max_size' => 10240, // 10MB
        ],
        'spreadsheets' => [
            'mime_types' => [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv',
            ],
            'extensions' => ['xls', 'xlsx', 'csv'],
            'max_size' => 10240, // 10MB
        ],
    ];

    /**
     * Upload a file and create a media record.
     */
    public function upload(
        UploadedFile $file,
        string $directory = 'uploads',
        ?string $disk = null,
        ?int $createdBy = null
    ): Media {
        $disk = $disk ?? 'public';
        $path = $file->store($directory, $disk);

        return Media::create([
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
            'disk' => $disk,
            'created_by' => $createdBy ?? auth()->id(),
        ]);
    }

    /**
     * Upload multiple files.
     */
    public function uploadMultiple(
        array $files,
        string $directory = 'uploads',
        ?string $disk = null
    ): array {
        $media = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $media[] = $this->upload($file, $directory, $disk);
            }
        }
        return $media;
    }

    /**
     * Delete a media file and its record.
     */
    public function delete(Media $media): bool
    {
        Storage::disk($media->disk)->delete($media->path);
        return $media->delete();
    }

    /**
     * Get validation rules for a file type category.
     */
    public static function getValidationRules(string $category = 'images'): array
    {
        $type = self::FILE_TYPES[$category] ?? self::FILE_TYPES['images'];

        return [
            'required',
            'file',
            'mimes:' . implode(',', $type['extensions']),
            'max:' . $type['max_size'],
        ];
    }

    /**
     * Get all allowed extensions.
     */
    public static function getAllowedExtensions(): array
    {
        $extensions = [];
        foreach (self::FILE_TYPES as $category) {
            $extensions = array_merge($extensions, $category['extensions']);
        }
        return array_unique($extensions);
    }

    /**
     * Get file type info from mime type.
     */
    public static function getFileTypeInfo(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }
        return match ($mimeType) {
            'application/pdf' => 'pdf',
            'text/csv',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'spreadsheet',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'document',
            default => 'file',
        };
    }
}
