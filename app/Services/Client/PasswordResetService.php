<?php

namespace App\Services\Client;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

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

        $token = rand(100000, 999999); // OTP 6 digits (أفضل من 5)

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
            'message' => 'Reset code sent successfully.',
        ];
    }

    public function verifyToken(string $token): array
    {
        $reset = DB::table('password_resets')->where('token', $token)->first();

        if (!$reset) {
            return [
                'status'  => false,
                'message' => 'Invalid or expired code.',
                'code'    => 400,
            ];
        }

        return [
            'status' => true,
            'data'   => [
                'email' => $reset->email,
            ],
        ];
    }

    public function reset(array $data): array
    {
        $reset = DB::table('password_resets')->where('token', $data['token'])->first();
        if (!$reset) {
            return [
                'status'  => false,
                'message' => 'Invalid or expired code.',
                'code'    => 400,
            ];
        }
        $user = User::where('email', $reset->email)->first();
        if (!$user) {
            return [
                'status'  => false,
                'message' => 'User not found.',
                'code'    => 404,
            ];
        }
        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        // delete used token
        DB::table('password_resets')->where('email', $reset->email)->delete();

        return [
            'status'  => true,
            'message' => 'Password reset successfully.',
        ];
    }
}
