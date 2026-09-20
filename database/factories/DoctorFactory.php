<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'bio' => fake()->text(),
            'profile_image' => fake()->imageUrl(),
            'vizita_price' => fake()->randomFloat(2, 100, 500),
            'is_active' => true,
        ];
    }
}
