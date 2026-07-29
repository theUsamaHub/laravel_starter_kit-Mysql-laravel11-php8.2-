<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly FileUploadService $fileService
    ) {}

    public function index(Request $request): View
    {
        $categories = $this->categoryService->getPaginated(
            $request->only(['search', 'is_active']),
            15
        );

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = collect($request->validated())->except(['image', 'attachments', 'remove_image'])->toArray();
        $category = $this->categoryService->create($data);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $media = $category->addMediaFromRequest('image');
            if ($media) {
                $category->update(['image' => $media->path]);
            }
        }

        // Handle multiple attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $category->addMedia($file);
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->load(['createdBy', 'updatedBy', 'media']);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        $category->load('media');
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = collect($request->validated())->except(['image', 'attachments', 'remove_image'])->toArray();
        $this->categoryService->update($category, $data);

        // Handle main image update
        $existingMedia = $category->getFirstMedia();

        if ($request->boolean('remove_image') && $category->image) {
            if ($existingMedia) {
                $category->removeMedia($existingMedia);
            }
            $category->update(['image' => null]);
            $existingMedia = null;
        }

        if ($request->hasFile('image')) {
            if ($existingMedia) {
                $category->removeMedia($existingMedia);
            }
            $media = $category->addMediaFromRequest('image');
            if ($media) {
                $category->update(['image' => $media->path]);
            }
        }

        // Handle additional attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $category->addMedia($file);
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->delete($category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category moved to trash.');
    }

    public function trashed(): View
    {
        $categories = Category::onlyTrashed()
            ->with(['createdBy', 'updatedBy'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('admin.categories.trashed', compact('categories'));
    }

    public function restore(int $id): RedirectResponse
    {
        $this->categoryService->restore($id);

        return redirect()->route('admin.categories.trashed')
            ->with('success', 'Category restored successfully.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->clearMedia();
        $this->categoryService->forceDelete($id);

        return redirect()->route('admin.categories.trashed')
            ->with('success', 'Category permanently deleted.');
    }
}
