<?php

namespace App\Http\Controllers;

use App\Employee, App\Tool;
use Illuminate\Http\Request;

class MicroController extends Controller
{
    public function lectura(Request $request)
    {
        event(new \App\Events\LecturaMicroEvent($request));

        return "OK"; 
    }

    public function loading(Request $request)
    {
        if ($request->ajax()) {
            $waiting = Tool::where('id', $request->id)->pluck('epc')->first();
            if ($waiting) {
                return response()->json(['success' => $waiting]);
            }

            $waiting = Employee::where('id', $request->id)->pluck('epc')->first();
            if ($waiting) {
                return response()->json(['success' => $waiting]);
            }

            // Imposible llegar a esto
            return response()->json(['error' => 'No hay herramienta ni empleado esperando a ser escaneados']);
        }
    }
}
