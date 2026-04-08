<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string',
            'email'             => 'required|email|unique:users',
            'phone'             => 'required|string',
            'password'          => 'required|min:6',
            'speciality_id'     => 'required|exists:specialities,id',
            'gender'            => 'required|in:male,female',
            'price'             => 'required|numeric',
            'year_of_exp'       => 'required|integer',
            'about_doctor'      => 'required|string',
            'certificate_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }
}
