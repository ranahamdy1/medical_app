<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ChangePasswordRequest;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Requests\Client\RegisterRequest;
use App\Services\Client\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register($request->validated());

        return api_response(
            'success',
            'User registered successfully',
            $data,
            201
        );
    }

    public function verifyRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required'
        ]);

        $result = $this->authService->verifyRegister($request->email, $request->code);

        if (!$result['status']) {
            return api_response(
                'fail',
                $result['message'],
                null,
                $result['code']
            );
        }

        return api_response(
            'success',
            'Account verified successfully',
            $result['data'],
            200
        );
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (!$result['status']) {
            return api_response(
                'fail',
                $result['message'],
                null,
                $result['code']
            );
        }

        return api_response(
            'success',
            'Login successful',
            [
                'user'  => $result['data']['user'],
                'token' => $result['data']['token']
            ]
        );
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->bearerToken());

        return api_response(
            'success',
            'Logged out successfully'
        );
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth('client')->user();

        $result = $this->authService->changePassword(
            $user,
            $request->validated()
        );

        if (!$result['status']) {
            return api_response(
                'fail',
                $result['message'],
                null,
                $result['code']
            );
        }

        return api_response(
            'success',
            $result['message']
        );
    }
}
