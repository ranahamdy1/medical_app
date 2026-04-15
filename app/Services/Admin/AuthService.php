<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login(array $credentials)
    {
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return [
                'status' => false,
                'message' => 'Invalid credentials',
                'code' => 401,
            ];
        }

        $token = JWTAuth::fromUser($admin);

        return [
            'status'  => true,
            'message' => 'Login successful',
            'data'    => [
                'admin' => new AdminResource($admin),
                'token' => $token,
            ],
        ];
    }

    public function logout($token)
    {
        try {
            JWTAuth::setToken($token)->invalidate();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
