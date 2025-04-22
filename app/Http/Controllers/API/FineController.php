<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\FineService;
use Illuminate\Http\Request;

class FineController extends Controller
{
    private FineService $fines;

    public function __construct(FineService $fines)
    {
        $this->middleware('auth:api');
        $this->fines = $fines;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['loan_id']);
        return $this->respond(
            $this->fines->list($filters, $request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount'  => 'required|numeric|min:0',
        ]);
        return $this->respond(
            $this->fines->create($data),
            201
        );
    }

    public function show(int $id)
    {
        return $this->respond(
            $this->fines->find($id)
        );
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'mark_paid' => 'sometimes|boolean',
        ]);

        if (!empty($data['mark_paid'])) {
            $fine = $this->fines->markPaid($id);
            return $this->respond($fine);
        }

        // No other updates supported
        return $this->respond($this->fines->find($id));
    }

    public function destroy(int $id)
    {
        $this->fines->delete($id);
        return $this->noContent();
    }
}
