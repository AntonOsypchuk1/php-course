<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Pagination\LengthAwarePaginator;

class ReservationService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Reservation::with(['user', 'book']);
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?Reservation
    {
        return Reservation::findOrFail($id);
    }

    public function create(array $data): Reservation
    {
        return Reservation::create($data);
    }

    public function updateStatus(int $id, string $status): Reservation
    {
        $reservation = $this->find($id);
        $reservation->status = $status;
        $reservation->save();
        return $reservation;
    }

    public function delete(int $id): bool
    {
        $reservation = $this->find($id);
        return $reservation->delete();
    }
}
