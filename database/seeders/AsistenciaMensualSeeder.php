<?php

namespace Database\Seeders;

use App\Models\mensual_assistance;
use Illuminate\Database\Seeder;

class AsistenciaMensualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a =  new mensual_assistance();
        $a->clave = 293888;
        $a->mes = '12';
        $a->anno = '2021';
        $a->retardos = 10;
        $a->faltas = 5;
        $a->save();
        unset($a);
        $a =  new mensual_assistance();
        $a->clave = 293889;
        $a->mes = '12';
        $a->anno = '2021';
        $a->retardos = 7;
        $a->faltas = 5;
        $a->save();
        unset($a);
        $a =  new mensual_assistance();
        $a->clave = 293888;
        $a->mes = '10';
        $a->anno = '2021';
        $a->retardos = 0;
        $a->faltas = 0;
        $a->save();
        unset($a);
    }
}
