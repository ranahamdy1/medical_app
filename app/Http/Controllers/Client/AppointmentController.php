<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AppointmentResource;
use App\Services\Admin\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $service) {}

    public function index()
    {
        $appointments = AppointmentResource::collection(
            $this->service->getByUser(auth()->id())
        );

        return api_response(
            'success',
            'Your appointments retrieved successfully',
            $appointments,
            200
        );
    }

    public function store(Request $request)
    {
        $appointment = $this->service->store([
            'user_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,

            'date' => $request->date,
            'time' => $request->time,
        ]);

        return api_response(
            'success',
            'Appointment created successfully',
            new AppointmentResource($appointment),
            201
        );
    }

    public function show($id)
    {
        $appointment = $this->service->findForUser($id, auth()->id());

        return api_response(
            'success',
            'Appointment details retrieved successfully',
            new AppointmentResource($appointment),
            200
        );
    }

    public function update(Request $request, $id)
    {
        $appointment = $this->service->updateForUser(
            $id,
            auth()->id(),
            $request->all()
        );

        return api_response(
            'success',
            'Appointment updated successfully',
            new AppointmentResource($appointment),
            200
        );
    }

    public function destroy($id)
    {
        $this->service->deleteForUser($id, auth()->id());

        return api_response(
            'success',
            'Appointment cancelled successfully',
            null,
            200
        );
    }
}
