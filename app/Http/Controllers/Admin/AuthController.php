<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::guard('admin')->attempt($credentials)) {
            return api_response(
                'fail',
                'Invalid credentials',
                null,
                401
            );
        }

        return api_response(
            'success',
            'Login successful',
            Auth::guard('admin')->user()
        );
    }

    public function me()
    {
        return api_response(
            'success',
            'Admin profile',
            Auth::guard('admin')->user()
        );
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return api_response(
            'success',
            'Logged out successfully'
        );
    }
}
