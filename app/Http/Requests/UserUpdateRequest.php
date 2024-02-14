<?php

namespace App\Http\Requests;

use App\Models\{Identification, User};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'email' => 'e-mail',
            'role' => 'role',
            'name' => 'name',
            'lastname' => 'lastname',
        ];
    }

    /**
     * Get the error message for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'The :attribute is required.',
            'email.email' => 'The :attribute do not have a valid format.',
            'email.unique' => 'The :attribute must be unique.',
            'email.max' => 'The :attribute must be less than 255 characters.',
            'name.required' => 'The :attribute is required.',
            'name.max' => 'The :attribute must be less than 255 characters.',
            'name.regex' => 'The :attribute It should only contain letters and spaces.',
            'lastname.required' => 'The :attribute is required.',
            'lastname.max' => 'The :attribute must be less than 255 characters.',
            'lastname.regex' => 'The :attribute It should only contain letters and spaces.',
            'role.required' => 'The :attribute is required.',
            'role.exists' => 'The :attribute does not exist.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'lastname' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => ['required', 'max:255', 'email', Rule::unique('users','email')->ignore($this->user)],
            'role' => 'required|string|exists:roles,name',
        ];
    }
}
