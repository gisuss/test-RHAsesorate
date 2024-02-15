<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteFavStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'user_id' => 'user id',
            'quote_id' => 'quote id',
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
            'user_id.required' => 'The :attribute is required.',
            'user_id.numeric' => 'The :attribute must be numeric.',
            'user_id.exists' => 'The :attribute do not exists.',
            'quote_id.required' => 'The :attribute is required.',
            'quote_id.numeric' => 'The :attribute must be numeric.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'quote_id' => 'required|numeric'
        ];
    }
}
