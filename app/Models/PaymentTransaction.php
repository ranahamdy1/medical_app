<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model {
    protected $fillable =
        ['user_id', 'price', 'payment_method', 'statues', 'payment_details', 'appointment_id'];
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function user() { return $this->belongsTo(User::class); }
}
