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
use App\Models\Fortnight;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

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


            if ($lesson && $classrom) {
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
        } elseif (isset($_GET["edit_h"])) {
            $hour_u = Class_hour::find((int)$_GET["edit_h"]);
            $hour_u->enter = date('H:i', strtotime(($_GET['hour1'])));
            $hour_u->exit = date('H:i', strtotime(($_GET['hour2'])));
            $hour_u->save();
        }
        $id_employer = intval($id_employer);
        $employer = Employer::find($id_employer);
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

        return view('Employer', compact('employer', 'q_asistance', 'd_asistance', 'schedule', 'hoursclass', 'classroms', 'lessons'));
    }

    public function editAsistance(Request $request)
    {
        $asistance = Daily_assistance::where('id_employer', $request->id)->where('date', $request->date)->first();
        if (!is_null($asistance)) {
            $asistance->note = $request->note;
            $asistance->status = $request->status;
            $asistance->save();
        } else {
            $asistance = new Daily_assistance();
            $date = explode("-", $request->date);

            if (intval($date[2]) >= 15) {
                $idate = "01-" . $date[1] . "-" . $date[0];
            } else {
                if(intval($date[1]) == 1){
                    $date[1] = "12";
                    $date[0] = date ('Y', strtotime(strval(intval($date[0])- 1)));
                }else{
                    $date[1] = date('m',strtotime(strval(intval($date[1]) - 1)));
                }
                $date[2] = "15";
                $idate = $date[0]."-".$date[1]."-".$date[2];

            }
            $idate = date('Y-m-d', strtotime($idate));


            $f = Fortnight::where('date', $idate)->first();
            if (is_null($f)) {
                unset($f);
                $f = new Fortnight();
                $f->date = $idate;
                $f->save();
            }

            $asistance->date = $request->date;
            $asistance->id_employer = $request->id;
            $asistance->id_fortnight = $f->id;
            $asistance->entrance = "00:00";
            $asistance->out = "00:00";
            $asistance->status = $request->status;
            $asistance->note = $request->note;
            $asistance->save();
        }
        return redirect()->action([EmployerController::class, 'seeEmployer'], ['id_employer' => $request->id]);
    }

    public function calendarInfo($id_employer)
    {
        $columns = [
            'id AS id',
            'status AS title',
            'date AS date',
            'note',
            'backgroundColor',
            'textColor'
        ];
        $event = Daily_assistance::where('id_employer', $id_employer)->get($columns);
        foreach ($event as $e) {
            switch ($e->title) {
                case 'delay':
                    $e->title = "Retraso\n" . $e->note;
                    $e->backgroundColor = "#FFFFA7";
                    break;
                case 'absent':
                    $e->title = "Falta\n" . $e->note;
                    $e->backgroundColor = "#FF7F7F";
                    break;
                case 'asistance':
                    $e->title = "Asistencia\n" . $e->note;
                    $e->backgroundColor = "#3cdfff";
                    break;
                default:
                    break;
            }
            $e->textColor = "black";
        }
        return response()->json($event);
    }
}
