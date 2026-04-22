<?php

namespace App\Http\Resources\Client;


use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'image' => url('storage/' . $this['image']),
        ];
    }
}
