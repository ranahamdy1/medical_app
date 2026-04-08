<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Doctor extends Model implements HasMedia {
    use InteractsWithMedia;

    public function user() { return $this->belongsTo(User::class); }
    public function speciality() { return $this->belongsTo(Speciality::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function doctorTimes() { return $this->hasMany(DoctorTime::class); }
    public function offers() { return $this->hasMany(Offer::class); }
    public function ratings() { return $this->hasMany(Rating::class); }
}
