<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        if(Auth::attempt($loginRequest->all())){
            $user = User
                        ::where('active', true)
                        ->where('id', request()->user()->id)
                        ->first();

            return response(['menu' => $user->menuName(), 'token' => $user->createToken('Token')->plainTextToken]);
        }

        return response(['message' => 'The provided credentials are incorrect.'], 422);
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

		return response(['message' => 'Tokens Revoked'], 200);
    }

    public function chechAuth()
    {
        if(auth('sanctum')->user()){
            return response(['message' => 'Auth true'], 200);
        }

        return response(['message' => 'Auth false'], 401);
    }

    public function authPermissions()
    {
        $permissions = auth('sanctum')->user()->permissions();

        return response(['permissions' => $permissions], 200);
    }

    public function profile()
    {
        $user = User
                    ::where('id', auth('sanctum')->id())
                    ->select('id', 'name', 'email')
                    ->first();

        return response(['user' => $user], 200);
    }

    public function checkPassword(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if(Hash::check($request->password, auth('sanctum')->user()->password)){
            return response(['message' => 'Correct password'], 200);
        }

        return response(['message' => 'The provided credentials are incorrect.'], 422);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', Rule::unique('users', 'email')->ignore(auth('sanctum')->id())],
            'password' => ['nullable'],
        ]);

        if($request->password){
            auth('sanctum')->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }
        auth('sanctum')->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response(['message' => 'Profile updated successfully'], 200);
    }
}
