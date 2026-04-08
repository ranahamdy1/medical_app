<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {
    protected $fillable = ['user_id', 'doctor_id', 'text'];
    public function user() { return $this->belongsTo(User::class); }
}
