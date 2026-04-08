<?php

namespace App\Services\Admin;

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

    public function store($request)
    {
        $speciality = Speciality::create([
            'title' => $request->title,
            'num_of_available_doctor' => $request->num_of_available_doctor ?? 0,
            'parent_id' => $request->parent_id,
        ]);

        if ($request->hasFile('image')) {
            $speciality->addMediaFromRequest('image')
                ->toMediaCollection('speciality_image');
        }

        return $speciality;
    }

    public function show($id)
    {
        return Speciality::with(['doctors', 'children'])->findOrFail($id);
    }

    public function update($request, $id)
    {
        $speciality = Speciality::findOrFail($id);

        $speciality->update($request->except('image'));

        if ($request->hasFile('image')) {
            $speciality->clearMediaCollection('speciality_image');
            $speciality->addMediaFromRequest('image')
                ->toMediaCollection('speciality_image');
        }

        return $speciality;
    }

    public function delete($id)
    {
        Speciality::findOrFail($id)->delete();
    }
}
