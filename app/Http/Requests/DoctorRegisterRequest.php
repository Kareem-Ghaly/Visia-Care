<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRegisterRequest extends FormRequest
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
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8',
            'phone_number' => 'required|string|unique:users,phone_number',
            'gender'       => 'required|in:male,female',
            'license'      => 'required|string',
            'location'     => 'required|string',
            'shift'        => 'required|date',
            'bio'          => 'nullable|string',

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'This email address is already in use.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.unique' => 'This phone number is already in use.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either male or female.',
            'license.required' => 'Medical license number is required.',
            'license.string' => 'License must be a valid string.',
            'location.required' => 'Location is required.',
            'location.string' => 'Location must be a valid string.',
            'shift.required' => 'Shift date is required.',
            'shift.date' => 'Shift must be a valid date.',
            'bio.string' => 'Bio must be a valid string.',
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
