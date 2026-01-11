<?php

namespace Database\Factories;

use App\Models\DoctorAvailability;
use App\Models\DoctorProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorAvailability>
 */
class DoctorAvailabilityFactory extends Factory
{
    protected $model = DoctorAvailability::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            //
            'doctor_id' => DoctorProfile::factory(),
            'day_in_week' => $this->faker->randomElement([
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ]),
            'start_time' => $this->faker->time('H:i:s'),
            'end_time' => $this->faker->time('H:i:s'),
        ];
    }
}
