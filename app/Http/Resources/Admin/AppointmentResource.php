<?php


namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'doctor' => $this->doctor->name,
            'date' => $this->date,
            'time' => $this->time,
            'status' => $this->status,
        ];
    }
}
