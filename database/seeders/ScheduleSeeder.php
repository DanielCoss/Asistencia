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
       $h->id_employer = 10000;
       $h->time = 1;
       $h->day = 1;
       $h->class = "Ingles 1";
       $h->classrom = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 1;
       $h->day = 2;
       $h->class = "Ingles 2";
       $h->classrom = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 1;
       $h->day = 3;
       $h->class = "Ingles 2";
       $h->classrom = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 1;
       $h->day = 4;
       $h->class = "Ingles 1";
       $h->classrom = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 1;
       $h->day = 5;
       $h->class = "Ingles 3";
       $h->classrom = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 2;
       $h->day = 1;
       $h->class = "Ingles 3";
       $h->classrom = "3o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 2;
       $h->day = 2;
       $h->class = "Ingles 3";
       $h->classrom = "3o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 2;
       $h->day = 4;
       $h->class = "Ingles 1";
       $h->classrom = "1o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 2;
       $h->day = 5;
       $h->class = "Ingles 1";
       $h->classrom = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 3;
       $h->day = 2;
       $h->class = "Ingles 1";
       $h->classrom = "1o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 3;
       $h->day = 3;
       $h->class = "Ingles 3";
       $h->classrom = "3o B";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 3;
       $h->day = 4;
       $h->class = "Ingles 1";
       $h->classrom = "1o A";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 4;
       $h->day = 1;
       $h->class = "Ingles 1";
       $h->classrom = "1o c";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 4;
       $h->day = 4;
       $h->class = "Ingles 3";
       $h->classrom = "1o c";
       $h->save();
       unset($h);

       $h = new Schedule();
       $h->id_employer = 10000;
       $h->time = 4;
       $h->day = 5;
       $h->class = "Ingles 1";
       $h->classrom = "3o A";
       $h->save();
       unset($h);
    }
}
