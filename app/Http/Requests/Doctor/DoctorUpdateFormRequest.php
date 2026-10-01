<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateFormRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'.$this->route('doctor')->user_id.'|max:255',
            'phone' => 'required|string|min:8|max:20',
            // doctor model fields
            'bio' => 'sometimes|nullable|string|max:500',
            'vizita_price' => 'required|numeric|min:0',
            'profile_image' => 'nullable',
            'is_active' => 'boolean',
            // specializations
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'integer|distinct|exists:specializations,id',
            ];
    }
}
