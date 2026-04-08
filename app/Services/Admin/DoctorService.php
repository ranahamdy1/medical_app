<?php

namespace App\Services\Admin;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function store($request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role_id'  => 3,
        ]);

        $doctor = Doctor::create([
            'user_id'       => $user->id,
            'speciality_id' => $request->speciality_id,
            'gender'        => $request->gender,
            'price'         => $request->price,
            'duration'      => $request->duration ?? 30,
            'evaluation'    => 0,
            'year_of_exp'   => $request->year_of_exp,
            'is_favourite'  => false,
            'about_doctor'  => $request->about_doctor,
        ]);

        if ($request->hasFile('certificate_image')) {
            $doctor->addMediaFromRequest('certificate_image')
                ->toMediaCollection('certificate');
        }

        return $doctor->load('user', 'speciality');
    }

    public function update($request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $doctor->update($request->only([
            'speciality_id',
            'gender',
            'price',
            'duration',
            'year_of_exp',
            'about_doctor',
            'is_favourite',
        ]));

        if ($doctor->user) {
            $doctor->user->update($request->only([
                'name', 'email', 'phone'
            ]));
        }

        if ($request->hasFile('certificate_image')) {
            $doctor->clearMediaCollection('certificate');
            $doctor->addMediaFromRequest('certificate_image')
                ->toMediaCollection('certificate');
        }

        return $doctor->load('user', 'speciality');
    }

    public function delete($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->user->delete();
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
