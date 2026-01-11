<?php

namespace Database\Factories;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorProfile>
 */
class DoctorProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DoctorProfile::class;
    public function definition(): array
    {
        return [
            //
            'user_id' => User::factory(), // ينشئ مستخدم ويربطه بالطبيب
            'license' => $this->faker->unique()->numerify('LIC-#####'),
            'location' => $this->faker->city,
            'bio' => $this->faker->paragraph,
        ];
    }
}
