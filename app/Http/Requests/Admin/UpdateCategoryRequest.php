<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id, 'id')],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
                Rule::notIn([$category->id]),
            ],
            'status' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.unique' => 'The category name has already been taken.',
            'name.max' => 'The category name must not exceed 255 characters.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed image formats: jpg, jpeg, png, webp.',
            'image.max' => 'The image size must not exceed 2MB.',
            'parent_id.exists' => 'The selected parent category does not exist.',
            'parent_id.not_in' => 'A category cannot be set as its own parent.',
            'status.required' => 'The status field is required.',
            'sort_order.integer' => 'The sort order must be a valid integer.',
        ];
    }
}
