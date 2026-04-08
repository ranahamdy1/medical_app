<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        return User::with('role')->get();
    }

    public function show($id)
    {
        return User::with(['role', 'appointments'])
            ->findOrFail($id);
    }

    public function store($request)
    {
        return User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);
    }

    public function update($request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only([
            'name',
            'phone',
            'email',
            'role_id'
        ]));

        return $user;
    }

    public function delete($id)
    {
        return User::findOrFail($id)->delete();
    }
}
