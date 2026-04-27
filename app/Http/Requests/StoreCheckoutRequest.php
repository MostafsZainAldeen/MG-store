<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:64'],
            'address' => ['required', 'string', 'max:2000'],
            'city' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'delivery_details' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name' => __('fields.full_name'),
            'phone' => __('fields.phone'),
            'address' => __('fields.address'),
            'city' => __('fields.city'),
            'notes' => __('fields.notes'),
            'delivery_details' => __('fields.delivery_details'),
        ];
    }
}
