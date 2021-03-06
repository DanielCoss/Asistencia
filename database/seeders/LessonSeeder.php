<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $n = new Lesson();
        $n->id = 1;
        $n->name = "Ingles 1";
        $n->save();
        unset($n);
        
        $n = new Lesson();
        $n->id = 2;
        $n->name = "Ingles 2";
        $n->save();
    }
}
