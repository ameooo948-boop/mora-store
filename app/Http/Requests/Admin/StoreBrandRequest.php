<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name'),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // 2MB
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'        => 'The brand name is required.',
            'name.string'          => 'The brand name must be a string.',
            'name.max'             => 'The brand name must not exceed 255 characters.',
            'name.unique'          => 'The brand name has already been taken.',
            'description.string'   => 'The description must be a string.',
            'logo.image'           => 'The file must be an image.',
            'logo.mimes'           => 'Allowed image formats: jpg, jpeg, png, webp.',
            'logo.max'             => 'The logo size must not exceed 2MB.',
            'status.required'      => 'The status field is required.',
            'status.boolean'       => 'The status field must be true or false.',
            'sort_order.integer'   => 'The sort order must be a valid integer.',
            'sort_order.min'       => 'The sort order must be a non-negative integer.',

        ];
    }
}
