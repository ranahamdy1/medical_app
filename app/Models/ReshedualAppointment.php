<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReshedualAppointment extends Model {
    protected $fillable =
        ['appointment_id', 'appointment_date', 'appointment_time', 'doctor_time_id'];
    public function appointment() { return $this->belongsTo(Appointment::class); }
}
