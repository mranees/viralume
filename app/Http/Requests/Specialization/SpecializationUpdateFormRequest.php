<?php

namespace App\Http\Requests\Specialization;

use App\Models\Specialization;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SpecializationUpdateFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Specialization $specialization */
        $specialization = $this->route('specialization');

        return [
            'name' => 'required|min:3|unique:specializations,name,'.$specialization->id.'|max:255',
            'description' => 'nullable|sometimes|min:3|max:255',
        ];
    }
}
