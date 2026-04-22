<?php

namespace App\Services\Client;

use App\Http\Resources\Client\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected function sendSms($phone, $message)
    {
        try {
            $response = Http::timeout(10)->post('https://sms-provider.com/api/send', [
                'api_key' => env('SMS_API_KEY'),
                'phone'   => $phone,
                'message' => $message,
                'sender'  => env('SMS_SENDER')
            ]);

            if (!$response->successful()) {
                Log::error('SMS failed', [
                    'phone' => $phone,
                    'response' => $response->body()
                ]);

                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('SMS exception', [
                'message' => $e->getMessage(),
                'phone' => $phone,
            ]);

            return false;
        }
    }

    public function register(array $data)
    {
        $code = random_int(100000, 999999);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role_id' => 2,
            'is_verified' => false,
        ]);

        // Store OTP in cache (10 minutes)
        Cache::put('otp_' . $user->email, $code, now()->addMinutes(10));

        $this->sendSms(
            $user->phone,
            "Your verification code is: $code"
        );

        return [
            'status' => true,
            'message' => 'User registered successfully. Please verify OTP.',
            'data' => [
                'user' => new UserResource($user),
                'otp'  => $code
            ]
        ];
    }

    public function verifyRegister($email, $code)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return [
                'status' => false,
                'message' => 'User not found',
                'code' => 404
            ];
        }

        if ($user->is_verified) {
            return [
                'status' => false,
                'message' => 'Account already verified',
                'code' => 400
            ];
        }

        $cachedCode = Cache::get('otp_' . $email);

        if (!$cachedCode) {
            return [
                'status' => false,
                'message' => 'Code expired',
                'code' => 400
            ];
        }

        if ($cachedCode != $code) {
            return [
                'status' => false,
                'message' => 'Invalid code',
                'code' => 400
            ];
        }

        $user->update([
            'is_verified' => true,
        ]);

        Cache::forget('otp_' . $email);

        $token = JWTAuth::fromUser($user);

        return [
            'status' => true,
            'message' => 'Account verified successfully',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
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

        if (!$user->is_verified) {
            return [
                'status'  => false,
                'message' => 'Please verify your account first',
                'code'    => 403,
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
