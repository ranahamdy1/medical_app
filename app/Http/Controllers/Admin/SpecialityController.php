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
        return SpecialityResource::collection(
            $this->service->getAll()
        );
    }

    public function store(StoreSpecialityRequest $request)
    {
        $speciality = $this->service->store($request);

        return new SpecialityResource($speciality);
    }

    public function show($id)
    {
        return new SpecialityResource(
            $this->service->show($id)
        );
    }

    public function update(UpdateSpecialityRequest $request, $id)
    {
        $speciality = $this->service->update($request, $id);

        return new SpecialityResource($speciality);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json(['message' => 'Deleted']);
    }
}
