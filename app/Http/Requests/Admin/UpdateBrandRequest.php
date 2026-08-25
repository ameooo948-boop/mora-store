<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // غيّرها لو عايز تتحقق من صلاحية معينة
    }

    /**
     * قواعد التحقق (Validation Rules)
     */
    public function rules(): array
    {
        $brand = $this->route('brand');
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name')->ignore($brand->id, 'id'),
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

    /**
     * رسائل الأخطاء المخصصة
     */
    public function messages(): array
    {
        return [
            'name.required'        => 'The brand name is required.',
            'name.unique'          => 'The brand name has already been taken.',
            'name.string'          => 'The brand name must be a string.',
            'name.max'             => 'The brand name must not exceed 255 characters.',
            'description.string'   => 'The description must be a string.',
            'logo.image'           => 'The file must be an image.',
            'logo.mimes'           => 'Allowed image formats: jpg, jpeg, png, webp.',
            'logo.max'             => 'The logo size must not exceed 2MB.',
            'status.required'      => 'The status field is required.',
            'status.boolean'       => 'The status field must be true or false.',
            'sort_order.min'       => 'The sort order must be a non-negative integer.',
            'sort_order.integer'   => 'The sort order must be a valid integer.',
        ];
    }
}
