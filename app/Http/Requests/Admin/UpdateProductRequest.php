<?php

namespace App\Http\Requests\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        $product = $this->route('product');

        return [

            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id'),
            ],

            'brand_id' => [
                'required',
                Rule::exists(Brand::class, 'id'),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Product::class, 'name')->ignore($product),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'nullable',
                'numeric',
                'gte:0',
                'lt:price',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'images' => [
                'nullable',
                'array',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'featured' => [
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
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'category_id.required' => 'Please select a category.',
            'category_id.exists'   => 'The selected category is invalid.',

            'brand_id.required'    => 'Please select a brand.',
            'brand_id.exists'      => 'The selected brand is invalid.',

            'name.required'        => 'The product name is required.',
            'name.unique'          => 'The product name already exists.',
            'name.max'             => 'The product name may not exceed 255 characters.',

            'price.required'       => 'The price is required.',
            'price.numeric'        => 'The price must be a number.',
            'price.min'            => 'The price must be at least 0.',

            'sale_price.numeric'   => 'The sale price must be a number.',
            'sale_price.lt'        => 'The sale price must be less than the regular price.',

            'quantity.required'    => 'The quantity is required.',
            'quantity.integer'     => 'The quantity must be an integer.',
            'quantity.min'         => 'The quantity cannot be negative.',

            'images.array'         => 'Images must be sent as an array.',
            'images.*.image'       => 'Each file must be an image.',
            'images.*.mimes'       => 'Allowed image formats: jpg, jpeg, png, webp.',
            'images.*.max'         => 'Each image must not exceed 5MB.',

            'status.required'      => 'The status field is required.',

            'featured.required'    => 'The featured field is required.',

            'sort_order.integer'   => 'The sort order must be an integer.',
            'sort_order.min'       => 'The sort order cannot be negative.',
        ];
    }
}
