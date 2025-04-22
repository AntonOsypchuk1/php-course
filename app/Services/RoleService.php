<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService
{
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return Role::paginate($perPage);
    }

    public function find(int $id): ?Role
    {
        return Role::findOrFail($id);
    }

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(int $id, array $data): Role
    {
        $role = $this->find($id);
        $role->update($data);
        return $role;
    }

    public function delete(int $id): bool
    {
        $role = $this->find($id);
        return $role->delete();
    }
}
