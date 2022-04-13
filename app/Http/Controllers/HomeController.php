<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Csv_file;
use App\Models\Daily_assistance;
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
        //si el dia es 1 o 15 se crea una nueva fila de quincena
        $today = (int)date('d');
        if($today == 15 || $today == 1){
            $insert_f = Fortnight::insert([
                'date' => date('Y-m-d')
            ]);
        }

        $q = Fortnight::select('id','date')->orderByDesc('date')->get();
        //si encuentra un filtro mandado por get
        if(isset($_GET["q_date"])){
            $f_id = intval($_GET["q_date"]);
            $date = Fortnight::select('date')->where('id',$f_id)->first();
            $date = $date->date;
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
            $d = fortnight::select("id")->where('date', date('Y-m-d',strtotime($idate)))->first();
            $f_id = $d->id;
        }
        //dates in format sql
        $b_idate = date('Y-m-d',strtotime($idate));
        $b_edate = date('Y-m-d',strtotime($edate));
        
        //si hay una busqueda
        if (isset($_GET["search"])) {
            $search = strval($_GET["search"]);
            $employers = Employer::select('employers.id AS id','employers.name AS name', 'asistance.delays AS delays', 'asistance.absences AS absences')
            ->join('quincenal_assistances as asistance','employers.id', '=', 'asistance.id_employer')
            ->join('fortnights as f', 'f.id', '=', 'asistance.id_fortnight')
            ->whereBetween('f.date', [$b_idate, $b_edate])
            ->where('employers.name','LIKE',"%$search%" )
            ->where('f.id', $f_id)
            ->orwhere('employers.id', '=', intval($search))
            ->whereBetween('f.date', [$b_idate, $b_edate])
            ->where('f.id', $f_id)
            ->orderBy('name')
            ->get();
        }else{
            $employers = Employer::select('employers.id AS id','employers.name AS name', 'asistance.delays AS delays', 'asistance.absences AS absences')
            ->join('quincenal_assistances as asistance','employers.id', '=', 'asistance.id_employer')
            ->join('fortnights as f', 'f.id', '=', 'asistance.id_fortnight')
            ->where('f.id', $f_id)
            ->whereBetween('f.date', [$b_idate, $b_edate])
            ->orderBy('name')
            ->get();
        }
        return view('home', compact('employers',"idate","edate","q"));
    }

    
    public function import_data_file(Request $request)
    {
        $c = Configuration::whereId('id')->first();
        $files = $request->file('csv');
        if(intval(date("d")) >= 15){
            $idate = "01-".date("m")."-".date("Y");
        }
        else {
            $m = date('m', strtotime('-1 month'));
            $y = date("Y");
            if(intval($m) == 1) $y = date('Y', strtotime('-1 year'));
            $idate = date("d-m-Y",strtotime("15-".$m."-".$y));
        }
        $idate = date('Y-m-d',strtotime($idate));

        if (($gestor = fopen($files->path(), "r")) !== FALSE)
		{
            $x = 0;
	   		while (($datos = fgetcsv($gestor, 0, ",")) !== FALSE)
	   		{
                if($x > 0){
                    $datos =  $datos; //added

                    $temp = new Csv_file();
                    $temp->id_employer = (int)$datos[0];
                    $temp->name = $datos[3];
                    $temp->date = date("Y-m-d",strtotime($datos[5])); //date
                    $temp->onDuty = $datos[7]; //time
                    $temp->offDuty = $datos[8]; //time
                    $temp->clockIn = $datos[9]; //time
                    $temp->clockOut = $datos[10]; //time
                    $temp->late = $datos[13]; //time
                    $temp->early = $datos[14]; //time

                    if(strtolower($datos[15]) == "true")
                        $temp->absent =boolval(1); //boolean
                    else
                        $temp->absent = boolval(0); //boolean

                    $temp->workTime = $datos[17]; //time

                    if(strtolower($datos[19]) == "true")
                        $temp->must_c_in =boolval(1); //boolean
                    else
                        $temp->must_c_in = boolval(0); //boolean
                        
                    if(strtolower($datos[20]) == "true")
                        $temp->must_c_out =boolval(1); //boolean
                    else
                        $temp->must_c_out = boolval(0); //boolean
                    
                    //Si el empleado no se ha añadido a la BD se añade automaticamente
                    $t = Employer::select('id')->where('id', $temp->id_employer)->first();
                    if(!$t){
                        $e = new Employer();
                        $e->id = $temp->id_employer;
                        $e->name = $temp->name;
                        $e->job = "";
                        $e->department = $datos[21];
                        $e->salary = 0;
                        $e->save();
                        unset($e);

                        //se crea una quincena en 0 para el empleado
                        $collection = Fortnight::where('date',$idate)->first();
                        $id_f = $collection->id;

                        $a = new Quincenal_assistance();
                        $a->id_employer = $temp->id_employer;
                        $a->id_fortnight = $id_f;
                        $a->delays = 0;
                        $a->absences = 0;
                        $a->save();
                        unset($a);
                    }

                    //se añade la quincena
                    $m = date('m', strtotime($temp->date));
                    $y = date("Y",strtotime($temp->date));
                    $d = date('d',strtotime($temp->date));
                    if(intval($d) >= 15) $d = "15";
                    else $d = "01";
                    $date_c = date("Y-m-d", strtotime($y.'-'.$m.'-'.$d));
                    $q = Fortnight::select('id', 'date')->where('date',$date_c)->first();
                    if(!$q){
                        unset($q);
                        $q = new Fortnight();
                        $q->date = $date_c;
                        $q->save();
                    }
                    //creamos fila de asistencia quincenal en caso de que no exista
                    $qa = Quincenal_assistance::select('id_employer', 'id_fortnight')->where('id_employer', $temp->id_employer)->where('id_fortnight', $q->id)->first();
                    if(!$qa){
                        unset($qa);
                        $qa = new Quincenal_assistance();
                        $qa->id_employer = $temp->id_employer;
                        $qa->id_fortnight = $q->id;
                        $qa->delays = 0;
                        $qa->absences = 0;
                        $qa->save();
                    }
                     //creamos asistencia del dia para el empleado
                    $da = Daily_assistance::where('date', $temp->date)->first();
                    if(!$da){
                        unset($da);
                        $da = new Daily_assistance();
                        $da->id_employer = $temp->id_employer;
                        $da->date = $temp->date;
                        $da->entrance = $temp->clockIn;
                        $da->out = $temp->clockOut;
                        $da->status = "good";
                        $da->save();
                    }
                    //$temp->save();
                }
                $x++;
                if($datos[0]==""){break;}
            }
            return redirect()->action([HomeController::class, 'index']);
        }
    }
}
