<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
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
            $result['message'],
            [
                'admin' => $result['data']['admin'],
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
}
