<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ResetPasswordRequest;
use App\Http\Requests\Client\SendResetLinkRequest;
use App\Services\Client\PasswordResetService;
use Illuminate\Http\Request;

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

        if (!$result['status']) {
            return api_response('fail', $result['message'], null, $result['code']);
        }

        return api_response('success', $result['message']);
    }

    public function verifyToken(Request $request)
    {
        $request->validate(['token' => 'required']);

        $result = $this->service->verifyToken($request->token);

        if (!$result['status']) {
            return api_response('fail', $result['message'], null, $result['code']);
        }

        return api_response(
            'success',
            'Token is valid.',
            $result['data']
        );
    }

    public function reset(ResetPasswordRequest $request)
    {
        $result = $this->service->reset($request->validated());

        if (!$result['status']) {
            return api_response('fail', $result['message'], null, $result['code']);
        }

        return api_response('success', $result['message']);
    }
}
