<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationRequest;
use App\Http\Resources\Admin\NotificationResource;
use App\Services\Admin\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $service) {}

    public function store(NotificationRequest $request)
    {
        $data = $request->validated();

        $notification = $this->service->create($data);

        return api_response(
            'success',
            'Notification created successfully',
            new NotificationResource($notification),
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
