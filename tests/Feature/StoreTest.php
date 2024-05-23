<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";

    public function test_store_created_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $name = "elecktra";

        $data = [
            "name" => $name,
            "slug" => Str::slug($name),
        ];

        $response = $this->post($this->host_name . "/api/stores", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('stores', $data);
    }

    public function test_store_fail_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            'name' => "tienda azul",
            'slug' => ""//Required
        ];


        $response = $this->post($this->host_name . "/api/stores", $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }

    public function test_brand_update_success()
    {


        $brand=Store::factory()->create();

        $name = "tienda azul";

        $array = [
             'name'=> $name ,
             "slug" => Str::slug($name),
        ];

        
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);


        $response = $this->putJson($this->host_name . "/api/stores/" . $brand->id, $array, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }

    public function test_brand_get_all()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->get($this->host_name . "/api/stores/", ['Authorization' => 'Bearer ' . $token]);
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

        $store = Store::factory()->create();

        $response = $this->deleteJson($this->host_name . "/api/stores/" . $store->id, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
