<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Category::query()->with(['createdBy', 'updatedBy']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('sort_order')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function getAll(): Collection
    {
        return Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function getById(int $id): Category
    {
        return Category::with(['createdBy', 'updatedBy'])->findOrFail($id);
    }

    public function create(array $data): Category
    {
        $category = Category::create($data);
        $this->refreshCache();
        return $category;
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        $this->refreshCache();
        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        $result = $category->delete();
        $this->refreshCache();
        return $result;
    }

    public function restore(int $id): Category
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        $this->refreshCache();
        return $category;
    }

    public function forceDelete(int $id): bool
    {
        $category = Category::withTrashed()->findOrFail($id);
        $result = $category->forceDelete();
        $this->refreshCache();
        return $result;
    }

    public function count(): int
    {
        return Cache::remember('categories.count', 3600, fn() => Category::count());
    }

    public function refreshCache(): void
    {
        Cache::forget('categories.count');
        Cache::forget('categories.active');
    }
}
