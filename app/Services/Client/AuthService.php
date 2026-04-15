<?php

namespace App\Services\Client;

use App\Http\Resources\Client\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'  => 2,
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'user'  => new UserResource($user),
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return [
                'status'  => false,
                'message' => 'Invalid credentials',
                'code'    => 401,
            ];
        }

        $token = JWTAuth::fromUser($user);

        return [
            'status' => true,
            'data'   => [
                'user'  => new UserResource($user),
                'token' => $token,
            ],
        ];
    }

    public function logout($token)
    {
        JWTAuth::setToken($token)->invalidate();
    }

    public function changePassword($user, array $data)
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            return [
                'status'  => false,
                'message' => 'Current password is incorrect',
                'code'    => 400,
            ];
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return [
            'status'  => true,
            'message' => 'Password updated successfully',
        ];
    }
}
