<?php

namespace App\Services\Client;

use App\Http\Resources\Admin\OfferResource;
use App\Models\Banner;
use App\Models\Doctor;
use App\Http\Resources\Client\CategoryResource;
use App\Http\Resources\Client\DoctorResource;
use App\Models\Offer;
use App\Models\Speciality;

class HomeService
{
    public function getHomeData()
    {
        $categories = Speciality::latest()->take(8)->get();

        $doctors = Doctor::latest()->take(10)->get();

        $banner = Banner::latest()->first();

        return [
            'user' => [
                'name' => auth()->user()->name ?? 'Guest'
            ],

            'banner' => $banner ? [
                'title' => $banner->title,
                'description' => $banner->description,
                'action' => $banner->action,
            ] : null,

            'categories' => CategoryResource::collection($categories),

            'doctors' => DoctorResource::collection($doctors),
            'offers' => OfferResource::collection(Offer::all()),
        ];
    }
}
