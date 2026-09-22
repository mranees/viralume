<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\FollowUp;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Database\Factories\DoctorFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Specialization::factory(5)->create();
        Patient::factory(10)->create();
        for ($i=0; $i < 5; $i++) {
            $doctor = Doctor::factory()->create();
            $doctor->specializations()->attach(Specialization::all()->random(2));
        }
        Appointment::factory(20)->create();
        FollowUp::factory(20)->create();
        // $listOfDoctors = Doctor::all()->pluck(['id', 'vizita_price']);
        // $listOfPatients = Patient::all()->pluck('id');
        // $listOfReceptients = User::where('role', 'receptionist')->get()->pluck('id');
        // for ($i=0; $i < $listOfDoctors->count(); $i++) {
        //     Appointment::factory()->create([
        //         'patient_id' => $listOfPatients[$i],
        //         'doctor_id' => $listOfDoctors[$i]['id'],
        //         'booked_by_id' => fake()->randomElement($listOfReceptients),
        //         'total_cost' => $listOfDoctors[$i]['vizita_price'],
        //     ]);
        // }
    }
}
