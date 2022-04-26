<?php

namespace App\Http\Controllers;

use App\Models\Classrom;
use App\Models\Employer_Schedule;
use App\Models\Lesson;
use App\Models\Class_hour;
use App\Models\Employer;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ClassromController extends Controller
{
    public function seeClassroms()
    {
        if (isset($_GET['action'])) {
            switch ((int)$_GET['action']) {
                case 1; //agregar salon
                    if (isset($_GET['classrom']) && !is_null($_GET['classrom'])) {
                        if (!Classrom::where('classrom', $_GET['classrom'])->first()) {
                            $q = new Classrom();
                            $q->classrom = strval($_GET['classrom']);
                            $q->save();
                        }
                    }
                    break;
                case 2: //agregar clase
                    if (isset($_GET['lesson']) && !is_null($_GET['lesson'])) {
                        if (!Lesson::where('name', $_GET['lesson'])->first()) {
                            $q = new Lesson();
                            $q->name = $_GET['lesson'];
                            $q->save();
                        }
                    }
                    break;
                case 3: //eliminar salon
                    if (isset($_GET['d_cl']) && !is_null($_GET['d_cl'])) {
                        $d_id = (int)$_GET['d_cl'];
                        Employer_Schedule::where('id_classrom', $d_id)->delete();
                        Classrom::find($d_id)->delete();
                    }
                    break;
                case 5: //editar salon
                    if (isset($_GET['e_cl']) && !is_null($_GET['e_cl'])) {
                        $e_id = (int)$_GET['e_cl'];
                        $q = Classrom::find($e_id);
                        $q->classrom = $_GET['name'];
                        $q->save();
                    }
                    break;
                case 6: //editar clase
                    if (isset($_GET['e_ll']) && !is_null($_GET['e_ll'])) {
                        if (isset($_GET['eliminate']) && $_GET['eliminate'] == 'on') {
                            $d_ll = intval($_GET['e_ll']);
                            Employer_Schedule::where('id_lesson', $d_ll)->delete();
                            Lesson::find($d_ll)->delete();
                            break;
                        }
                        $e_id = intval($_GET['e_ll']);
                        $q = Lesson::find($e_id);
                        $q->name = strval($_GET['name']);
                        $q->save();
                    }
                    break;
            }
        }
        $classr = Classrom::orderBy('classrom')->get();
        $lessons = Lesson::orderBy('name')->get();
        return view('classroms', compact('classr', 'lessons'));
    }

    public function seeClassrom($id_classrom)
    {
        $id = intval($id_classrom);
        if (isset($_GET['action'])) {
            switch ((int)$_GET['action']) {
                case 1:
                    if (isset($_GET['name']) && !is_null($_GET['name'])) {
                        $c = Classrom::find($id);
                        $c->classrom = $_GET['name'];
                        $c->save();
                    }
                    break;
                case 2:
                    Employer_Schedule::where('id_classrom', $id)->delete();
                    Classrom::where('id', $id)->delete();
                    return redirect()->action([HomeController::class, 'index']);
                    break;
                case 3:
                    if (isset($_GET['teacher']) && !is_null($_GET['class'])) {
                        $d = intval($_GET["day"]);
                        $h = intval($_GET["hour"]);
                        $t = intval($_GET["teacher"]);
                        $l = intval($_GET["class"]);
                        $teacher = Employer::find($t);
                        $lesson = Lesson::find($l);
                        if (isset($_GET['eliminateH']) && $_GET['eliminateH'] == 'on') {

                            $s = Schedule::where('day', $d)->where('time', $h)->first();
                            Employer_Schedule::where('id_schedule', $s->id)->where("id_classrom", $id_classrom)->delete();
                        }
                        if ($lesson && $teacher) {
                            $s = Schedule::where('day', $d)->where('time', $h)->first();
                            $x = Employer_Schedule::where('id_classrom', $id_classrom)->where('id_schedule', $s->id)->first();
                            if ($x == NULL || !$x->id_classrom == $id_classrom) { //si no encuentra el hourrio mandado por el formulario, crea uno nuevo para el Employer
                                unset($x);
                                $x = new Employer_Schedule();
                                $x->id_classrom = $id_classrom;
                            }
                            $x->id_schedule = $s->id;
                            $x->id_employer = $teacher->id;
                            $x->id_lesson = $lesson->id;
                            $x->save();
                        }
                    }
                    break;
                case 4:
                    $hour_u = Class_hour::find((int)$_GET["edit_h"]);
                    $hour_u->enter = date('H:i', strtotime(($_GET['hour1'])));
                    $hour_u->exit = date('H:i', strtotime(($_GET['hour2'])));
                    $hour_u->save();
                    break;
            }
        }

        $schedule = Employer_Schedule::select('e.name as employer', 'l.name as class', 's.day as day', 's.time as time')
            ->join('classroms as c', 'employer__schedules.id_classrom', '=', 'c.id')
            ->join('lessons as l', 'employer__schedules.id_lesson', '=', 'l.id')
            ->join('schedules as s', 'employer__schedules.id_schedule', '=', 's.id')
            ->join('employers as e', 'employer__schedules.id_employer', '=', 'e.id')
            ->where('employer__schedules.id_classrom', $id_classrom)
            ->get();
        $classrom = Classrom::find($id_classrom);
        $hoursclass = Class_hour::orderBy('id')->get();
        $lessons = Lesson::all();
        $teachers = Employer::all();
        return view('classrom', compact('classrom', 'schedule', 'hoursclass', 'lessons', 'teachers'));
    }
}
