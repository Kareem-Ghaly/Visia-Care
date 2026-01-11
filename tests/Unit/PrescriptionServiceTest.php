<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\Prescription;
use Spatie\Permission\Models\Role;
use App\Services\PrescriptionService;

class PrescriptionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_prescription_for_patient()
    {
        Role::firstOrCreate(['name' => 'Patient']);
        Role::firstOrCreate(['name' => 'Doctor']);


        $patientUser = User::factory()->create();
        $patientUser->assignRole('Patient');
        $patientProfile = PatientProfile::factory()->create([
            'user_id' => $patientUser->id,
        ]);

        $doctorUser = User::factory()->create();
        $doctorUser->assignRole('Doctor');
        $doctorProfile = DoctorProfile::factory()->create([
            'user_id' => $doctorUser->id,
        ]);
        $this->actingAs($doctorUser);
        $service = app(PrescriptionService::class);

        $prescription = $service->addPrescription([
            'patient_profile_id' => $patientProfile->id,
            'medication_name'    => 'Paracetamol',
            'dosage'             => '500mg',
            'effective_period'   => '7 days',
            'right_sphere'       => 1.25,
            'left_sphere'        => 1.00,
        ]);
        $this->assertInstanceOf(Prescription::class, $prescription);
        $this->assertDatabaseHas('prescriptions', [
            'patient_profile_id' => $patientProfile->id,
            'doctor_id'          => $doctorProfile->id,
            'medication_name'    => 'Paracetamol',
        ]);
    }
}
