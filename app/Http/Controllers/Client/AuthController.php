<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ChangePasswordRequest;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Requests\Client\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return api_response(
            'success',
            'User registered successfully',
            [
                'user'  => $user,
                'token' => $token,
            ],
            201
        );
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return api_response('fail', 'Invalid credentials', null, 401);
        }

        $user = Auth::user();

        $token = $user->createToken('API Token')->plainTextToken;

        return api_response(
            'success',
            'Login successful',
            [
                'user'  => $user,
                'token' => $token,
            ]
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return api_response(
            'success',
            'Logged out successfully'
        );
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return api_response('fail', 'Current password is incorrect', null, 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return api_response(
            'success',
            'Password updated successfully'
        );
    }

}
