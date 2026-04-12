<?php

namespace App\Services\Client;

use App\Models\Favourite;

class FavouriteService
{
    public function list()
    {
        return Favourite::with('doctor')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function store($data)
    {
        return Favourite::firstOrCreate([
            'user_id' => auth()->id(),
            'doctor_id' => $data['doctor_id']
        ]);
    }

    public function show($id)
    {
        return Favourite::findOrFail($id);
    }

    public function update($id, $data)
    {
        $fav = Favourite::findOrFail($id);
        $fav->update($data);

        return $fav;
    }

    public function deleteByDoctor($doctorId)
    {
        return Favourite::where('user_id', auth()->id())
            ->where('doctor_id', $doctorId)
            ->delete();
    }
}
