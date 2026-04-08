<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id'           => 'sometimes|exists:doctors,id',
            'title'               => 'sometimes|string',
            'price'               => 'sometimes|numeric',
            'discount_percentage' => 'sometimes|integer|min:0|max:100',
            'image'               => 'nullable|image',
        ];
    }
}
