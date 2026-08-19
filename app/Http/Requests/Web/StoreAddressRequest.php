<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreAddressRequest extends FormRequest
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

                Rule::unique('addresses', 'address_line')
                    ->where(function ($query) {
                        return $query
                            ->where('user_id', $this->user()->id)
                            ->where('country', $this->country)
                            ->where('state', $this->state)
                            ->where('city', $this->city);
                    }),
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

    public function messages(): array
    {
        return [
            'full_name.required' => 'The full name is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.max' => 'The full name may not be greater than 255 characters.',

            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',

            'country.required' => 'The country is required.',
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country may not be greater than 255 characters.',

            'state.required' => 'The state is required.',
            'state.string' => 'The state must be a string.',
            'state.max' => 'The state may not be greater than 255 characters.',

            'city.required' => 'The city is required.',
            'city.string' => 'The city must be a string.',
            'city.max' => 'The city may not be greater than 255 characters.',

            'address_line.required' => 'The address is required.',
            'address_line.string' => 'The address must be a string.',
            'address_line.max' => 'The address may not be greater than 500 characters.',
            'address_line.unique' => 'You already have this address saved.',

            'postal_code.string' => 'The postal code must be a string.',
            'postal_code.max' => 'The postal code may not be greater than 20 characters.',

            'is_default.boolean' => 'The default address field must be true or false.',
        ];
    }
}
