<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $fillable =
        ['user_id', 'image', 'title', 'description', 'notification_date', 'notification_time', 'notifiable_type', 'notifiable_id'];
    public function user() { return $this->belongsTo(User::class); }
}
