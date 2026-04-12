<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreRatingRequest;
use App\Http\Requests\Client\UpdateRatingRequest;
use App\Http\Resources\Client\RatingResource;
use App\Services\Client\RatingService;

class RatingController extends Controller
{
    public function __construct(
        private RatingService $service
    ) {}

    public function index()
    {
        return api_response(
            'success',
            'Ratings fetched successfully',
            RatingResource::collection($this->service->list())
        );
    }

    public function store(StoreRatingRequest $request)
    {
        $rating = $this->service->store($request->validated());

        return api_response(
            'success',
            'Rating submitted successfully',
            new RatingResource($rating),
            201
        );
    }

    public function show($id)
    {
        return api_response(
            'success',
            'Rating fetched successfully',
            new RatingResource($this->service->show($id))
        );
    }

    public function update(UpdateRatingRequest $request, $id)
    {
        $rating = $this->service->update($id, $request->validated());

        return api_response(
            'success',
            'Rating updated successfully',
            new RatingResource($rating)
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return api_response(
            'success',
            'Rating deleted successfully'
        );
    }
}
