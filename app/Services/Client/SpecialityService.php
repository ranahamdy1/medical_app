<?php

namespace App\Services\Client;

use App\Models\Speciality;

class SpecialityService
{
    public function getAll()
    {
        return Speciality::with('children')->get()->map(function ($s) {
            $s->image_url = $s->getFirstMediaUrl('speciality_image');
            return $s;
        });
    }


    public function show($id)
    {
        return Speciality::with(['doctors', 'children'])->findOrFail($id);
    }

}
