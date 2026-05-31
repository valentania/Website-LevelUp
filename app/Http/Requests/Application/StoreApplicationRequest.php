<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isMahasiswa();
    }

    public function rules(): array
    {
        return [
            'mission_id' => ['required', 'exists:missions,id'],
        ];
    }
}
