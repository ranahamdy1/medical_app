<?php

namespace App\Services\Client;

use App\Models\Notification;

class NotificationService
{
    public function getAll($userId)
    {
        return Notification::where('user_id', $userId)->latest()->get();
    }

}
