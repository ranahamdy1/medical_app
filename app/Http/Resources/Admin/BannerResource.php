<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'action'      => $this->action,
            'image'       => $this->image ? asset('storage/' . $this->image) : null,
            'is_active'   => (bool) $this->is_active,
            'created_at'  => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
