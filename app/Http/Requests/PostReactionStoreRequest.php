<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostReactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'post_id'   => ['required', 'integer', 'exists:posts,id'],
            'reaction'  => ['required', 'string', 'max:255'],
        ];
    }
}
