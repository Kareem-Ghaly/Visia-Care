<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'availability_id' => 'required|exists:doctor_availabilities,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',

        ];
    }
    public function messages()
    {
        return [
            'availability_id.required' => 'Availability ID is required.',
            'availability_id.exists' => 'The selected availability does not exist.',
            'appointment_date.required' => 'Appointment date is required.',
            'appointment_time.required' => 'Appointment time is required (H:i format).',
        ];
    }
}
