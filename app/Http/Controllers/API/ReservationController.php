<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private ReservationService $reservations;

    public function __construct(ReservationService $reservations)
    {
        $this->middleware('auth:api');
        $this->reservations = $reservations;
    }

    public function index(Request $request)
    {
        return $this->respond(
            $this->reservations->list($request->only('status'), $request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'status'  => 'nullable|in:pending,fulfilled,cancelled',
        ]);
        return $this->respond($this->reservations->create($data), 201);
    }

    public function show(int $id)
    {
        return $this->respond($this->reservations->find($id));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,fulfilled,cancelled',
        ]);
        return $this->respond($this->reservations->updateStatus($id, $data['status']));
    }

    public function destroy(int $id)
    {
        $this->reservations->delete($id);
        return $this->noContent();
    }
}

