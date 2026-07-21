<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'address_id' => [
                'required',
                'integer',
                'exists:addresses,id',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'address_id' => 'shipping address',
        ];
    }

    public function messages(): array
    {
        return [
            'address_id.required' => 'The address is required.',
            'address_id.integer'  => 'The address ID must be an integer.',
            'address_id.exists'   => 'The selected address does not exist.',
        ];
    }
}
