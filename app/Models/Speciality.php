<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Speciality extends Model implements HasMedia {

    use InteractsWithMedia;

    public function registerMediaCollections(): void {
        $this->addMediaCollection('speciality_image')->singleFile();
    }

    protected $fillable = ['image', 'title', 'num_of_available_doctor', 'parent_id'];
    public function doctors() { return $this->hasMany(Doctor::class); }
    public function children() { return $this->hasMany(Speciality::class, 'parent_id'); }
    public function parent() { return $this->belongsTo(Speciality::class, 'parent_id'); }
}
