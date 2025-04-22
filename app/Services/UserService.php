<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = User::with('role');
        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%'.$filters['email'].'%');
        }
        if (!empty($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?User
    {
        return User::with('role')->findOrFail($id);
    }

    public function create(array $data): User
    {
        // assume password is hashed by mutator
        return User::create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
