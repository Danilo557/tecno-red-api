<?php

namespace Database\Seeders;

use App\Models\Charge;
use App\Models\Note;
use App\Models\Payment;
use App\Models\Statement;
use DateTime;
use Illuminate\Database\Seeder;

class StatementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Statement::factory(1000)->create()->each(function (Statement $statement) {

            $amount = number_format((float)($statement->amount / 2), 2, '.', '');

            Payment::factory(2)->create([
                'paymentable_id' => $statement->id,
                'paymentable_type' => Statement::class,
                'amount' => $amount,
                "date" => $statement->date,
                "description"=>"Pago de mensualidad"
            ]);

            $charge = Charge::create([
                'chargeable_id' => $statement->id,
                'chargeable_type' => Statement::class,
                'description' => "mensualidad de antena",
                'amount' => 351.45,
                'type' => Charge::NORMAL,
                'date' => $statement->date,
                'status' => Charge::ACTIVE
            ]);

            $amount= number_format((float)($charge->amount / 2), 2, '.', '');

            Payment::factory(2)->create([
                'paymentable_id' => $statement->id,
                'paymentable_type' => Statement::class,
                'amount' => $amount,
                "date" => $statement->date,
                "description"=>"Pago de cargo por antena"
            ]);

        });
    }
}
