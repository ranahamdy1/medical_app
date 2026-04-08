<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                   => $this->id,
            'title'                => $this->title,
            'price'                => $this->price,
            'discount_percentage'  => $this->discount_percentage,
            'image_url'            => $this->getFirstMediaUrl('offer_image'),
            'doctor'               => $this->whenLoaded('doctor'),
        ];
    }
}
