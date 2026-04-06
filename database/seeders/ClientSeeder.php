<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::updateOrCreate(
            ['email' => 'client@example.com'], // unique key
            [
                'name' => 'Test Client',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
