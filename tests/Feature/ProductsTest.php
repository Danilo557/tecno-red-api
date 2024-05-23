<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";

    public function test_product_get_all()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->get($this->host_name . "/api/products/", ['Authorization' => 'Bearer ' . $token]);
        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }

    public function test_product_created_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $brand = Brand::factory()->create();
        $name = "Producto 1";
        $data = [
            'brand_id' => $brand->id,
            'name' => $name,
            "slug" => Str::slug($name),
        ];


        $response = $this->post($this->host_name . "/api/products", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_product_fail_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $brand = Brand::factory()->create();

        $name = "Producto 1";

        $data = [
            'brand_id' => $brand->id,
            'name' => $name,
            "slug" => "",
        ];

        $response = $this->post($this->host_name . "/api/products", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }


    
    public function test_product_update_success()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $brand = Brand::factory()->create();
        $product = Product::factory()->create();

        $name = "Producto 1";

        $array = [
            'brand_id' => $brand->id,
            'name' => $name,
            "slug" => Str::slug($name),
        ];


        $response = $this->putJson($this->host_name . "/api/products/" . $product->id, $array, ['Authorization' => 'Bearer ' . $token]);
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

        Brand::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson($this->host_name . "/api/products/" . $product->id, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
