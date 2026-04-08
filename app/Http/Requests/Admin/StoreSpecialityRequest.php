<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|string',
            'image'     => 'nullable|image',
            'parent_id' => 'nullable|exists:specialities,id',
            'num_of_available_doctor' => 'nullable|integer'
        ];
    }
}
