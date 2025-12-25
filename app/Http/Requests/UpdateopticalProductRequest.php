<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateopticalProductRequest extends FormRequest
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
             'name'   => 'sometimes|required|string|max:255',

            'type'   => 'sometimes|required|in:lens,glasses,solution',

            'price'  => 'sometimes|required|integer|min:0',

            'amount' => 'sometimes|required|integer|min:0',

            'image'  => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
