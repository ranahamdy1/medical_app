<?php

namespace App\Services\Client;

use App\Http\Resources\Client\UserResource;
use App\Models\User;

class ProfileService
{
    public function show($user)
    {
        return new UserResource($user);
    }

    public function update($user, array $data)
    {
        $user->update($data);

        return [
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => new UserResource($user)
        ];
    }

    public function changeEmail($user, $email)
    {
        if (User::where('email', $email)->exists()) {
            return [
                'status' => false,
                'message' => 'Email already used',
                'code' => 400
            ];
        }

        $user->update([
            'email' => $email,
            'is_verified' => false // مهم لو الإيميل اتغير
        ]);

        return [
            'status' => true,
            'message' => 'Email updated successfully'
        ];
    }

    public function changePhone($user, $phone)
    {
        $user->update([
            'phone' => $phone
        ]);

        return [
            'status' => true,
            'message' => 'Phone updated successfully'
        ];
    }
}
