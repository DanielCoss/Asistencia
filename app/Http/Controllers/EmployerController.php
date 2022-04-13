<?php

namespace App\Http\Controllers;

use App\Models\Class_hour;
use App\Models\Daily_assistance;
use App\Models\Quincenal_assistance;
use App\Models\Schedule;
use App\Models\Employer;

class EmployerController extends Controller
{
    public function seeEmployer($id_employer)
    {
        if (isset($_GET["eliminateH"]) && $_GET["eliminateH"] == "on") { //eliminar el horario del Employer
            $d = intval($_GET["day"]);
            $h = intval($_GET["hour"]);
            $e = intval($_GET["id"]);
            Schedule::where('day', $d)->where('time', $h)->where("id_employer", $e)->delete();
        } elseif (isset($_GET["class"]) && isset($_GET["classrom"])) {

            $d = intval($_GET["day"]);
            $h = intval($_GET["hour"]);
            $s = strval($_GET["classrom"]);
            $c = strval($_GET["class"]);
            $x = Schedule::where('id_employer', $id_employer)->where('day', $d)->where('time', $h)->first();
            if ($x == NULL || !$x->id_employer == $id_employer) { //si no encuentra el hourrio mandado por el formulario, crea uno nuevo para el Employer
                $n = new Schedule();
                $n->id_employer = $id_employer;
                $n->day = $d;
                $n->time = $h;
                $n->classrom = $s;
                $n->class = $c;
                $n->save();
            } else { //si lo encuentra, acutaliza el Schedule del Employer
                $n = Schedule::where('day', $d)->where('time', $h)->where("id_employer", $id_employer)->first();
                $n->day = $d;
                $n->time = $h;
                $n->classrom = $s;
                $n->class = $c;
                $n->save();
            }
        } elseif (isset($_GET["eliminate"])) {
            $e = intval($_GET["eliminate"]);
            Quincenal_assistance::where('id_employer', $e)->delete();
            Daily_assistance::where('id_employer', $e)->delete();
            Schedule::where('id_employer', $e)->delete();
            Employer::where('id', $e)->delete();

            return redirect()->action([HomeController::class, 'index']);
        } elseif (isset($_GET["edit"])) {
            $name = strval($_GET["name"]);
            $job = strval($_GET["job"]);
            $department = strval($_GET["department"]);
            $salary = floatval($_GET["salary"]);
            $em = Employer::find($id_employer);
            $em->name = $name;
            $em->job = $job;
            $em->department = $department;
            $em->salary = $salary;
            $em->save();
        }
        $id_employer = intval($id_employer);
        $employer = Employer::where('id', $id_employer)->first();
        $q_asistance = Quincenal_assistance::where('id_employer', $id_employer)->get();
        $d_asistance = Daily_assistance::where('id_employer', $id_employer)->get();
        $schedule = Schedule::where('id_employer', $id_employer)->orderby('time')->orderby('day')->get();
        $hoursclass = Class_hour::orderBy('id')->get();

        return view('Employer', compact('employer', 'q_asistance', 'd_asistance', 'schedule', 'hoursclass'));
    }
}
