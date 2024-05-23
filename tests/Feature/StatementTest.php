<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class StatementTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";


    public function test_statement_created_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $client = Client::factory()->create();
        $data = [
            'client_id' => $client->id,
            'amount' => 1000.00,
            'date' => '2010-11-12',
            'days' => 30,
            "type" => Statement::MONTHLY,
            'status' => Statement::ACTIVE
        ];


        $response = $this->post($this->host_name . "/api/statements", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('statements', $data);
    }

    public function test_statement_fail_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $client = Client::factory()->create();

        $data = [
            'client_id' => $client->id,
            'amount' => 1000.00,
            'date' => '2010-11-12',
            'days' => 30,
            "type" => Statement::MONTHLY,
            'status' => Statement::ACTIVE
        ];

        Statement::create($data);

        $response = $this->post($this->host_name . "/api/statements", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }


    public function test_statement_update_success()
    {
        $client = Client::factory()->create();
        $statement = Statement::factory()->create();
        $array = [
            'client_id' => $client->id,
            'amount' => 1000.00,
            'date' => '2010-11-12',
            'days' => 30,
            "type" => Statement::MONTHLY,
            'status' => Statement::ACTIVE
        ];



        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);


        $response = $this->putJson($this->host_name . "/api/statements/" . $statement->id, $array, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'code',
        ]);
    }


    public function test_statement_delete_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();

        $response = $this->deleteJson($this->host_name . "/api/statements/" . $statement->id, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
