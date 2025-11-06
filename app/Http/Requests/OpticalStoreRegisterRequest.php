<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpticalStoreRegisterRequest extends FormRequest
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
            'storeName'   => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8'],
            'phone_number' => ['required', 'string', 'unique:users,phone_number'],
            'shift'        => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:500'],
            'location'    => ['nullable', 'string', 'max:255'],

        ];
    }
    public function messages(): array
    {
        return [
            'storeName.required' => 'Store name is required.',
            'email.unique'        => 'Email is already taken.',
            'phone_number.unique' => 'Phone number already exists.',
        ];
    }
         protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors'  => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
