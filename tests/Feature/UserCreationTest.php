<?php

/** @var Tests\TestCase $this */

use App\Enum\UsersRoles;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

test('check if the guest can not access the dashboard and user can', function () {
    $this->get('/dashboard')->assertRedirect(route('login'));
    $user = User::factory()->create([
        'role' => UsersRoles::DOCTOR,
    ]);
    $this->actingAs($user)->get('/dashboard')->assertStatus(200);
});

test('check if the admin can create doctors', function(){
    $user = User::factory()->create([
        'role' => UsersRoles::ADMIN,
    ]);
    Specialization::factory(2)->create();

    $this->actingAs($user)->get(route('dashboard'))->assertStatus(200);
    $this->post('/doctors', [
        'name' => 'Test2 User',
        'email' => 'test2@example.com',
        'phone' => '+1234567890',
        'bio' => 'test bio',
        'vizita_price' => 100,
        'profile_image' => null,
        'is_active' => true,
        'specializations' => [1,2],
    ])->assertRedirect(route('doctors.index'));
    $this->assertDatabaseHas('users', [
        'name' => 'Test2 User',
        'email' => 'test2@example.com',
    ])->assertDatabaseHas('doctors', [
        'bio' => 'test bio',
        'vizita_price' => 100,
        'profile_image' => "doctor_default_profile_image.jpg",
        'is_active' => 1,
    ]);
});

test('check if the doctor can login and authenticate', function(){
    $user = User::factory()->create([
        'role' => UsersRoles::DOCTOR,
    ]);
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('check if the admin can edit doctor details', function(){
    $user = User::factory()->create([
        'role' => UsersRoles::ADMIN,
    ]);
    Specialization::factory(2)->create();
    $doctor = Doctor::factory()->create();
    $this->actingAs($user)->get(route('dashboard'))->assertStatus(200);
    $this->put(route('doctors.update', $doctor->id), [
        'name' => 'Test2 doctor',
        'email' => 'test2doctor@example.com',
        'phone' => '+1234567890',
        'bio' => 'test bio',
        'vizita_price' => 100,
        'profile_image' => null,
        'is_active' => true,
        'specializations' => [1,2],
    ])->assertStatus(302)->assertRedirect(route('doctors.index'));
    $this->assertDatabaseHas('users', [
        'name' => 'Test2 doctor',
        'email' => 'test2doctor@example.com',
    ])->assertDatabaseHas('doctors', [
        'bio' => 'test bio',
        'vizita_price' => 100,
        'profile_image' => "doctor_default_profile_image.jpg",
        'is_active' => 1,
    ]);
});
