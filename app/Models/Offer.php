<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements HasMedia{

    use InteractsWithMedia;

    public function registerMediaCollections(): void {
        $this->addMediaCollection('offer_image')->singleFile();
    }

    protected $fillable =
        ['doctor_id', 'image', 'title', 'description', 'price', 'number', 'duration', 'price_before', 'price_after', 'discount_percentage'];
    public function doctor() { return $this->belongsTo(Doctor::class); }
}
