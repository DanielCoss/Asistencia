<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer__schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("id_employer")->references("id")->on("employers");
            $table->foreignId("id_lesson")->references("id")->on("lessons");
            $table->foreignId("id_classrom")->references("id")->on("classroms");
            $table->foreignId("id_lesson")->references("id")->on("employers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employer__schedules');
    }
}
