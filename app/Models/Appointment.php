<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function reshedual() { return $this->hasOne(ReshedualAppointment::class); }
    public function payment() { return $this->hasOne(PaymentTransaction::class); }
}
