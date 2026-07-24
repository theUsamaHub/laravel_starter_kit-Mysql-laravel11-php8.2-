<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = $this->categoryService->getPaginated(
            $request->only(['search', 'is_active']),
            $request->input('per_page', 15)
        );

        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());

        // Handle main image
        if ($request->hasFile('image')) {
            $media = $category->addMediaFromRequest('image');
            if ($media) {
                $category->update(['image' => $media->path]);
            }
        }

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $category->addMedia($file, 'uploads/categories');
            }
        }

        return (new CategoryResource($category->fresh(['createdBy', 'updatedBy', 'media'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Category $category): CategoryResource
    {
        $category->load(['createdBy', 'updatedBy', 'media']);
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $category = $this->categoryService->update($category, $request->validated());

        // Handle main image
        if ($request->boolean('remove_image') && $category->image) {
            $existing = $category->getFirstMedia();
            if ($existing) {
                $category->removeMedia($existing);
            }
            $category->update(['image' => null]);
        }

        if ($request->hasFile('image')) {
            $existing = $category->getFirstMedia();
            if ($existing) {
                $category->removeMedia($existing);
            }
            $media = $category->addMediaFromRequest('image');
            if ($media) {
                $category->update(['image' => $media->path]);
            }
        }

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $category->addMedia($file, 'uploads/categories');
            }
        }

        return (new CategoryResource($category->fresh(['createdBy', 'updatedBy', 'media'])))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->clearMedia();
        $this->categoryService->delete($category);

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
