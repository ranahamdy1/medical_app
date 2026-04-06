<?php

namespace App\Services\Client;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetService
{
    public function sendResetLink(string $email): array
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return [
                'status'  => false,
                'message' => 'User not found.',
                'code'    => 404,
            ];
        }

        $token = rand(10000, 99999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'email'      => $user->email,
                'token'      => $token,
                'created_at' => now(),
            ]
        );

        Mail::raw("Your password reset code is: {$token}", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Password Reset Code');
        });

        return [
            'status'  => true,
            'message' => 'Password reset code sent successfully.',
        ];
    }

    public function verifyToken(string $token): array
    {
        $passwordReset = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            return [
                'status'  => false,
                'message' => 'Invalid or expired token.',
                'code'    => 400,
            ];
        }

        return [
            'status' => true,
            'data'   => [
                'email' => $passwordReset->email,
            ],
        ];
    }

    public function reset(array $data): array
    {
        $passwordReset = DB::table('password_resets')
            ->where('token', $data['token'])
            ->first();

        if (!$passwordReset) {
            return [
                'status'  => false,
                'message' => 'Invalid or expired code.',
                'code'    => 400,
            ];
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return [
                'status'  => false,
                'message' => 'User not found.',
                'code'    => 404,
            ];
        }

        $user->forceFill([
            'password' => Hash::make($data['password']),
        ])->setRememberToken(Str::random(60));

        $user->save();

        DB::table('password_resets')
            ->where('email', $passwordReset->email)
            ->delete();

        return [
            'status'  => true,
            'message' => 'Password reset successfully.',
        ];
    }
}
