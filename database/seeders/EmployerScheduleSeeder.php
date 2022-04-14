<?php

namespace Database\Seeders;

use App\Models\Employer_Schedule;
use Illuminate\Database\Seeder;

class EmployerScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $h = new Employer_Schedule();
        $h->id_employer = 10000;
        $h->id_schedule = 1;
        $h->id_classrom = 1;
        $h->id_lesson = 1;
        $h->save();
        unset($h);

        $h = new Employer_Schedule();
        $h->id_employer = 10000;
        $h->id_schedule = 2;
        $h->id_classrom = 2;
        $h->id_lesson = 1;
        $h->save();
        unset($h);

        $h = new Employer_Schedule();
        $h->id_employer = 10000;
        $h->id_schedule = 3;
        $h->id_classrom = 2;
        $h->id_lesson = 1;
        $h->save();
        unset($h);

        $h = new Employer_Schedule();
        $h->id_employer = 10000;
        $h->id_schedule = 4;
        $h->id_classrom = 1;
        $h->id_lesson = 2;
        $h->save();
        unset($h);

        $h = new Employer_Schedule();
        $h->id_employer = 10000;
        $h->id_schedule = 10;
        $h->id_classrom = 2;
        $h->id_lesson = 1;
        $h->save();
        unset($h);

        $h = new Employer_Schedule();
        $h->id_employer = 10000;
        $h->id_schedule = 25;
        $h->id_classrom = 2;
        $h->id_lesson = 1;
        $h->save();
        unset($h);

    }
}
