<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // أول إنشاء user للدكتور
        $user = User::updateOrCreate(
            ['email' => 'doctor@example.com'],
            [
                'name'     => 'Dr. Ahmed',
                'password' => Hash::make('123456'),
                'phone'    => '01000000001',
                'role_id'  => 3, // doctor role
            ]
        );

        // ثم إنشاء الدكتور
        Doctor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'speciality_id'    => 1,
                'gender'           => 'male',
                'price'            => 200,
                'duration'         => 30,
                'evaluation'       => 5,
                'year_of_exp'      => 10,
                'is_favourite'     => false,
                'about_doctor'     => 'Experienced doctor',
            ]
        );
    }
}
