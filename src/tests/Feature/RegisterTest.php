<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
  

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register(): void
    {

        $userData = [
            'name' => 'somename',
            'email' => 'someone@snmt.com',
            'password' => '123123',
            'password_confirmation' => '123123',
        ];

        $response = $this->postJson('/api/register', $userData);


        $response->assertStatus(201)->assertJsonFragment(['status' => 'successful']);

        $this->assertDatabaseHas('users', [
            'email' => 'someone@snmt.com',
        ]);
    }
}
