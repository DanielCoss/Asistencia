<?php

namespace Database\Seeders;

use App\Models\Fortnight;
use Illuminate\Database\Seeder;

class FortnightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(intval(date("d")) >= 15){
            $idate = "01-".date("m")."-".date("Y");
        }
        else {
            $m = date('m', strtotime('-1 month'));
            $y = date("Y");
            if(intval($m) == 1) $y = date('Y', strtotime('-1 year'));
            $idate = date("d-m-Y",strtotime("15-".$m."-".$y));
        }
        
        $a = new Fortnight();
        $a->date = date('Y-m-d',strtotime($idate));
        $a->save();
    }
}
