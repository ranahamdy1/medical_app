<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ResetPasswordRequest;
use App\Http\Requests\Client\SendResetLinkRequest;
use App\Services\Client\PasswordResetService;

class PasswordResetController extends Controller
{
    protected $service;

    public function __construct(PasswordResetService $service)
    {
        $this->service = $service;
    }

    public function sendResetLink(SendResetLinkRequest $request)
    {
        $result = $this->service->sendResetLink($request->email);

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }

    public function verifyToken(ResetPasswordRequest $request)
    {
        $result = $this->service->verifyToken($request->token);

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'] ?? 'Token verification',
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }

    public function reset(ResetPasswordRequest $request)
    {
        $result = $this->service->reset($request->only(['token', 'password']));

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }
}
