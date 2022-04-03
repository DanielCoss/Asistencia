<?php

namespace Database\Seeders;

use App\Models\class_hour;
use Illuminate\Database\Seeder;

class HorarioClasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hc = new class_hour();
        $hc->tipo = 'm';
        $hc->entrada = "07:45";
        $hc->salida = "08:35";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->tipo = 'm';
        $hc->entrada = "08:35";
        $hc->salida = "09:25";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->tipo = 'm';
        $hc->entrada = "09:25";
        $hc->salida = "10:15";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->tipo = 'm';
        $hc->entrada = "10:15";
        $hc->salida = "11:05";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->tipo = 'm';
        $hc->entrada = "11:25";
        $hc->salida = "12:15";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->tipo = 'm';
        $hc->entrada = "12:15";
        $hc->salida = "13:05";
        $hc ->save();
        unset($hc);

        $hc = new class_hour();
        $hc->tipo = 'm';
        $hc->entrada = "12:15";
        $hc->salida = "13:55";
        $hc ->save();
        unset($hc);
    }
}
