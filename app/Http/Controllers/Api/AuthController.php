<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        if (Auth::attempt($loginRequest->all())) {
            $user = User
                ::where('active', true)
                ->where('id', request()->user()->id)
                ->first()
            ;
            if (!$user) {
                return response(['message' => 'Your account deleted'], 200);
            }

            return response(['menu' => $user->menuName(), 'token' => $user->createToken('Token')->plainTextToken]);
        }

        return response(['message' => 'The provided credentials are incorrect.'], 422);
    }

    public function logout()
    {
        auth('sanctum')
            ->user()
            ->tokens()
            ->delete()
        ;

        return response(['message' => 'Tokens Revoked'], 200);
    }

    public function chechAuth()
    {
        if (auth('sanctum')->user()) {
            return response(['message' => 'Auth true'], 200);
        }

        return response(['message' => 'Auth false'], 401);
    }

    public function authPermissions()
    {
        $permissions = auth('sanctum')
            ->user()
            ->permissions()
        ;

        return response(['permissions' => $permissions], 200);
    }

    public function profile()
    {
        $user = User
            ::where('id', auth('sanctum')->id())
            ->select('id', 'name', 'email')
            ->first()
        ;

        return response(['user' => $user], 200);
    }

    public function checkPassword(Request $request)
    {
        if (Hash::check($request->password, auth('sanctum')->user()->password)) {
            return response(['message' => 'Password is correct'], 200);
        }

        return response(['message' => 'The provided credentials are incorrect.'], 422);
    }

    // Update passowrd
    public function updatePassword(Request $request)
    {
        $request->validate([
                               'password'      => ['required'],
                               'new_password'  => ['required'],
                               'conf_password' => ['required', 'same:new_password'],
                           ]);

        if (Hash::check($request->password, auth('sanctum')->user()->password)) {

            auth('sanctum')
                ->user()
                ->update([
                             'password' => Hash::make($request->new_password),
                         ])
            ;

            return response(['message' => 'Password updated successfully'], 200);
        }

        return response(['message' => 'The provided credentials are incorrect.'], 422);
    }

    public function update(Request $request)
    {
        $request->validate([
                               'name'     => ['required'],
                               'email'    => ['required', Rule::unique('users', 'email')
                                                              ->ignore(auth('sanctum')->id())],
                               'password' => ['required'],
                           ]);

        auth('sanctum')
            ->user()
            ->update([
                         'name'  => $request->name,
                         'email' => $request->email,
                     ])
        ;

        return response(['message' => 'Profile updated successfully'], 200);
    }
}
