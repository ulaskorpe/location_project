<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login()
    {
         
        User::factory()->create([
            'email' => 'anoter@smt.com',
            'password' =>Hash::make('123123'),
        ]);

        $loginData = [
            'email' => 'anoter@smt.com',
            'password' => '123123',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200)->assertJsonFragment(['status' => 'successful']);
    }
}
