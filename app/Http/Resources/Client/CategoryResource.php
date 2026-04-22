<?php


namespace App\Http\Resources\Client;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'icon' => $this['icon'],
        ];
    }
}
