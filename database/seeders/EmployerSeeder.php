<?php

namespace Database\Seeders;

use App\Models\employer;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employer = new employer();
        $employer->id = 10000;
        $employer->name = " Vallejo Coss Josue Daniel";
        $employer->department= 'Edifico T';
        $employer->job = 'Becario';
        $employer->salary = 2000.23;
        $employer->save();
        unset($employer);
        $employer = new employer();
        $employer->id = 10001;
        $employer->name = "Vallejo Lopez Raul Segio";
        $employer->department = 'Edifico A';
        $employer->job = 'Becario';
        $employer->salary = 2000.23;

        $employer->save();
    }
}
