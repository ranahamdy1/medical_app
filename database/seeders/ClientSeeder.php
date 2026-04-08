<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'client@example.com'],
            [
                'name'     => 'Test Client',
                'password' => Hash::make('123456'),
                'phone'    => '01000000000',
                'role_id'  => 2,
            ]
        );
    }
}
