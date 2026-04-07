<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    public function doctors() { return $this->hasMany(Doctor::class); }
    public function children() { return $this->hasMany(Speciality::class, 'parent_id'); }
    public function parent() { return $this->belongsTo(Speciality::class, 'parent_id'); }
}
