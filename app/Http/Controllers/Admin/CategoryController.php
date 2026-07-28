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
        if ($request->boolean('remove_image') && $category->image) {
            $existing = $category->getFirstMedia();
            if ($existing) {
                $category->removeMedia($existing);
            }
            $category->update(['image' => null]);
        }

        if ($request->hasFile('image')) {
            // Remove old main image if exists
            $existing = $category->getFirstMedia();
            if ($existing) {
                $category->removeMedia($existing);
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
        $category->clearMedia();
        $this->categoryService->delete($category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
