<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'folio'=>$this->faker->uuid(),
            'date'=>$this->faker->date(),
            'store_id'=> Store::all()->random()->id,
            'status'=>$this->faker->randomElement([Invoice::ACTIVE,Invoice::ACTIVE]),
        ];
    }
}
