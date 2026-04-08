<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model {
    protected $fillable =
        ['doctor_id', 'image', 'title', 'description', 'price', 'number', 'duration', 'price_before', 'price_after', 'discount_percentage'];
    public function doctor() { return $this->belongsTo(Doctor::class); }
}
