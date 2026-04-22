<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Services\Admin\BannerService;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $data = $this->bannerService->index();

        return api_response(
            'success',
            'Banners fetched successfully',
            $data,
            200
        );
    }

    public function store(StoreBannerRequest $request)
    {
        $result = $this->bannerService->store($request->validated());

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }
}
