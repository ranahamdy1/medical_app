<?php

namespace App\Services\Admin;

use App\Models\Banner;
use App\Http\Resources\Admin\BannerResource;

class BannerService
{
    public function index()
    {
        return BannerResource::collection(
            Banner::latest()->get()
        );
    }

    public function store(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('banners', 'public');
        }

        $banner = Banner::create($data);

        return [
            'status'  => true,
            'message' => 'Banner created successfully',
            'data'    => new BannerResource($banner),
            'code'    => 201
        ];
    }
}
