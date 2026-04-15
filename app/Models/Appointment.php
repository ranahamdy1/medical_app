<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'date',
        'time',
        'price',
        'status',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reschedule()
    {
        return $this->hasOne(ReshedualAppointment::class);
    }

    public function payment()
    {
        return $this->hasOne(PaymentTransaction::class);
    }
}
