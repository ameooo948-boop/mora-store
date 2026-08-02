<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'site_name' => [

                'required',

                'string',

                'max:255',

            ],

            'site_description' => [

                'nullable',

                'string',

            ],

            'site_logo' => [

                'nullable',

                'image',

                'max:2048',

            ],

            'site_favicon' => [

                'nullable',

                'image',

                'max:1024',

            ],

            'currency' => [

                'required',

                'string',

                'max:10',

            ],

            'currency_symbol' => [

                'required',

                'string',

                'max:10',

            ],

            'shipping_cost' => [

                'required',

                'numeric',

                'min:0',

            ],

            'tax_percentage' => [

                'required',

                'numeric',

                'min:0',

            ],

            'email' => [

                'nullable',

                'email',

            ],

            'phone' => [

                'nullable',

                'string',

                'max:50',

            ],

            'address' => [

                'nullable',

                'string',

            ],

            'facebook' => [

                'nullable',

                'url',

            ],

            'instagram' => [

                'nullable',

                'url',

            ],

            'linkedin' => [

                'nullable',

                'url',

            ],

            'maintenance_mode' => [

                'nullable',

                'boolean',

            ],

        ];
    }
}
