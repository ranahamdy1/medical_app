<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateProfileRequest;
use App\Http\Requests\Client\ChangeEmailRequest;
use App\Http\Requests\Client\ChangePhoneRequest;
use App\Services\Client\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $user = auth('client')->user();

        return api_response(
            'success',
            'Profile fetched successfully',
            $this->profileService->show($user)
        );
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth('client')->user();

        $result = $this->profileService->update($user, $request->validated());

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }

    public function changeEmail(ChangeEmailRequest $request)
    {
        $user = auth('client')->user();

        $result = $this->profileService->changeEmail($user, $request->email);

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }

    public function changePhone(ChangePhoneRequest $request)
    {
        $user = auth('client')->user();

        $result = $this->profileService->changePhone($user, $request->phone);

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }
}
