<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class InvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";

    public function test_add_invoices_products()
    {
        // 

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Brand::factory()->create();
        Store::factory()->create();

        $invoice = Invoice::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'amount' => 100.00
        ];

        $response = $this->postJson($this->host_name . "/api/add/invoices/products", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }

    public function test_update_invoices_products()
    {
        // 

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Brand::factory()->create();
        Store::factory()->create();

        $invoice = Invoice::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'amount' => 200.00
        ];

        $response = $this->putJson($this->host_name . "/api/edit/invoices/products", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }

    public function test_delete_invoices_products()
    {
        // 

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Brand::factory()->create();
        Store::factory()->create();

        $invoice = Invoice::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson($this->host_name . "/api/delete/invoices/" . $invoice->id . "/products/" . $product->id, [], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
