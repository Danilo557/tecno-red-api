<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Statement;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id'=> Client::all()->random()->id,
            'amount'=>$this->faker->randomFloat(100, 500, 1000),
            'date'=>$this->faker->dateTimeBetween('-2 years'),
            'days'=>$this->faker->numberBetween(1,30),
            'type'=>Statement::MONTHLY,
            'status'=>Statement::ACTIVE,
        ];
    }
}
