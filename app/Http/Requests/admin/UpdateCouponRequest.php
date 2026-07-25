<?php

namespace App\Http\Requests\Admin;

use App\Enums\CouponType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')
                    ->ignore($this->route('coupon')),
            ],

            'type' => [
                'required',
                Rule::enum(CouponType::class),
            ],

            'value' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'minimum_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'maximum_discount' => [
                'nullable',
                'numeric',
                'gt:0',
            ],

            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => __('validation.required', ['attribute' => __('admin.code')]),
            'code.unique' => __('validation.unique', ['attribute' => __('admin.code')]),
            'code.max' => __('validation.max.string', [
                'attribute' => __('admin.code'),
                'max' => 50,
            ]),

            'type.required' => __('validation.required', ['attribute' => __('admin.type')]),

            'value.required' => __('validation.required', ['attribute' => __('admin.value')]),
            'value.numeric' => __('validation.numeric', ['attribute' => __('admin.value')]),
            'value.gt' => __('validation.gt.numeric', [
                'attribute' => __('admin.value'),
                'value' => 0,
            ]),

            'minimum_amount.numeric' => __('validation.numeric', ['attribute' => __('admin.minimum_amount')]),
            'minimum_amount.min' => __('validation.min.numeric', [
                'attribute' => __('admin.minimum_amount'),
                'min' => 0,
            ]),

            'maximum_discount.numeric' => __('validation.numeric', ['attribute' => __('admin.maximum_discount')]),
            'maximum_discount.gt' => __('validation.gt.numeric', [
                'attribute' => __('admin.maximum_discount'),
                'value' => 0,
            ]),

            'usage_limit.integer' => __('validation.integer', ['attribute' => __('admin.usage_limit')]),
            'usage_limit.min' => __('validation.min.numeric', [
                'attribute' => __('admin.usage_limit'),
                'min' => 1,
            ]),

            'starts_at.date' => __('validation.date', ['attribute' => __('admin.starts_at')]),

            'expires_at.date' => __('validation.date', ['attribute' => __('admin.expires_at')]),
            'expires_at.after' => __('validation.after', [
                'attribute' => __('admin.expires_at'),
                'date' => __('admin.starts_at'),
            ]),

            'status.required' => __('validation.required', ['attribute' => __('admin.status')]),
            'status.boolean' => __('validation.boolean', ['attribute' => __('admin.status')]),
        ];
    }
}
