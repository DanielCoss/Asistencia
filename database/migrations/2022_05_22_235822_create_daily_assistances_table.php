<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_assistances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_employer')->references('id')->on('employers');
            $table->foreignId('id_fortnight')->references('id')->on('fortnights');
            $table->time("entrance");
            $table->time("out");
            $table->string("status");
            $table->date("date");
            $table->string("note")->nullable();
            $table->string('backgroundColor')->nullable();
            $table->string('textColor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_assistances');
    }
}
