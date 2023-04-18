<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'post' => 'required|exists:posts,code',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'user attribute missing',
            'user.exists' => 'invalid user',
            'post.required' => 'post attribute missing',
            'post.exists' => 'invalid post',
            'content.required' => 'content required',
        ];
    }
}
