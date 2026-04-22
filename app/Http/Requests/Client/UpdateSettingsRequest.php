<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notifications' => 'sometimes|boolean',
            'language'      => 'sometimes|string|in:en,ar',
            'dark_mode'     => 'sometimes|boolean',
        ];
    }
}
