<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isUmkm();
    }

    public function rules(): array
    {
        return [
            'rating'       => ['required', 'integer', 'min:1', 'max:5'],
            'comment'      => ['required', 'string', 'min:10', 'max:1000'],
            'strengths'    => ['nullable', 'string', 'max:500'],
            'improvements' => ['nullable', 'string', 'max:500'],
        ];
    }
}
