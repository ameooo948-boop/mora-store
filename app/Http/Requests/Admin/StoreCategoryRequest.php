<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
                Rule::unique('categories', 'name'),
            ],
 
            'description' => [
                'nullable',
                'string',
            ],
 
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // 2MB
            ],
 
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
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
            'name.required'        => 'The category name is required.',
            'name.string'          => 'The category name must be a string.',
            'name.max'             => 'The category name must not exceed 255 characters.',
            'name.unique'          => 'The category name has already been taken.',
            'description.string'   => 'The description must be a string.',
            'image.image'          => 'The file must be an image.',
            'image.mimes'          => 'Allowed image formats: jpg, jpeg, png, webp.',
            'image.max'            => 'The image size must not exceed 2MB.',
            'parent_id.exists'     => 'The selected parent category does not exist.',
            'parent_id.not_in'     => 'A category cannot be set as its own parent.',
            'status.required'      => 'The status field is required.',
            'status.boolean'       => 'The status field must be true or false.',
            'status.in'            => 'The status must be either Active or Inactive.',
            'sort_order.integer'   => 'The sort order must be a valid integer.',
            'sort_order.min'       => 'The sort order must be a non-negative integer.',

        ];
    }
}
