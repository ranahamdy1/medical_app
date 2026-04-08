<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id'           => 'required|exists:doctors,id',
            'title'               => 'required|string',
            'price'               => 'required|numeric',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'image'               => 'nullable|image',
        ];
    }
}
