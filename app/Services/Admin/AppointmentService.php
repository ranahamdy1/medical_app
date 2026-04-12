<?php

namespace App\Services\Admin;

use App\Models\Appointment;

class AppointmentService
{
    public function getAll()
    {
        return Appointment::all();
    }

    public function getByUser($userId)
    {
        return Appointment::where('user_id', $userId)->get();
    }

    public function find($id)
    {
        return Appointment::findOrFail($id);
    }

    public function findForUser($id, $userId)
    {
        return Appointment::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function store($data)
    {
        return Appointment::create($data);
    }

    public function updateForUser($id, $userId, $data)
    {
        $appointment = $this->findForUser($id, $userId);
        $appointment->update($data);

        return $appointment;
    }

    public function deleteForUser($id, $userId)
    {
        return Appointment::where('id', $id)
            ->where('user_id', $userId)
            ->delete();
    }

    public function delete($id)
    {
        return Appointment::destroy($id);
    }
}
