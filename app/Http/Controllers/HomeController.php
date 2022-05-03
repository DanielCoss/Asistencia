<?php

namespace App\Http\Controllers;

use App\Models\Daily_assistance;
use App\Models\Employer;
use App\Models\Fortnight;
use App\Models\Quincenal_assistance;

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
        if ($today == 15 || $today == 1) {
            if (!Fortnight::where('date', date('Y-m-d'))) {
                $insert_f = new Fortnight();
                $insert_f->date = date('Y-m-d');
                $insert_f->save();
                unset($insert_f);
            }
        }

        $q = Fortnight::select('id', 'date')->orderByDesc('date')->get();
        //si encuentra un filtro mandado por get
        if (isset($_GET["q_date"])) {
            $f_id = intval($_GET["q_date"]);
            $date = Fortnight::select('date')->where('id', $f_id)->first();
            $date = $date->date;
            $idate = date("d-m-Y", strtotime($date));
            $date_int = strtotime($date);
            $m = date("m", $date_int);
            $y = date("Y", $date_int);
            if (intval(date("d")) >= 15) {
                $d = date('t', $m);
                $date = $y . '-' . $m . '-' . $d;
                $edate = date("d-m-Y", strtotime($date));
            } else {
                $edate = date("d-m-Y", strtotime("15" . "-" . $m . "-" . $y));
            }
        } else {
            if (intval(date("d")) >= 15) {
                $idate = "01-" . date("m") . "-" . date("Y");
                $edate = "15-" . date("m") . "-" . date("Y");
            } else {
                $m = date('m', strtotime('-1 month'));
                $y = date("Y");
                if (intval($m) == 1) $y = date('Y', strtotime('-1 year'));
                $idate = date("d-m-Y", strtotime("15-" . $m . "-" . $y));
                $edate = date("d-m-Y", strtotime(date("t", date("m")) . "-" . $m . "-" . $y));
            }
            $d = fortnight::select("id")->where('date', date('Y-m-d', strtotime($idate)))->first();
            if (!$d) {
                $insert_f = new Fortnight();
                if ((int)date("d") >= 15)
                    $day = '15';
                else
                    $day = '1';
                $insert_f->date = date('Y-m-' . $day);
                $insert_f->save();
                $f_id = $insert_f->id; 
            } else $f_id = $d->id;
        }

        $emps = Employer::all();
        foreach ($emps as $emp) {
            $da = Daily_assistance::where('id_employer', $emp->id)
                ->where('id_fortnight', $f_id)
                ->where('status', "absent")
                ->get();
            $dd = Daily_assistance::where('id_employer', $emp->id)
                ->where('id_fortnight', $f_id)
                ->where('status', "delay")
                ->get();
            $qedit = Quincenal_assistance::where('id_employer', $emp->id)
                ->where('id_fortnight', $f_id)
                ->first();
            $band = 0;
            if ($dd->count() > 0) {
                $qedit->delays = $dd->count();
                $band = 1;
            }
            if ($da->count() > 0) {
                $qedit->absences = $da->count();
                $band = 1;
            }
            if ($band) $qedit->save();
        }

        //dates in format sql
        $b_idate = date('Y-m-d', strtotime($idate));
        $b_edate = date('Y-m-d', strtotime($edate));

        //si hay una busqueda
        if (isset($_GET["search"])) {
            $search = strval($_GET["search"]);
            $employers = Employer::select('employers.id AS id', 'employers.name AS name', 'asistance.delays AS delays', 'asistance.absences AS absences')
                ->join('quincenal_assistances as asistance', 'employers.id', '=', 'asistance.id_employer')
                ->join('fortnights as f', 'f.id', '=', 'asistance.id_fortnight')
                ->whereBetween('f.date', [$b_idate, $b_edate])
                ->where('employers.name', 'LIKE', "%$search%")
                ->where('f.id', $f_id)
                ->orwhere('employers.id', '=', intval($search))
                ->whereBetween('f.date', [$b_idate, $b_edate])
                ->where('f.id', $f_id)
                ->orderBy('name')
                ->get();
        } else {
            $employers = Employer::select('employers.id AS id', 'employers.name AS name', 'asistance.delays AS delays', 'asistance.absences AS absences')
                ->join('quincenal_assistances as asistance', 'employers.id', '=', 'asistance.id_employer')
                ->join('fortnights as f', 'f.id', '=', 'asistance.id_fortnight')
                ->where('f.id', $f_id)
                ->whereBetween('f.date', [$b_idate, $b_edate])
                ->orderBy('name')
                ->get();
        }
        return view('home', compact('employers', "idate", "edate", "q"));
    }
}
