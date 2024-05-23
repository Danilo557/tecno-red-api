<?php

use App\Models\Charge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('chargeable_id')->nullable();
            $table->string('chargeable_type')->nullable();
            $table->float("amount", 10, 2);
            $table->string("description");
            $table->dateTime("date");
            $table->enum('type', [Charge::NORMAL, Charge::MONTHLY])->default(Charge::NORMAL);
            $table->enum('status', [Charge::ACTIVE, Charge::INACTIVE])->default(Charge::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charges');
    }
}
