<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OfferResource;
use App\Services\Client\OfferService;

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

}
