<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DoctorService;
use App\Http\Requests\Admin\StoreDoctorRequest;
use App\Http\Requests\Admin\UpdateDoctorRequest;
use App\Http\Resources\Admin\DoctorResource;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(
        private DoctorService $service
    ) {}

    public function index()
    {
        return api_response(
            'success',
            'Doctors retrieved successfully',
            DoctorResource::collection($this->service->getAll()),
            200
        );
    }

    public function show($id)
    {
        return api_response(
            'success',
            'Doctor retrieved successfully',
            new DoctorResource($this->service->show($id)),
            200
        );
    }

    public function store(StoreDoctorRequest $request)
    {
        $doctor = $this->service->store($request);

        return api_response(
            'success',
            'Doctor created successfully',
            new DoctorResource($doctor),
            201
        );
    }

    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = $this->service->update($request, $id);

        return api_response(
            'success',
            'Doctor updated successfully',
            new DoctorResource($doctor),
            200
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return api_response(
            'success',
            'Doctor deleted successfully',
            null,
            200
        );
    }

    public function bySpeciality($specialityId)
    {
        return api_response(
            'success',
            'Doctors by speciality retrieved successfully',
            DoctorResource::collection($this->service->bySpeciality($specialityId)),
            200
        );
    }

    public function search(Request $request)
    {
        return api_response(
            'success',
            'Doctors search results',
            DoctorResource::collection($this->service->search($request)),
            200
        );
    }
}
