<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user' => 'required|exists:users,code',
            'category' => 'required|exists:categories,slug',
            'headline' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'user attribute missing',
            'user.exists' => 'invalid user',
            'category.required' => 'category attribute missing',
            'category.exists' => 'invalid category',
            'headline.required' => 'headline required',
            'content.required' => 'content required',
        ];
    }
}
