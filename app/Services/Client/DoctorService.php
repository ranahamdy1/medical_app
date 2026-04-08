<?php

namespace App\Services\Client;

use App\Models\Doctor;

class DoctorService
{
    public function getAll()
    {
        return Doctor::with(['user', 'speciality', 'ratings', 'offers'])->get();
    }

    public function show($id)
    {
        return Doctor::with([
            'user',
            'speciality',
            'ratings',
            'offers',
            'doctorTimes',
            'appointments'
        ])->findOrFail($id);
    }

    public function bySpeciality($specialityId)
    {
        return Doctor::with(['user', 'ratings'])
            ->where('speciality_id', $specialityId)
            ->get();
    }

    public function search($request)
    {
        return Doctor::with(['user', 'speciality'])
            ->when($request->name, function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', "%{$request->name}%");
                });
            })
            ->when($request->speciality_id, function ($q) use ($request) {
                $q->where('speciality_id', $request->speciality_id);
            })
            ->get();
    }
}
