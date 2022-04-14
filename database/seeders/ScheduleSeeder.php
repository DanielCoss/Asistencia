<?php

namespace Database\Seeders;

use App\Models\Class_hour;
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
        $times = Class_hour::all();
        foreach($times as $t){
            for($i = 1 ; $i <= 7 ; $i++){
                $h = new Schedule();
                $h->time = $t->id;
                $h->day = $i;
                $h->save();
                unset($h);
            }
        }
    }
}
