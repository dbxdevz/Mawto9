<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
