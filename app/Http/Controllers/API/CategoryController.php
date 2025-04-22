<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categories;

    public function __construct(CategoryService $categories)
    {
        $this->middleware('auth:api');
        $this->categories = $categories;
    }

    public function index(Request $request)
    {
        return $this->respond(
            $this->categories->list($request->only('name'), $request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|unique:categories,name',
            'description' => 'nullable|string',
        ]);
        return $this->respond($this->categories->create($data), 201);
    }

    public function show(int $id)
    {
        return $this->respond($this->categories->find($id));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name'        => "sometimes|string|unique:categories,name,{$id}",
            'description' => 'nullable|string',
        ]);
        return $this->respond($this->categories->update($id, $data));
    }

    public function destroy(int $id)
    {
        $this->categories->delete($id);
        return $this->noContent();
    }
}
