<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_employer')->references('id')->on('employers');
            $table->string("name");
            $table->date("date");
            $table->time("onDuty");
            $table->time("offDuty");
            $table->time("clockIn")->nullable();
            $table->time("clockOut")->nullable();
            $table->time("late")->nullable();
            $table->time("early")->nullable();
            $table->boolean("absent")->nullable();
            $table->time("workTime")->nullable();
            $table->boolean("must_c_in")->nullable();
            $table->boolean("must_c_out")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csv_files');
    }
}
