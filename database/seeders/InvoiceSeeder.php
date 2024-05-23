<?php

namespace Database\Seeders;

use App\Models\Charge;
use App\Models\File;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invoice::factory(100)->create()->each(function (Invoice $invoice) {
            File::factory(4)->create([
                'fileable_id' => $invoice->id,
                'fileable_type' => Invoice::class,
                'url'=>"posts/factura_prueba.jpg",
                'type'=>File::IMAGE
            ]);

            

            $invoice->products()->attach([
                rand(1, 25) => ['quantity' => 1, "amount" => 100],
                rand(26, 50) => ['quantity' => 2, "amount" => 200],
                rand(51, 75) => ['quantity' => 3, "amount" => 300],
                rand(76, 100) => ['quantity' => 4, "amount" => 400],
            ]);


            $invoice->charges()->create([
                'chargeable_id' => $invoice->id,
                'chargeable_type' => Invoice::class,
                'description' => "manejo de material",
                'amount' => 100,
                'type' => Charge::NORMAL,
                'date' => $invoice->date,
                'status' => Charge::ACTIVE

            ]);
        });
    }
}
