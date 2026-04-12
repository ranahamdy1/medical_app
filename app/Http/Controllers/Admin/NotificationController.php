<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $service) {}

    public function store(Request $request)
    {
        $notification = $this->service->create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'notifiable_type' => $request->notifiable_type,
            'notifiable_id' => $request->notifiable_id,
        ]);

        return api_response(
            'success',
            'Notification created successfully',
            $notification,
            201
        );
    }


    public function destroy($id)
    {
        $this->service->delete($id, auth()->id());

        return api_response(
            'success',
            'Notification deleted',
            null,
            200
        );
    }
}
