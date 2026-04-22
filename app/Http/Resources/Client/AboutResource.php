<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'app_name' => $this->app_name,
            'subtitle' => $this->subtitle,
            'about' => $this->about,
            'year' => $this->year,
            'rights' => $this->rights,
            'note' => $this->note,

            'social' => [
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'youtube' => $this->youtube,
                'twitter' => $this->twitter,
            ],

            'links' => [
                'privacy_policy' => $this->privacy_policy,
                'terms' => $this->terms,
            ],
        ];
    }
}
