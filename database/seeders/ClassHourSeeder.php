<?php

namespace Database\Seeders;

use App\Models\class_hour;
use Illuminate\Database\Seeder;

class ClassHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hc = new class_hour();
        $hc->id = 1;
        $hc->enter = "07:45";
        $hc->exit = "08:35";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->id = 2;
        $hc->enter = "08:35";
        $hc->exit = "09:25";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->id = 3;
        $hc->enter = "09:25";
        $hc->exit = "10:15";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->id = 4;
        $hc->enter = "10:15";
        $hc->exit = "11:05";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->id = 5;
        $hc->enter = "11:25";
        $hc->exit = "12:15";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->id = 6;
        $hc->enter = "12:15";
        $hc->exit = "13:05";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->id = 7;
        $hc->enter = "12:15";
        $hc->exit = "13:55";
        $hc ->save();
        unset($hc);
    }
}
