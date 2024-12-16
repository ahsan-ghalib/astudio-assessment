<?php

namespace App\Http\Requests;

use App\Enums\ProjectStatusEnum;
use App\Models\EntityAttribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(ProjectStatusEnum::values())],
            'attribute.*.entity_attribute_id' => ['required', Rule::exists((new EntityAttribute())->getTable(), 'id')],
            'attribute.*.value' => ['required', 'string'],
        ];
    }
}
