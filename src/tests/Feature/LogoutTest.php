<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
   
        $user = User::factory()->create([
            'email' => 'anoter@smt.com',
            'password' =>Hash::make('123123'),
        ]);

        // Login the user
        $this->actingAs($user);

        // Make a logout request
        $response = $this->postJson('/api/logout');

        // Assert response status code
        $response->assertStatus(200)->assertJsonFragment(['status' => 'successful']);
    }
}
