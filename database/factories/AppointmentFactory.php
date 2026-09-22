<?php

namespace Database\Factories;

use App\Enum\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $selectedDateTime = Carbon::instance(fake()->dateTimeBetween('now', '+1 week'));

        $timeSlots = [];
        for ($h = 0; $h < 24; $h += 1) {
            for ($m = 0; $m < 60; $m += 30) {
                $timeSlots[] = sprintf('%02d:%02d', $h, $m);
            }
        }

        $date = $selectedDateTime->format('Y-m-d');
        $startTime = fake()->randomElement($timeSlots);
        $startCarbon = Carbon::parse($date . ' ' . $startTime);
        $endTime = $startCarbon->copy()->addMinutes(30)->format('H:i');

        $doctor = fake()->randomElement(Doctor::all('id', 'vizita_price'));

        return [
            'patient_id' => fake()->randomElement(Patient::all()->pluck('id')),
            'doctor_id' => $doctor['id'],
            'booked_by_id' => fake()->randomElement(User::where('role', 'receptionist')->get()->pluck('id')),
            'date' => $date,
            'starts_at' => $startTime,
            'ends_at' => $endTime,
            'status' => fake()->randomElement(AppointmentStatus::class),
            'total_cost' => $doctor['vizita_price'],
            'notes' => '',
        ];
    }
}
