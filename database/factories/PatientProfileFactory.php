<?php

namespace Database\Factories;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientProfile>
 */
class PatientProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PatientProfile::class;

    public function definition(): array
    {
        return [
            //
            'user_id' => User::factory(),
            'location' => $this->faker->city,
            'national_number' => $this->faker->unique()->numerify('##########'),
            'chronic_conditions' => $this->faker->sentence,
        ];
    }
}
