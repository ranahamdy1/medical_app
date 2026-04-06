<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $credentials)
    {
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return [
                'status' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        // إنشاء token جديد
        $token = $admin->createToken('Admin Token')->plainTextToken;

        return [
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'admin' => $admin,
                'token' => $token
            ]
        ];
    }

    public function logout($admin)
    {
        // حذف التوكن الحالي فقط
        $admin->currentAccessToken()->delete();

        return true;
    }
}
