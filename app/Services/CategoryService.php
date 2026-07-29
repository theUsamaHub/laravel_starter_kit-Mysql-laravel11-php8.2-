<?php

namespace App\Services;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
        if (!empty($data['published_at']) && Carbon::parse($data['published_at'])->isFuture()) {
            $data['is_active'] = false;
        }

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        if (!empty($data['published_at']) && Carbon::parse($data['published_at'])->isFuture()) {
            $data['is_active'] = false;
        }

        $category->update($data);
        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function restore(int $id): Category
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return $category;
    }

    public function forceDelete(int $id): bool
    {
        $category = Category::withTrashed()->findOrFail($id);
        return $category->forceDelete();
    }

    public function count(): int
    {
        return Category::count();
    }
}
