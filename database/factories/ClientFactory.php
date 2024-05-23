<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       
        return [
            'name' => $this->faker->name(),
            'pay_day' => $this->faker->dateTimeBetween('-2 years'),
            'amount' => $this->faker->randomFloat(100, 500, 1000),
            'status' => $this->faker->randomElement([Client::ACTIVE, Client::INACTIVE]),
        ];
    }
}
