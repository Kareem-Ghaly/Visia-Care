<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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

            'right_sphere'   => 'nullable|numeric',
            'right_cylinder' => 'nullable|numeric',
            'right_axis'     => 'nullable|integer|min:0|max:180',

            'left_sphere'   => 'nullable|numeric',
            'left_cylinder' => 'nullable|numeric',
            'left_axis'     => 'nullable|integer|min:0|max:180',

            'dosage'           => 'nullable|string|max:255',
            'medication_name'  => 'required|string|max:255',
            'effective_period' => 'nullable|string|max:255',
        ];
    }
}
