<?php

namespace App\Services\Client;

use App\Http\Resources\Client\AboutResource;
use App\Models\AppSetting;

class AboutService
{
    public function get()
    {
        $settings = AppSetting::first();

        return new AboutResource($settings);
    }
}
