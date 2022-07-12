<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Carbon\Carbon;

class AuditoriaController extends Controller
{
    //

    static public function store($accion = null, $tabla = null, $tabla_id = null, $registro = null ){
        $auditoria              = new Auditoria;
        $auditoria->fecha_hora  = Carbon::now();
        $auditoria->accion      = $accion;
        $auditoria->tabla       = $tabla;
        $auditoria->tabla_id    = $tabla_id;
        $auditoria->registro    = $registro;
        $auditoria->save();
    }

    public function api(){
        $data = [];
        return Response::json($data, 200);
    }
}
