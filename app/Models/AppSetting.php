<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table = 'app_settings';

    protected $fillable = [
        'app_name',
        'subtitle',
        'about',
        'year',
        'rights',
        'note',

        'facebook',
        'instagram',
        'youtube',
        'twitter',

        'privacy_policy',
        'terms',
    ];

    protected $casts = [
        'year' => 'integer',
    ];
}
