<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\NotificationService;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $service) {}

    public function index()
    {
        return api_response(
            'success',
            'Notifications fetched successfully',
            $this->service->getAll(auth()->id()),
            200
        );
    }
}
