<?php

namespace App\Http\Requests\Mission;

use App\Enums\MissionCategoryEnum;
use App\Enums\ComplexityLevelEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isUmkm();
    }

    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string', 'max:5000'],
            'category'       => ['required', Rule::enum(MissionCategoryEnum::class)],
            'complexity'     => ['nullable', Rule::enum(ComplexityLevelEnum::class)],
            'deadline'       => ['required', 'date', 'after:today'],
            'requirements'   => ['nullable', 'string', 'max:2000'],
            'deliverables'   => ['required', 'string', 'max:2000'],
            'max_applicants' => ['nullable', 'integer', 'min:1', 'max:20'],
            'skill_tags'     => ['nullable', 'string', 'max:300'],
        ];
    }

    public function messages(): array
    {
        return [
            'deadline.after' => 'Deadline harus setelah hari ini.',
        ];
    }
}
