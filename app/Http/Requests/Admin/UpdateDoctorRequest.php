<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'sometimes|string',
            'email'         => 'sometimes|email',
            'phone'         => 'sometimes|string',
            'speciality_id' => 'sometimes|exists:specialities,id',
            'gender'        => 'sometimes|in:male,female',
            'price'         => 'sometimes|numeric',
            'year_of_exp'   => 'sometimes|integer',
            'about_doctor'  => 'sometimes|string',
            'is_favourite'  => 'sometimes|boolean',
            'certificate_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }
}
