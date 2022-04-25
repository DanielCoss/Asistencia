<?php

namespace App\Http\Controllers;

use App\Models\Class_hour;
use App\Models\Classrom;
use App\Models\Daily_assistance;
use App\Models\Quincenal_assistance;
use App\Models\Schedule;
use App\Models\Employer;
use App\Models\Employer_Schedule;
use App\Models\Lesson;

class EmployerController extends Controller
{
    public function seeEmployer($id_employer)
    {
        if (isset($_GET["eliminateH"]) && $_GET["eliminateH"] == "on") { //eliminar el horario del Employer
            $d = intval($_GET["day"]);
            $h = intval($_GET["hour"]);
            $e = intval($_GET["id"]);
            $s = Schedule::where('day', $d)->where('time', $h)->first();
            Employer_Schedule::where('id_schedule', $s->id)->where("id_employer", $e)->delete();
        } elseif (isset($_GET["class"]) && isset($_GET["classrom"])) { //si se va a editar o agregar un salon y clase

            $d = intval($_GET["day"]);
            $h = intval($_GET["hour"]);
            $s = intval($_GET["classrom"]);
            $c = intval($_GET["class"]);

            $classrom = Classrom::find($s);
            // if (!$classrom) {
            //     unset($classrom);
            //     $classrom = new Classrom();
            //     $classrom->classrom = $s;
            //     $classrom->save();
            // }

            $lesson = Lesson::find($c);
            // if (!$lesson) {
            //     unset($lesson);
            //     $lesson = new Lesson();
            //     $lesson->name = $c;
            //     $lesson->save();
            // }

            
            if($lesson && $classrom){
                $s = Schedule::where('day', $d)->where('time', $h)->first();
                $x = Employer_Schedule::where('id_employer', $id_employer)->where('id_schedule', $s->id)->first();
                if ($x == NULL || !$x->id_employer == $id_employer) { //si no encuentra el hourrio mandado por el formulario, crea uno nuevo para el Employer
                    unset($x);
                    $x = new Employer_Schedule();
                    $x->id_employer = $id_employer;
                }
                $x->id_schedule = $s->id;
                $x->id_classrom = $classrom->id;
                $x->id_lesson = $lesson->id;
                $x->save();
            }
            

        } elseif (isset($_GET["eliminate"])) {
            $e = intval($_GET["eliminate"]);
            Quincenal_assistance::where('id_employer', $e)->delete();
            Daily_assistance::where('id_employer', $e)->delete();
            Employer_Schedule::where('id_employer', $e)->delete();
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
        } elseif(isset($_GET["edit_h"])) {
            $hour_u = Class_hour::find((int)$_GET["edit_h"]);
            $hour_u->enter = date('H:i',strtotime(($_GET['hour1'])));
            $hour_u->exit = date('H:i',strtotime(($_GET['hour2'])));
            $hour_u->save();
        }
        $id_employer = intval($id_employer);
        $employer = Employer::where('id', $id_employer)->first();
        $q_asistance = Quincenal_assistance::where('id_employer', $id_employer)->get();
        $d_asistance = Daily_assistance::where('id_employer', $id_employer)->get();

        $schedule = Employer_Schedule::select('c.classrom as classrom', 'l.name as class', 's.day as day', 's.time as time')
        ->join('classroms as c', 'employer__schedules.id_classrom', '=', 'c.id')
        ->join('lessons as l', 'employer__schedules.id_lesson', '=', 'l.id')
        ->join('schedules as s', 'employer__schedules.id_schedule', '=', 's.id')
        ->where('employer__schedules.id_employer', $id_employer)
        ->get();
        //dd($schedule);
        $hoursclass = Class_hour::orderBy('id')->get();

        $classroms = Classrom::all();
        $lessons = Lesson::all();

        return view('Employer', compact('employer', 'q_asistance', 'd_asistance', 'schedule', 'hoursclass','classroms','lessons'));
    }
}
