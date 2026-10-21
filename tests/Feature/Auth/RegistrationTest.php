<?php

namespace Tests\Feature\Auth;

use Laravel\Fortify\Features;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->skipUnlessFortifyHas(Features::registration());
    }

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    public function test_new_users_can_register()
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test2 User',
            'email' => 'test2@example.com',
            'phone' => '+1234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test2 User',
            'email' => 'test2@example.com',
            ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
