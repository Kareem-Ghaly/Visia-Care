<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRegisterRequest extends FormRequest
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
            'location'     => 'required|string',
            'national_number' => ['required', 'regex:/^\d{11}$/', 'unique:patient_profiles,national_number'],
            'chronic_conditions' => 'nullable |string|max:255'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'The email format is invalid',
            'email.unique' => 'This email address is already in use',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'phone_number.required' => 'Phone number is required',
            'phone_number.unique' => 'This phone number is already in use',
            'gender.required' => 'Gender is required',
            'gender.in' => 'Gender must be either male or female',
            'location.required' => 'Location is required',
            'location.string' => 'Location must be a valid string',
            'national_number.required' => 'National number is required',
            'national_number.regex' => 'National number must be exactly 11 digits and contain numbers only',
            'national_number.unique' => 'This national number is already registered',
            'chronic_conditions.string' => 'Chronic conditions must be a valid string',
            'chronic_conditions.max' => 'Chronic conditions must not exceed 255 characters',
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
