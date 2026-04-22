<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run()
    {
        \App\Models\AppSetting::firstOrCreate([
            'id' => 1
        ], [
            'app_name' => 'My App',
        ]);
    }
}
