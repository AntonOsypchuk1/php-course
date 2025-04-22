<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    private AuthorService $authors;

    public function __construct(AuthorService $authors)
    {
        $this->middleware('auth:api');
        $this->authors = $authors;
    }

    public function index(Request $request)
    {
        return $this->respond(
            $this->authors->list($request->only('name'), $request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'bio'        => 'nullable|string',
        ]);
        return $this->respond($this->authors->create($data), 201);
    }

    public function show(int $id)
    {
        return $this->respond($this->authors->find($id));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'first_name' => 'sometimes|string',
            'last_name'  => 'sometimes|string',
            'bio'        => 'nullable|string',
        ]);
        return $this->respond($this->authors->update($id, $data));
    }

    public function destroy(int $id)
    {
        $this->authors->delete($id);
        return $this->noContent();
    }
}
