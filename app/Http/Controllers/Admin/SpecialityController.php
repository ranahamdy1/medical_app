<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SpecialityResource;
use App\Services\Admin\SpecialityService;
use App\Http\Requests\Admin\StoreSpecialityRequest;
use App\Http\Requests\Admin\UpdateSpecialityRequest;

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

    public function store(StoreSpecialityRequest $request)
    {
        $speciality = $this->service->store($request);

        return api_response(
            'success',
            'Speciality created successfully',
            new SpecialityResource($speciality),
            201
        );
        //return  $this->service->store($request);
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

    public function update(UpdateSpecialityRequest $request, $id)
    {
        $speciality = $this->service->update($request, $id);

        return api_response(
            'success',
            'Speciality updated successfully',
            new SpecialityResource($speciality),
            200
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return api_response(
            'success',
            'Speciality deleted successfully',
            null,
            200
        );
    }
}
