<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AppointmentService;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\DoctorAvailability;
use Spatie\Permission\Models\Role;

class AppointmentServiceFutureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_accepts_appointment_in_future()
{
    Role::firstOrCreate(['name' => 'Patient']);

    $patientUser = User::factory()->create();
    $patientUser->assignRole('Patient');

    PatientProfile::factory()->create([
        'user_id' => $patientUser->id,
    ]);

    $doctorProfile = DoctorProfile::factory()->create();

    $availability = DoctorAvailability::factory()->create([
        'doctor_id' => $doctorProfile->id,
        'day_in_week' => 'monday',
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
    ]);

    $this->actingAs($patientUser);

    $service = app(AppointmentService::class);

    $response = $service->createAppointment([
        'availability_id' => $availability->id,
        'appointment_date' => now()->next('monday')->toDateString(),
        'appointment_time' => '10:00',
    ]);

    $this->assertEquals(201, $response->getStatusCode());
}
}
