<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProfileUpdateRequest extends FormRequest
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
        $userId = auth()->id();

        return [
            "user_id" => ["required", "integer", "exists:users,id"],
            "username" => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9._-]+$/',
                Rule::unique('users')->ignore($userId)
            ],
            "name" => ["required", "string", "max:255"],
            "email" => [
                "required", 
                "string", 
                "email", 
                "max:255", 
                Rule::unique('users')->ignore($userId)
            ],
            "biography" => ["max:255"],
            "gender" => ["max:255"],
            "phone" => ["max:255"],
            "zip_code" => ["max:255"],
            "street" => ["max:255"],
            "neighborhood" => ["max:255"],
            "city" => ["max:255"],
            "state" => ["max:255"],
            "number" => ["max:255"],
        ];
    }
}
