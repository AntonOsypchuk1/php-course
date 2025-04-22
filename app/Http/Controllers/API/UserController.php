<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private UserService $users;

    public function __construct(UserService $users)
    {
        $this->middleware('auth:api');
        $this->users = $users;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        // User model hashes password via mutator
        $user = User::create($data);

        // Generate JWT
        $token = JWTAuth::fromUser($user);

        return $this->respond([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * POST /api/auth/login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->respond(['error' => 'Invalid credentials'], 401);
        }

        return $this->respond(['token' => $token]);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['email','role_id']);
        return $this->respond(
            $this->users->list($filters, $request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);
        return $this->respond(
            $this->users->create($data),
            201
        );
    }

    public function show(int $id)
    {
        return $this->respond($this->users->find($id));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name'     => 'sometimes|string',
            'email'    => "sometimes|email|unique:users,email,{$id}",
            'password' => 'sometimes|string|min:6',
            'role_id'  => 'sometimes|exists:roles,id',
        ]);
        return $this->respond($this->users->update($id, $data));
    }

    public function destroy(int $id)
    {
        $this->users->delete($id);
        return $this->noContent();
    }
}
