<?php

namespace App\Http\Requests\Web;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'coupon' => [
                'nullable',
                'string',
                'max:50',
            ],

            'payment_method' => [
                'required',
                Rule::enum(PaymentMethod::class),
            ]
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
