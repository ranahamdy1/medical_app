<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTime extends Model {
    protected $fillable = ['doctor_id', 'start_time', 'end_time', 'day'];
    public function doctor() { return $this->belongsTo(Doctor::class); }
}
