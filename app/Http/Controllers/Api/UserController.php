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
        $this->authorize('user-index');

        $limit = request('limit') ? request('limit') : 10;

        $users = User::select('id', 'name', 'email', 'created_at', 'active', 'checkRole')
                     ->with('roles')
                     ->paginate($limit)
        ;

        return response(['users' => $users], 200);
    }

    public function store(UserStoreRequest $request)
    {
        $this->authorize('user-store');

        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['role_id']  = $data['roles'][0]['role_id'];

        $user = User::create($data);

        $user->roles()
             ->attach($data['roles'])
        ;

        if ($data['roles'][0]['role_id'] == 1) {
            $user->checkRole = true;
            $user->save();
        }

        return response(['message' => 'User created successfully'], 200);
    }

    public function show(Request $request)
    {
        $this->authorize('user-show');

        $user = User::where('id', $request->user)
                    ->select('id', 'name', 'email', 'created_at', 'active', 'checkRole')
                    ->first()
        ;

        return response(['user' => $user], 200);
    }

    public function destroy(User $user)
    {
        $this->authorize('user-destroy');

        if ($user->id == 1) {
            return response(['message' => 'You can not delete this user'], 200);
        }

        $user->update(['active' => false]);

        return response(['message' => 'User deleted successfully']);
    }

    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('user-update');

        if ($user->id != 1) {

            $data = $request->validated();

            $user->update($data);

            $user->roles()
                 ->detach()
            ;
            $user->roles()
                 ->attach($data['roles'])
            ;
        } else {
            return response(['message' => 'You can not update this user']);
        }

        return response(['message' => 'User updated successfully'], 200);
    }
}
