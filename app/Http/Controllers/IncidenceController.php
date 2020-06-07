<?php

namespace App\Http\Controllers;

use App\Employee, App\User;
use App\Incidence;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertMail;

class IncidenceController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            $tools = \App\Tool::select('name', 'id', 'copy')->get()->toArray();
            $employees = Employee::select('id', 'name', 'last_name')->get()->toArray();
            $places = \App\Place::select('id', 'name')->get()->toArray();
            $events_ids = \App\Event::select('id')->get()->toArray();

            return view('incidences.create', compact('places', 'employees', 'tools', 'events_ids'));
        } else {
            abort(403);
        }
    }

    public function store()
    {
        dd(request()->request);
        $data = request()->validate([
            'MENSAJE' => 'required',
            'LUGAR' => 'exists:places,id|required|alpha_num|size:5',
            'EPCs' => 'nullable',
            'EPC' => 'nullable',
            "ID_DEL_EMPLEADO" => 'nullable|exists:employees,id|alpha_num|size:5|different:ID DEL EMPLEADO 2',
            "ID DEL EMPLEADO 2" => 'nullable|exists:employees,id|alpha_num|size:5|different:ID DEL EMPLEADO',
            'ID DEL ULTIMO EVENTO' => 'nullable|exists:events,id|numeric',
            'STATUS DEL EMPLEADO' => 'nullable|boolean',
            'ID DE LA HERRAMIENTA' => 'nullable|exists:tools,id|alpha_num|size:5',
            'STATUS DE LA HERRAMIENTA' => 'nullable|boolean',
        ]);

        $incidence_id = $this->microStore($data);
        $data['id'] = $incidence_id;
        foreach (User::where('get_mail', 1)->get()->pluck('email') as $userMail) {
            Mail::to($userMail)->send(new AlertMail($data));
        }

        return Redirect::to('/incidence/' . $incidence_id);
    }

    public static function microStore($alert)
    {
        if ($alert['MENSAJE']) {
            $create['message'] = $alert['MENSAJE'];
        }
        if ($alert['LUGAR']) {
            $create['place_id'] = $alert['LUGAR'];
        }
        if (array_key_exists('EPCs', $alert)) {
            $create['epcs'] = $alert['EPCs'];
        }
        if (array_key_exists('EPC', $alert)) {
            $create['epcs'] = $alert['EPC'];
        }
        if (array_key_exists('ID DEL EMPLEADO', $alert)) {
            $create['employee_id'] = $alert['ID DEL EMPLEADO'];
            Employee::where('id', $create['employee_id'])->increment('incidences');
        }
        if (array_key_exists('ID DEL EMPLEADO 2', $alert)) {
            $create['employee_id_2'] = $alert['ID DEL EMPLEADO 2'];
            Employee::where('id', $create['employee_id_2'])->increment('incidences');
        }
        if (array_key_exists('ID DEL ULTIMO EVENTO', $alert)) {
            $create['last_event_id'] = $alert['ID DEL ULTIMO EVENTO'];
        }
        if (array_key_exists('STATUS DEL EMPLEADO', $alert)) {
            $create['employee_status'] = $alert['STATUS DEL EMPLEADO'];
        }
        if (array_key_exists('ID DE LA HERRAMIENTA', $alert)) {
            $create['tool_id'] = $alert['ID DE LA HERRAMIENTA'];
        }
        if (array_key_exists('STATUS DE LA HERRAMIENTA', $alert)) {
            $create['tool_status'] = $alert['STATUS DE LA HERRAMIENTA'];
        }

        return Incidence::create($create)->id;
    }

    public function show(Incidence $incidence)
    {
        return view('incidences.show', compact('incidence'));
    }

    public function showAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Incidence::all();
            return DataTables::of($data)
                ->setRowAttr([
                    'href' => '/incidence/{{ $id }}',
                ])
                ->make(true);
        }
        return view('incidences.showAll');
    }
    

    public function edit(Incidence $incidence) // NOPE
    {
        if (Auth::check()) {
            return view('incidences.edit', compact('incidence'));
        } else {
            abort(403);
        }
    }

    public function update(Incidence $incidence)
    {
        $data = request()->validate([
            'employee_id' => 'exists:employees,id|required|alpha_num|size:5',
            'tool_id' => 'exists:tools,id|required|alpha_num|size:5',
            'place_id' => 'exists:places,id|required|alpha_num|size:5',
            'inORout' => 'boolean|required',
        ]);

        $incidence->update($data);

        return Redirect::to('/incidence/' . $incidence->id);
    }

    public function destroy($incidence_id)
    {
        $incidence = Incidence::where('id', $incidence_id)->first();
        if($incidence->employee_id){
            $employee = \App\Employee::where('id', $incidence->employee_id)->first();
            $employee->decrement('incidences');
        }
        if($incidence->employee_id_2){
            $employee = \App\Employee::where('id', $incidence->employee_id_2)->first();
            $employee->decrement('incidences');
        }
        Incidence::destroy($incidence_id);

        return Redirect::to('/incidences');
    }

}
