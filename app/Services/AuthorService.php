<?php

namespace App\Services;

use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Author::query();
        if (!empty($filters['name'])) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%'.$filters['name'].'%']);
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?Author
    {
        return Author::findOrFail($id);
    }

    public function create(array $data): Author
    {
        return Author::find($data);
    }

    public function update(int $id, array $data): Author
    {
        $author = $this->find($id);
        $author->update($data);
        return $author;
    }

    public function delete(int $id): bool
    {
        $author = $this->find($id);
        return $author->delete();
    }
}
