<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->user->name,
            'email'         => $this->user->email,
            'phone'         => $this->user->phone,
            'gender'        => $this->gender,
            'price'         => $this->price,
            'year_of_exp'   => $this->year_of_exp,
            'about_doctor'  => $this->about_doctor,
            'is_favourite'  => $this->is_favourite,

            'speciality'    => $this->whenLoaded('speciality'),
            'ratings'       => $this->whenLoaded('ratings'),
            'offers'        => $this->whenLoaded('offers'),
            'doctor_times'  => $this->whenLoaded('doctorTimes'),
            'appointments'  => $this->whenLoaded('appointments'),

            'certificate_url' => $this->getFirstMediaUrl('certificate'),
        ];
    }
}
