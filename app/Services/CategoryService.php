<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Category::query();
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?Category
    {
        return Category::findOrFail($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): Category
    {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id): bool
    {
        $category = $this->find($id);
        return $category->delete();
    }
}
