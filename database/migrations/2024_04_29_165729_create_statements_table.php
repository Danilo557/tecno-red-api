<?php

use App\Models\Statement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->float("amount",10,2);
            $table->dateTime("date");
            $table->integer("days")->default(30);
            $table->enum('type',[Statement::MONTHLY,Statement::DAILY])->default(Statement::MONTHLY);
            $table->enum('status',[Statement::ACTIVE,Statement::INACTIVE])->default(Statement::ACTIVE);
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
        Schema::dropIfExists('statements');
    }
}
