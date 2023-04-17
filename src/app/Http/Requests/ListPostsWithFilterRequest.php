<?php

namespace App\Http\Requests;

use App\Lib\Posts\Category;
use App\Lib\Users\UserRepository;
use Illuminate\Foundation\Http\FormRequest;

class ListPostsWithFilterRequest extends FormRequest
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
            'user' => 'sometimes|required|exists:users,code',
            'category' => 'sometimes|required|exists:categories,slug',
        ];
    }

    protected function passedValidation()
    {
        $input = $this->input();

        $this->replace(['filter' => [
            'user_id' => !empty($input['user']) ? UserRepository::getByCode($input['user'])->id : null,
            'category_id' => !empty($input['category']) ? Category::getBySlug($input['category'])->getId() : null,
        ]]);
    }
}
