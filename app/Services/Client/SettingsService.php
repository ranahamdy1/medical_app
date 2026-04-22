<?php

namespace App\Services\Client;

use App\Http\Resources\Client\UserResource;

class SettingsService
{
    public function update($user, array $data)
    {
        $user->update($data);

        return [
            'status'  => true,
            'message' => 'Settings updated successfully',
            'data'    => new UserResource($user)
        ];
    }
}
