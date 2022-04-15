<?php

namespace App\Http\Controllers;

use App\Models\Classrom;
use App\Models\Employer_Schedule;
use App\Models\Lesson;
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
                        if(isset($_GET['eliminate']) && $_GET['eliminate'] == 'on'){
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
        return view('classroms', compact('classr','lessons'));
    }

    public function seeClassrom(){
        return view('classrom');
    }
}
