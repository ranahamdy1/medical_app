<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {
    protected $fillable = ['user_id', 'doctor_id', 'number', 'comment', 'date'];
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function user() { return $this->belongsTo(User::class); }
}
