<?php

namespace App\Services\Client;

use App\Models\Rating;

class RatingService
{
    public function list()
    {
        return Rating::with('doctor')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function store(array $data)
    {
        return Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'doctor_id' => $data['doctor_id']
            ],
            [
                'rate' => $data['rate'],
                'comment' => $data['comment'] ?? null
            ]
        );
    }

    public function show($id)
    {
        return Rating::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $rating = Rating::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $rating->update($data);

        return $rating;
    }

    public function delete($id)
    {
        return Rating::where('user_id', auth()->id())
            ->where('id', $id)
            ->delete();
    }
}
