<?php

namespace App\Http\Requests\User;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd(auth()->user()->id);
        return [
            'name' => 'required|string',
            'username' => [
                'required',
                'string',
                // Exclude the current user's username from the uniqueness check
                Rule::unique('users', 'username')->ignore($this->route('user')),
            ],
            'password' => 'required|string',
            'is_active' => 'required|boolean',
            'type' => 'required|in:' . implode(',', UserType::values())
        ];
    }
}
