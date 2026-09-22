<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\FollowUp;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FollowUp>
 */
class FollowUpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => fake()->randomElement(Patient::all()->pluck('id')),
            'doctor_id' => fake()->randomElement(Doctor::all()->pluck('id')),
            'appointment_id' => fake()->randomElement(Appointment::all()->pluck('id')),
            'notes' => fake()->text(150),
        ];
    }
}
