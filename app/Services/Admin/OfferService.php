<?php

namespace App\Services\Admin;

use App\Models\Offer;

class OfferService
{
    public function getAll()
    {
        return Offer::with('doctor')->get();
    }

    public function store($request)
    {
        $offer = Offer::create($request->except('image'));

        if ($request->hasFile('image')) {
            $offer->addMediaFromRequest('image')
                ->toMediaCollection('offer_image');
        }

        return $offer;
    }

    public function show($id)
    {
        return Offer::with('doctor')->findOrFail($id);
    }

    public function update($request, $id)
    {
        $offer = Offer::findOrFail($id);

        $offer->update($request->except('image'));

        if ($request->hasFile('image')) {
            $offer->clearMediaCollection('offer_image');

            $offer->addMediaFromRequest('image')
                ->toMediaCollection('offer_image');
        }

        return $offer;
    }

    public function delete($id)
    {
        Offer::findOrFail($id)->delete();
    }
}
