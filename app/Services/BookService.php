<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Book::with(['authors', 'category']);
        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%'.$filters['title'].'%');
        }
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?Book
    {
        return Book::with(['authors', 'category'])->findOrFail($id);
    }

    public function create(array $data): Book
    {
        $book = Book::create($data);
        if (!empty($data['authors'])) {
            $book->authors()->sync($data['authors']);
        }
        return $book;
    }

    public function update(int $id, array $data): Book
    {
        $book = $this->find($id);
        $book->update($data);
        if (array_key_exists('authors', $data)) {
            $book->authors()->sync($data['authors']);
        }
        return $book;
    }

    public function delete(int $id): bool
    {
        $book = $this->find($id);
        return $book->delete();
    }
}
