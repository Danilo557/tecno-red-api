<?php

namespace Tests\Feature;

use App\Models\Charge;
use App\Models\Client;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChargeTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";

    public function test_charge_created_success()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();


        $data = [
            'chargeable_id' => $statement->id,
            'chargeable_type' => Statement::class,
            'description' => "mensualidad de antena",
            'amount' => 351.45,
            'type' => Charge::NORMAL,
            'date' => $statement->date,
            'status' => Charge::ACTIVE
        ];

        $response = $this->post($this->host_name . "/api/charges", $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_charge_fail_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();


        $data = [
            'chargeable_id' => $statement->id,
            'chargeable_type' => Statement::class,
            'description' => "mensualidad de antena",
            'amount' => "",
            'type' => Charge::NORMAL,
            'date' => $statement->date,
            'status' => Charge::ACTIVE
        ];

        $response = $this->post($this->host_name . "/api/charges", $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }

    public function test_charge_update_success()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();


        $data = [
            'chargeable_id' => $statement->id,
            'chargeable_type' => Statement::class,
            'description' => "mensualidad de antena",
            'amount' => 351.45,
            'type' => Charge::NORMAL,
            'date' => $statement->date,
            'status' => Charge::ACTIVE
        ];

        $charge=Charge::create($data);

        $data["amount"]=50.00;

        $response = $this->putJson($this->host_name . "/api/charges/" . $charge->id, $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
        ]);
    }


    public function test_charge_delete_success()
    {
       
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();


        $data = [
            'chargeable_id' => $statement->id,
            'chargeable_type' => Statement::class,
            'description' => "mensualidad de antena",
            'amount' => 351.45,
            'type' => Charge::NORMAL,
            'date' => $statement->date,
            'status' => Charge::ACTIVE
        ];

        $charge=Charge::create($data);

        $response = $this->deleteJson($this->host_name . "/api/charges/" . $charge->id, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
