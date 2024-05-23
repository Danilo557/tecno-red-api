<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Statement;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";

    public function test_payment_created_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();


        $data = [
            'paymentable_id' => $statement->id,
            'paymentable_type' => Statement::class,
            'amount' => 100.00,
            "date" => $statement->date,
            "description" => "Pago de mensualidad",
            "status"=>1
        ];

        $response = $this->post($this->host_name . "/api/payments", $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }


    public function test_payment_fail_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();

        $data = [
            'paymentable_id' => $statement->id,
            'paymentable_type' => Statement::class,
            'amount' => 100.00,
            "date" => '',
            "description" => "Pago de mensualidad",
            "status"=>1
        ];


        $response = $this->post($this->host_name . "/api/payments", $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }


    public function test_payment_update_success()
    {
       

        Client::factory()->create();
        $statement = Statement::factory()->create();


        $data = [
            'paymentable_id' => $statement->id,
            'paymentable_type' => Statement::class,
            'amount' => 100.00,
            "date" => $statement->date,
            "description" => "Pago de mensualidad",
            "status"=>1
        ];

        $payment= Payment::create($data);

        $data["amount"]=300;

        
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);


        $response = $this->putJson($this->host_name . "/api/payments/" . $payment->id, $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
        ]);
    }


    public function test_payment_delete_success()
    {
       
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Client::factory()->create();
        $statement = Statement::factory()->create();


        $data = [
            'paymentable_id' => $statement->id,
            'paymentable_type' => Statement::class,
            'amount' => 100.00,
            "date" => $statement->date,
            "description" => "Pago de mensualidad",
            "status"=>1
        ];

        $payment= Payment::create($data);

        $response = $this->deleteJson($this->host_name . "/api/payments/" . $payment->id, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
