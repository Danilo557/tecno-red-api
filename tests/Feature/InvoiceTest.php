<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Invoice;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";


    public function test_upload_image()
    {
        Storage::fake();
        $image = UploadedFile::fake()->image('avatar.jpg');

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Store::factory()->create();

        $invoice = Invoice::factory()->create();


        $data = [
            'fileable_id' => $invoice->id,
            'fileable_type' => Invoice::class,
            'url' => $image ,
            'type' => File::IMAGE
        ];

        $response = $this->postJson($this->host_name . "/api/files/",$data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJson($data);

        
    }

    public function test_invoice_get_all()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->get($this->host_name . "/api/invoices/", ['Authorization' => 'Bearer ' . $token]);
        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }

    public function test_invoice_created_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $store = Store::factory()->create();

        $data = [
            'folio' => "0001",
            'date' => "30-10-10",
            'store_id' => $store->id,
            'status' => Invoice::ACTIVE
        ];

        $response = $this->post($this->host_name . "/api/invoices", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('invoices', $data);
    }

    public function test_invoice_fail_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $store = Store::factory()->create();



        $data = [
            'folio' => "0001",
            'date' => "30-10-10",
            'store_id' => "",
            'status' => Invoice::ACTIVE
        ];

        $response = $this->post($this->host_name . "/api/invoices", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }

    public function test_invoice_update_success()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $store = Store::factory()->create();
        $invoice = Invoice::factory()->create();

        $array = [
            'folio' => "0002",
            'date' => "30-10-10",
            'store_id' => $store->id,
            'status' => Invoice::ACTIVE
        ];


        $response = $this->putJson($this->host_name . "/api/invoices/" . $invoice->id, $array, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'code',
            "data"
        ]);
    }

    public function test_statement_delete_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Store::factory()->create();
        $invoice = Invoice::factory()->create();

        $response = $this->deleteJson($this->host_name . "/api/invoices/" . $invoice->id, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
