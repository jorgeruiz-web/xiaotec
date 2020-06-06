<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\historial;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\excel_his;

class historial_control extends Controller
{
    public function cargar_historial()
    {
        $historial=historial::all();
        return view('ProyectoFinal/historial',["historial"=>$historial]);
    }
    public function borrar_historial()
    {
        historial::truncate();
        return redirect("/historial.php");
    }
    public function descargar_historial()
    {
        return Excel::download(new excel_his,"historial.xlsx");
    }
}
