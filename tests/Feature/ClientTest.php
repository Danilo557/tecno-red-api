<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientTest extends TestCase
{

    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";

    public function test_client_created_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $client = [
            'name' => "Juan Pérez",
            'pay_day' => "2022-05-19",
            'amount' => 199.00,
            'status' => Client::ACTIVE
        ];

        $response = $this->post($this->host_name . "/api/clients", $client, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('clients', $client);
    }

    public function test_client_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $client = [
            'name' => "Juan Pérez",
            //debe ser en formato yyyy-mm-dd
            'pay_day' => "2022/05/19",
            'amount' => 199.00,
            'status' => Client::ACTIVE
        ];


        $response = $this->post($this->host_name . "/api/clients", $client, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }

    public function test_client_update_success()
    {

        $array = [
            'name' => "Juan Pérez",
            'pay_day' => "2022-05-19",
            'amount' => 199.00,
            'status' => Client::ACTIVE
        ];

        $client = Client::create($array);

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);


        $response = $this->putJson($this->host_name . "/api/clients/" . $client->id, $array, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }



    public function test_client_get_all()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->get($this->host_name . "/api/clients/", ['Authorization' => 'Bearer ' . $token]);
        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }

    public function test_client_delete_success()
    {
       
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $client = Client::factory()->create();

        $response = $this->deleteJson($this->host_name . "/api/clients/" . $client->id, (array)$client, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
