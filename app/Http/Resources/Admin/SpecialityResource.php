<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_url' => $this->getFirstMediaUrl('speciality_image'),
            'num_of_available_doctor' => $this->num_of_available_doctor,
            'parent_id' => $this->parent_id,
            'children' => SpecialityResource::collection($this->whenLoaded('children')),
        ];
    }
}
