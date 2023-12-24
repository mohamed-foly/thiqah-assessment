<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:191',
            'description' => 'required|string|max:191',
            'image' => 'required|image|max:2048',
            'price' => [
                'required',
                'regex:/^\d{1,16}(\.\d{1,2})?$/'
            ],
            'slug' => 'required|string|max:191',
            'is_active' => 'required|boolean',
        ];
    }
}
