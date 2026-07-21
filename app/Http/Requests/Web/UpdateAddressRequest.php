<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'full_name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'country' => [
                'required',
                'string',
                'max:255',
            ],

            'state' => [
                'required',
                'string',
                'max:255',
            ],

            'city' => [
                'required',
                'string',
                'max:255',
            ],

            'address_line' => [
                'required',
                'string',
                'max:500',
            ],

            'postal_code' => [
                'nullable',
                'string',
                'max:20',
            ],

            'is_default' => [
                'nullable',
                'boolean',
            ],

        ];
    }
}
