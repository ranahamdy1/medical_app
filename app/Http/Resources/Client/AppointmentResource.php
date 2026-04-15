<?php


namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'doctor_id' => $this->doctor_id,

            'doctor_name' => $this->doctor->name ?? null,

            'date' => $this->date,
            'time' => $this->time,

            'price' => $this->price,

            'status' => $this->status ?? null,

            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
