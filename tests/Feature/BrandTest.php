<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    private $host_name = "http://tecnored-api.test";

    public function test_brand_created_success()
    {

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $name = "coca cola";

        $data = [
            "name" => $name,
            "slug" => Str::slug($name),
        ];

        $response = $this->post($this->host_name . "/api/brands", $data, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('brands', $data);
    }


    public function test_brand_fail_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            'name' => "marca azul",
            'slug' => ""//Required
        ];


        $response = $this->post($this->host_name . "/api/brands", $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "errors"
        ]);
    }


    public function test_brand_update_success()
    {


        $brand=Brand::factory()->create();

        $name = "coca cola";

        $array = [
             'name'=> $name ,
             "slug" => Str::slug($name),
        ];

        
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);


        $response = $this->putJson($this->host_name . "/api/brands/" . $brand->id, $array, ['Authorization' => 'Bearer ' . $token]);
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
        $response = $this->get($this->host_name . "/api/brands/", ['Authorization' => 'Bearer ' . $token]);
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

        $brand = Brand::factory()->create();

        $response = $this->deleteJson($this->host_name . "/api/brands/" . $brand->id, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            "code",
            "data"
        ]);
    }
}
