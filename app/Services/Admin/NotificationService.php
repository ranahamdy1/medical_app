<?php

namespace App\Services\Admin;

use App\Models\Notification;

class NotificationService
{
    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function delete($id, $userId)
    {
        return Notification::where('id', $id)
            ->where('user_id', $userId)
            ->delete();
    }
}
