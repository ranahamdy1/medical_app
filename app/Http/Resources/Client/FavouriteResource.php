<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'doctor' => [
                'id' => $this->doctor->id ?? null,
                'name' => $this->doctor->name ?? null,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
