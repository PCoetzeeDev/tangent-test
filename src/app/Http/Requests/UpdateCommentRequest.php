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
            'user' => 'sometimes|exists:users,code',
            'post' => 'sometimes|exists:posts,code',
            'content' => 'required', // TODO: required_if would be more appropriate here
        ];
    }

    public function messages()
    {
        return [
            'user.exists' => 'invalid user',
            'post.exists' => 'invalid post',
            'content.required' => 'content required',
        ];
    }
}
