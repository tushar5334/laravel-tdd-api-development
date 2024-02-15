<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_register_user()
    {
        $this->postJson(
            route('user.register'),
            [
                'name' => "Sarthak",
                'email' => 'sarthak@bitfumes.com',
                'password' => 'secret123',
                'password_confirmation' => 'secret123',
            ]
        )->assertCreated();

        $this->assertDatabaseHas('users', ['name' => 'Sarthak']);
    }
}
