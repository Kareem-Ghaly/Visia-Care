<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalRecordRequest extends FormRequest
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
             'patient_profile_id' => 'required|exists:patient_profiles,id',
             'doctor_profile_id' => 'required|exists:doctor_profiles,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
     public function messages(): array
    {
        return [
            'patient_profile_id.required' => 'Patient profile is required.',
            'patient_profile_id.exists' => 'Patient profile does not exist.',
            'name.required' => 'Medical record name is required.',
        ];
    }
}
