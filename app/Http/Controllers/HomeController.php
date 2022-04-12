<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Fortnight;
use App\Models\Quincenal_assistance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $q = Fortnight::all();
        if(isset($_GET["q_date"])){
            $date = $_GET["q_date"];
            $idate = date("d-m-Y",strtotime($date));
            $date_int = strtotime($date);
            $m = date("m", $date_int);
            $y = date("Y", $date_int); 
            if(intval(date("d")) >= 15){
                $d = date('t',$m);
                $date = $y.'-'.$m.'-'.$d;
                $edate = date("d-m-Y", strtotime($date));
            }
            else{
                $edate = date("d-m-Y",strtotime("15"."-".$m."-".$y));
            }
        }else{
            if(intval(date("d")) >= 15){
                $idate = "01-".date("m")."-".date("Y");
                $edate = "15-".date("m")."-".date("Y"); 
            }
            else {
                $m = date('m', strtotime('-1 month'));
                $y = date("Y");
                if(intval($m) == 1) $y = date('Y', strtotime('-1 year'));
                $idate = date("d-m-Y",strtotime("15-".$m."-".$y));
                $edate = date("d-m-Y",strtotime(date("t",date("m"))."-".$m."-".$y));
            }
            //dates in format sql
            $b_idate = date('Y-m-d',strtotime($idate));
            $b_edate = date('Y-m-d',strtotime($edate));
        }
        if (isset($_GET["search"])) {
            $search = strval($_GET["search"]);
            $employers = Employer::select('employers.id AS id','employers.name AS name', 'asistance.delays AS delays', 'asistance.absences AS absences')
            ->join('quincenal_assistances as asistance','employers.id', '=', 'asistance.id_employer')
            ->where('employers.name','LIKE',"%$search%")
            ->orderBy('name')
            ->get();
        }else{
            $employers = Employer::select('employers.id AS id','employers.name AS name', 'asistance.delays AS delays', 'asistance.absences AS absences')
            ->join('quincenal_assistances as asistance','employers.id', '=', 'asistance.id_employer')
            ->orderBy('name')
            ->get();
        }
        return view('home', compact('employers',"idate","edate","q"));
    }

    public function indexPost(Request $request){
        $request->post();
        return view('home');
    }

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
            $d = Employer::insert([
                'id' => $id,
                'name' => $name,
                'job' => $job,
                'department' => $department,
                'salary' => $salary
            ]);

            $month = date('m');
            $month = intval($month);
            $year = date('Y');
            $year = intval($year);

            if(date("d") > 15) $control = 'b';
            else $control = 'a';

            $collection = Fortnight::latest()->orderByDesc("date")->first();
            $id_f = $collection->id;

            $e = Quincenal_assistance::insert([
                'id_employer' => $id,
                'id_fortnigh' => $id_f,
                'delays' => 0,
                'absences' => 0
            ]);
            $status = 1;
        }
        return redirect()->action([HomeController::class, 'index']);
    }

}
