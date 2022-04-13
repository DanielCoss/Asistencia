<?php

namespace App\Http\Controllers;

use App\Models\Quincenal_assistance;
use App\Models\Employer;
use App\Models\Fortnight;
use Illuminate\Http\Request;


class AddEmployerController extends Controller
{
    public function addEmployer(Request $request){
        $request->post();
        $id = $_POST["id"];
        $c = Employer::where('id',$id)->first();
        $status = 0;
        if ($c == NULL || !$c->id == $id){
            $name = $_POST["name"];
            $job = $_POST["job"];
            $department = $_POST["department"];
            $salary = $_POST["salary"];
            $d = new Employer();
            $d->id = $id;
            $d->name = $name;
            $d->job = $job;
            $d->department = $department;
            $d->salary = $salary;
            $d->save();
            unset ($d);

            $month = date('m');
            $month = intval($month);
            $year = date('Y');
            $year = intval($year);

            $collection = Fortnight::latest()->orderByDesc("date")->first();
            $id_f = $collection->id;

            $e = new Quincenal_assistance();
            $e->id_employer = $id;
            $e->id_fortnight = $id_f;
            $e->delays = 0;
            $e->absences = 0;
            $e->save();
            unset($e);
        }
        return redirect()->action([HomeController::class, 'index']);
    }
}
