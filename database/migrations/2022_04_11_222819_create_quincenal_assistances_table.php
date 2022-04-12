<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuincenalAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quincenal_assistances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_employer')->references('id')->on('employers');
            $table->foreignId('id_fortnight')->references('id')->on('fortnights');
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
        Schema::dropIfExists('quincenal_assistances');
    }
}
