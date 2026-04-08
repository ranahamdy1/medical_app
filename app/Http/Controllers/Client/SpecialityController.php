<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SpecialityResource;
use App\Services\Client\SpecialityService;

class SpecialityController extends Controller
{
    protected $service;

    public function __construct(SpecialityService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $specialities = SpecialityResource::collection(
            $this->service->getAll()
        );

        return api_response(
            'success',
            'Specialities retrieved successfully',
            $specialities,
            200
        );
    }

    public function show($id)
    {
        $speciality = $this->service->show($id);

        return api_response(
            'success',
            'Speciality retrieved successfully',
            new SpecialityResource($speciality),
            200
        );
    }

}
