<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [

            'rating' => [

                'required',

                'integer',

                'between:1,5',

            ],

            'comment' => [

                'required',

                'string',

                'min:10',

                'max:1000',

            ],

        ];
    }
}
