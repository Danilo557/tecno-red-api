<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    private $host_name = "http://tecnored-api.test";
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen_by_api()
    {
        $user = User::factory()->create();

        $response = $this->post($this->host_name . '/api/login', [
            'email' => $user->email,
            'password' => "password"
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "user",
            "authorisation"
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {

        $user = User::factory()->create();

        $response = $this->post($this->host_name . '/api/login', [
            'email' => $user->email,
            'password' => 'passwor',
        ]);

        $response->assertStatus(401);

        $response->assertJson([
            "status" => "error",
            "message" => "Unauthorized"
        ]);
    }

    public function test_new_users_can_register_by_api()
    {
        $response = $this->postJson($this->host_name . '/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            "message",
            "user",
            "authorisation"
        ]);
    }
}
