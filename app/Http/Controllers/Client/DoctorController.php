<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DoctorResource;
use App\Services\Client\DoctorService;
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
