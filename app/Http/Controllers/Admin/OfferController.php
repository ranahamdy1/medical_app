<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OfferResource;
use App\Services\Admin\OfferService;
use App\Http\Requests\Admin\StoreOfferRequest;
use App\Http\Requests\Admin\UpdateOfferRequest;

class OfferController extends Controller
{
    protected $service;

    public function __construct(OfferService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $offers = OfferResource::collection(
            $this->service->getAll()
        );

        return api_response(
            'success',
            'Offers retrieved successfully',
            $offers,
            200
        );
    }

    public function store(StoreOfferRequest $request)
    {
        $offer = $this->service->store($request);

        return api_response(
            'success',
            'Offer created successfully',
            new OfferResource($offer),
            201
        );
    }

    public function show($id)
    {
        $offer = $this->service->show($id);

        return api_response(
            'success',
            'Offer details retrieved successfully',
            new OfferResource($offer),
            200
        );
    }

    public function update(UpdateOfferRequest $request, $id)
    {
        $offer = $this->service->update($request, $id);

        return api_response(
            'success',
            'Offer updated successfully',
            new OfferResource($offer),
            200
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return api_response(
            'success',
            'Offer deleted successfully',
            null,
            200
        );
    }
}
