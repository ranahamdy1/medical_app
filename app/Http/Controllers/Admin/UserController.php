<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;

class UserController extends Controller
{
    public function __construct(
        private UserService $service
    ) {}

    public function index()
    {
        return api_response(
            'success',
            'Users retrieved successfully',
            UserResource::collection($this->service->getAll()),
            200
        );
    }

    public function show($id)
    {
        return api_response(
            'success',
            'User retrieved successfully',
            new UserResource($this->service->show($id)),
            200
        );
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->service->store($request);

        return api_response(
            'success',
            'User created successfully',
            new UserResource($user),
            201
        );
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->service->update($request, $id);

        return api_response(
            'success',
            'User updated successfully',
            new UserResource($user),
            200
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return api_response(
            'success',
            'User deleted successfully',
            null,
            200
        );
    }
}
