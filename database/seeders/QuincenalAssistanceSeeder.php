<?php

namespace Database\Seeders;

use App\Models\Quincenal_assistance;
use Illuminate\Database\Seeder;

class QuincenalAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = new Quincenal_assistance();
        $a->id_employer = 10000;
        $a->id_fortnight = 1;
        $a->delays = 0;
        $a->absences = 0;
        $a->save();
    }
}
