<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleService $roles;

    public function __construct(RoleService $roles)
    {
        $this->middleware('auth:api');
        $this->roles = $roles;
    }

    public function index(Request $request)
    {
        return $this->respond(
            $this->roles->list($request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
        return $this->respond(
            $this->roles->create($data),
            201
        );
    }

    public function show(int $id)
    {
        return $this->respond($this->roles->find($id));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => "required|string|unique:roles,name,{$id}",
        ]);
        return $this->respond($this->roles->update($id, $data));
    }

    public function destroy(int $id)
    {
        $this->roles->delete($id);
        return $this->noContent();
    }
}
