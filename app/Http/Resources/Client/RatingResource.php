<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => $this->doctor->name ?? null,
            'rate' => $this->rate,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
        ];
    }
}
