<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 1;
       $h->tday = 1;
       $h->class = "Ingles 1";
       $h->classrom = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 1;
       $h->tday = 2;
       $h->class = "Ingles 2";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 1;
       $h->tday = 3;
       $h->class = "Ingles 2";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 1;
       $h->tday = 4;
       $h->class = "Ingles 1";
       $h->salon = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 1;
       $h->tday = 5;
       $h->class = "Ingles 3";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 2;
       $h->tday = 1;
       $h->class = "Ingles 3";
       $h->salon = "3o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 2;
       $h->tday = 2;
       $h->class = "Ingles 3";
       $h->salon = "3o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 2;
       $h->tday = 4;
       $h->class = "Ingles 1";
       $h->salon = "1o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 2;
       $h->tday = 5;
       $h->class = "Ingles 1";
       $h->salon = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 3;
       $h->tday = 2;
       $h->class = "Ingles 1";
       $h->salon = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 3;
       $h->tday = 3;
       $h->class = "Ingles 3";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 3;
       $h->tday = 4;
       $h->class = "Ingles 1";
       $h->salon = "1o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 4;
       $h->tday = 1;
       $h->class = "Ingles 1";
       $h->salon = "1o c";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 4;
       $h->tday = 4;
       $h->class = "Ingles 3";
       $h->salon = "1o c";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 1;
       $h->time = 4;
       $h->tday = 5;
       $h->class = "Ingles 1";
       $h->salon = "3o A";
       $h->save();
       unset($h);
    }
}
