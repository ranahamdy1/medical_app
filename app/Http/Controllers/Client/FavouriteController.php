<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreFavouriteRequest;
use App\Http\Requests\Client\UpdateFavouriteRequest;
use App\Http\Resources\Client\FavouriteResource;
use App\Services\Client\FavouriteService;

class FavouriteController extends Controller
{
    public function __construct(
        private FavouriteService $service
    ) {}

    public function index()
    {
        return api_response(
            'success',
            'Favourites fetched successfully',
            FavouriteResource::collection(
                $this->service->list()
            )
        );
    }

    public function store(StoreFavouriteRequest $request)
    {
        $fav = $this->service->store($request->validated());

        return api_response(
            'success',
            'Added to favourites',
            new FavouriteResource($fav),
            201
        );
    }

    public function show($id)
    {
        return api_response(
            'success',
            'Favourite fetched successfully',
            new FavouriteResource(
                $this->service->show($id)
            )
        );
    }

    public function update(UpdateFavouriteRequest $request, $id)
    {
        $fav = $this->service->update($id, $request->validated());

        return api_response(
            'success',
            'Updated successfully',
            new FavouriteResource($fav)
        );
    }

    public function destroy($id)
    {
        $this->service->deleteByDoctor($id);

        return api_response(
            'success',
            'Removed from favourites'
        );
    }
}
