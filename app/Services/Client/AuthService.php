<?php

namespace App\Services\Client;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return [
                'status' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'status' => true,
            'data' => [
                'user'  => $user,
                'token' => $token,
            ]
        ];
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();
    }

    public function changePassword($user, array $data)
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            return [
                'status' => false,
                'message' => 'Current password is incorrect',
                'code' => 400
            ];
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return [
            'status' => true,
            'message' => 'Password updated successfully'
        ];
    }
}
