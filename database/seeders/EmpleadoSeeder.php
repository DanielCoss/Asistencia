<?php

namespace Database\Seeders;

use App\Models\employer;
use Illuminate\Database\Seeder;

class employerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employer = new employer();
        $employer->clave = 293888;
        $employer->nombre = " Vallejo Coss Josue Daniel";
        $employer->departamento = 'Edifico T';
        $employer->puesto = 'Becario';
        $employer->sueldo = 2000.23;

        $employer->save();
        $employer = new employer();
        $employer->clave = 293889;
        $employer->nombre = "Vallejo Lopez Raul Segio";
        $employer->departamento = 'Edifico A';
        $employer->puesto = 'Becario';
        $employer->sueldo = 2000.23;

        $employer->save();
    }
}
