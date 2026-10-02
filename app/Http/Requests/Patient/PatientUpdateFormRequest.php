<?php

namespace App\Http\Requests\Patient;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateFormRequest extends FormRequest
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
        return [
            // user mdoel fields
            'name' => 'required|string|min:8|max:255',
            'email' => 'required|email|unique:users,email,'.$this->route('patient')->user_id.'|max:255',
            'phone' => 'required|string|min:8|max:20',
            // patient model fields
            'address' => 'required|string|max:255',
        ];
    }
}
