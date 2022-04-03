<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensualAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensual_assistances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_employer')->references('id')->on('employers');
            $table->string("month");
            $table->string("year");
            $table->integer("delays");
            $table->integer("absences");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensual_assistances');
    }
}
