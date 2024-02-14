<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
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
            'name' => 'name',
            'lastname' => 'lastname',
            'email' => 'e-mail',
            'role' => 'role',
            'password' => 'password',
            'confirm_password' => 'confirmation password'
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
            'confirm_password.required' => 'The :attribute is required.',
            'confirm_password.same' => 'The :attribute must be same that password.',
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
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|string|exists:roles,name',
            'password' => [
				'required',
				'max:16',
				Password::min(8)
						// ->mixedCase()
						->letters()
						// ->numbers()
						// ->symbols()
						// ->uncompromised(),
            ],
            'confirm_password' => 'required|same:password',
          ];
    }
}
