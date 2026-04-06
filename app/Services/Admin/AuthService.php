<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials)
    {
        if (!Auth::guard('admin')->attempt($credentials)) {
            return [
                'status' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        return [
            'status' => true,
            'message' => 'Login successful',
            'data' => Auth::guard('admin')->user()
        ];
    }

    public function me()
    {
        return Auth::guard('admin')->user();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return true;
    }
}
