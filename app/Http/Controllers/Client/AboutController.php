<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\AboutService;

class AboutController extends Controller
{
    protected $service;

    public function __construct(AboutService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return api_response(
            'success',
            'About app fetched successfully',
            $this->service->get()
        );
    }
}
