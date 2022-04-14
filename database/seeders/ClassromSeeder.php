<?php

namespace Database\Seeders;

use App\Models\Classrom;
use Illuminate\Database\Seeder;

class ClassromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $n = new Classrom();
        $n->id = 2;
        $n->classrom = "1o B";
        $n->save();

        unset($n);
        $n = new Classrom();
        $n->id = 1;
        $n->classrom = "1o A";
        $n->save();
    }
}
