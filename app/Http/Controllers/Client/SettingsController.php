<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateSettingsRequest;
use App\Services\Client\SettingsService;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function update(UpdateSettingsRequest $request)
    {
        $user = auth('client')->user();

        $result = $this->settingsService->update($user, $request->validated());

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }
}
