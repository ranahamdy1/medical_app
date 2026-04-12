<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'notifiable_type',
        'notifiable_id',
        'read_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
