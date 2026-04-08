<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role() { return $this->belongsTo(Role::class); }
    public function doctors() { return $this->hasMany(Doctor::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function favourites() { return $this->hasMany(Favourite::class); }
    public function notifications() { return $this->hasMany(Notification::class); }
    public function ratings() { return $this->hasMany(Rating::class); }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
