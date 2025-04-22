<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    private LoanService $loans;

    public function __construct(LoanService $loans)
    {
        $this->middleware('auth:api');
        $this->loans = $loans;
    }

    public function index(Request $request)
    {
        return $this->respond(
            $this->loans->list($request->only('user_id'), $request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);
        return $this->respond($this->loans->create($data), 201);
    }

    public function show(int $id)
    {
        return $this->respond($this->loans->find($id));
    }

    public function update(Request $request, int $id)
    {
        // Mark as returned
        return $this->respond($this->loans->return($id));
    }

    public function destroy(int $id)
    {
        $this->loans->delete($id);
        return $this->noContent();
    }
}
