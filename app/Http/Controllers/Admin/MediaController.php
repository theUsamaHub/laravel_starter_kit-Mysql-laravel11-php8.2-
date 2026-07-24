<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(
        private readonly FileUploadService $fileService
    ) {}

    public function index(Request $request): View
    {
        $query = Media::with('createdBy');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('mime_type', 'like', $type . '%');
        }

        $media = $query->latest()->paginate(20);

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array', 'max:10'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,csv,txt', 'max:10240'],
        ]);

        foreach ($request->file('files') as $file) {
            $this->fileService->upload($file, 'uploads/general');
        }

        return back()->with('success', 'Files uploaded successfully.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        $this->fileService->delete($media);

        return back()->with('success', 'File deleted successfully.');
    }
}
