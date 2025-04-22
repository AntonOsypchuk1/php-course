<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private BookService $books;

    public function __construct(BookService $books)
    {
        $this->middleware('auth:api');
        $this->books = $books;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['title','category_id']);
        return response()->json(
            $this->books->list($filters, $request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string',
            'isbn'        => 'required|string|unique:books,isbn',
            'publisher'   => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity'    => 'required|integer|min:0',
            'authors'     => 'array',
            'authors.*'   => 'exists:authors,id',
        ]);

        return response()->json($this->books->create($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->books->find($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title'       => 'sometimes|string',
            'isbn'        => "sometimes|string|unique:books,isbn,{$id}",
            'publisher'   => 'nullable|string',
            'category_id' => 'sometimes|exists:categories,id',
            'quantity'    => 'sometimes|integer|min:0',
            'authors'     => 'array',
            'authors.*'   => 'exists:authors,id',
        ]);

        return response()->json($this->books->update($id, $data));
    }

    public function destroy($id)
    {
        $this->books->delete($id);
        return response()->noContent();
    }
}

