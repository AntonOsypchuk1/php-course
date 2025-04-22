<?php

namespace App\Services;

use App\Models\Fine;
use Illuminate\Pagination\LengthAwarePaginator;

class FineService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Fine::with(['loan']);
        if (!empty($filters['loan_id'])) {
            $query->where('loan_id', $filters['loan_id']);
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?Fine
    {
        return Fine::findOrFail($id);
    }

    public function create(array $data): Fine
    {
        return Fine::create($data);
    }

    public function markPaid(int $id): Fine
    {
        $fine = $this->find($id);
        $fine->paid_at = Carbon::now();
        $fine->save();
        return $fine;
    }

    public function delete(int $id): bool
    {
        $fine = $this->find($id);
        return $fine->delete();
    }
}
