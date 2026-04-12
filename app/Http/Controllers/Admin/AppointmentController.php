<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AppointmentResource;
use App\Services\Admin\AppointmentService;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $service) {}

    public function index()
    {
        $appointments = AppointmentResource::collection(
            $this->service->getAll()
        );

        return api_response(
            'success',
            'Appointments retrieved successfully',
            $appointments,
            200
        );
    }

    public function show($id)
    {
        $appointment = new AppointmentResource(
            $this->service->find($id)
        );

        return api_response(
            'success',
            'Appointment details retrieved successfully',
            $appointment,
            200
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return api_response(
            'success',
            'Appointment deleted successfully',
            null,
            200
        );
    }
}
