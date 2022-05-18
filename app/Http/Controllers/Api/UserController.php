<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize(('user-index'));

        $users = User::select('id', 'name', 'email', 'created_at', 'active')->with('roles')->paginate(10);

        return response(['users' => $users], 200);
    }

    public function store(UserStoreRequest $requset)
    {
        $this->authorize('user-store');

        $data = $requset->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $user->roles()->attach($data['roles']);

        return response(['message' => 'User created successfully'], 200);
    }

    public function show(Request $request)
    {
        $user = User::where('id', $request->user)->select('id', 'name', 'email', 'created_at', 'active')->first();

        return response(['user' => $user], 200);
    }

    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update($data);

        return response(['message' => 'User updated successfully'], 200);
    }

    public function destroy(User $user)
    {
        $user->update(['active' => false]);

        return response(['message' => 'User deleted successfully']);
    }
}
