<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Csv_file;
use App\Models\Daily_assistance;
use App\Models\Employer;
use App\Models\Fortnight;
use App\Models\Quincenal_assistance;

class AddFileController extends Controller
{
    public function import_data_file(Request $request)
    {
        $cg = Configuration::latest()->first();
        $files = $request->file('csv');
        if (intval(date("d")) >= 15) {
            $idate = "01-" . date("m") . "-" . date("Y");
        } else {
            $m = date('m', strtotime('-1 month'));
            $y = date("Y");
            if (intval($m) == 1) $y = date('Y', strtotime('-1 year'));
            $idate = date("d-m-Y", strtotime("15-" . $m . "-" . $y));
        }
        $idate = date('Y-m-d', strtotime($idate));

        if (($gestor = fopen($files->path(), "r")) !== FALSE) {
            $x = 0;
            while (($datos = fgetcsv($gestor, 0, ",")) !== FALSE) {
                if ($x > 0) {
                    $datos =  $datos; //added

                    $temp = new Csv_file();
                    $temp->id_employer = (int)$datos[0];
                    $temp->name = $datos[3];
                    $nd = str_replace('/', '-', $datos[5]);
                    $temp->date = date("Y-m-d", strtotime($nd)); //date
                    $temp->onDuty = $datos[7]; //time
                    $temp->offDuty = $datos[8]; //time
                    $temp->clockIn = $datos[9]; //time
                    $temp->clockOut = $datos[10]; //time
                    $temp->late = $datos[13]; //time
                    $temp->early = $datos[14]; //time

                    if (strtolower($datos[15]) == "true")
                        $temp->absent = boolval(1); //boolean
                    else
                        $temp->absent = boolval(0); //boolean

                    $temp->workTime = $datos[17]; //time

                    if (strtolower($datos[19]) == "true")
                        $temp->must_c_in = boolval(1); //boolean
                    else
                        $temp->must_c_in = boolval(0); //boolean

                    if (strtolower($datos[20]) == "true")
                        $temp->must_c_out = boolval(1); //boolean
                    else
                        $temp->must_c_out = boolval(0); //boolean

                    //Si el empleado no se ha añadido a la BD se añade automaticamente
                    $t = Employer::select('id')->where('id', $temp->id_employer)->first();
                    if (!$t) {
                        $e = new Employer();
                        $e->id = $temp->id_employer;
                        $e->name = $temp->name;
                        $e->job = $datos[6];
                        $e->department = $datos[21];
                        $e->salary = 0;
                        $e->save();
                        unset($e);

                        //se crea una quincena en 0 para el empleado
                        $collection = Fortnight::where('date', $idate)->first();
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
                    $y = date("Y", strtotime($temp->date));
                    $d = date('d', strtotime($temp->date));
                    if (intval($d) >= 15) $d = "15";
                    else $d = "01";
                    $date_c = date("Y-m-d", strtotime($y . '-' . $m . '-' . $d));
                    $q = Fortnight::select('id', 'date')->where('date', $date_c)->first();
                    if (!$q) {
                        unset($q);
                        $q = new Fortnight();
                        $q->date = $date_c;
                        $q->save();
                    }
                    //creamos fila de asistencia quincenal en caso de que no exista
                    $qa = Quincenal_assistance::select('id_employer', 'id_fortnight')->where('id_employer', $temp->id_employer)->where('id_fortnight', $q->id)->first();
                    if (!$qa) {
                        unset($qa);
                        $qa = new Quincenal_assistance();
                        $qa->id_employer = $temp->id_employer;
                        $qa->id_fortnight = $q->id;
                        $qa->delays = 0;
                        $qa->absences = 0;
                        $qa->save();
                    }
                    //creamos asistencia del dia para el empleado
                    $da = Daily_assistance::where('date', $temp->date)->where('id_employer',$temp->id_employer)->first();
                    if (!$da) {
                        unset($da);
                        $da = new Daily_assistance();
                        $da->id_employer = $temp->id_employer;
                        $da->date = $temp->date;
                        $da->entrance = $temp->clockIn;
                        $da->out = $temp->clockOut;
                        $da->status = "asistance";
                        $da->id_fortnight = $q->id;
                        if ($temp->must_c_in == true) {
                            if ($temp->absent) $da->status = "absent";
                            elseif ($temp->late > $cg->delay) $da->status = "delay";
                        }

                        $da->save();
                    }
                    //$temp->save();
                    unset($temp);
                }
                $x++;
                if ($datos[0] == "") {
                    break;
                }
            }
            return redirect()->action([HomeController::class, 'index']);
        }
    }
}
