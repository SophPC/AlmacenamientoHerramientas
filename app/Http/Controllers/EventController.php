<?php

namespace App\Http\Controllers;

use App\Employee, App\Event, App\Tool, App\Place;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{

    public function create()
    {
        if (Auth::check()) {
            $tools = Tool::select('name', 'id', 'copy')->get()->toArray();
            $employees = Employee::select('id', 'name', 'last_name')->get()->toArray();
            $places = Place::select('id', 'name')->get()->toArray();

            return view('events.create', compact('tools', 'employees', 'places'));
        } else {
            abort(403);
        }
    }

    public function store()
    {
        $data = request()->validate([
            'employee_id' => 'exists:employees,id|required|alpha_num|size:5',
            'tool_id' => 'alpha_num|nullable',
            'place_id' => 'exists:places,id|required|alpha_num|size:5',
            'inORout' => 'boolean|nullable',
        ]);

        if (!(request('inORout'))) {
            $event = Event::where('employee_id', $data['employee_id'])->orderBy('created_at', 'desc')->first();
            if ($event && $event->inORout)
                $data['inORout'] = 0;
            else
                $data['inORout'] = 1;
        }

        if (request('tool_id')) {
            $tool = Tool::where('id', $data['tool_id'])->first();
            if ($tool->status)
                $tool->update(['status' => 0]);
            else
                $tool->update(['status' => 1]);

            $tools = $data['tool_id'];
            unset($data['tool_id']);
            $event = Event::create($data);
            $event->tools()->syncWithoutDetaching($tools); //Envia a tabla event_tool
        } else //No hay herramientas
            $event = Event::create($data);

        return Redirect::to('/event/' . $event->id);
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function showAll(Request $request)
    {
        /* ======================================= 
        No funciona la busqueda por herramientas
        ======================================= */
        if ($request->ajax()) {
            $data = Event::join('employees', 'events.employee_id', '=', 'employees.id')
                ->join('places', 'events.place_id', '=', 'places.id')
                ->selectRaw('`events`.`id`, `events`.`employee_id`, `events`.`place_id`, `events`.`inORout`, `events`.`created_at`, `employees`.`name` as `e_name`, `employees`.`id` as `e_id`, `employees`.`last_name` as `e_lname`, `places`.`name` as `p_name`, `places`.`id` as `p_id`, (select GROUP_CONCAT(`tool_id` SEPARATOR ", ") FROM `event_tool` WHERE `event_id` = `events`.`id` ) as `tools_ids`')
                ->where([
                    ['events.created_at', '>=', $request->min],
                    ['events.created_at', '<=', $request->max]
                ]);

            return DataTables::of($data)
                ->setRowAttr([
                    'href' => '/event/{{ $id }}',
                ])
                ->make(true);
        }

        if(Event::all()->isNotEmpty()){ //Para evitar errores
            $tools = Tool::select('name', 'id', 'copy')->get()->toArray();
            $employees = Employee::select('id', 'name', 'last_name')->get()->toArray();
            $places = Place::select('id', 'name')->get()->toArray();
            $dateFrom = Event::select('created_at')->orderBy('created_at', 'asc')->first()->toArray();

            return view('events.showAll', compact('tools', 'employees', 'places', 'dateFrom'));
        }
        
        return view('events.showAll');
    }

    public function edit(Event $event)
    {
        if (Auth::check()) {
            return view('events.edit', compact('event'));
        } else {
            abort(403);
        }
    }

    public function update(Event $event)
    {
        $data = request()->validate([
            'employee_id' => 'exists:employees,id|required|alpha_num|size:5',
            'tool_id' => 'exists:tools,id|required|alpha_num|size:5',
            'place_id' => 'exists:places,id|required|alpha_num|size:5',
            'inORout' => 'boolean|required',
        ]);

        $event->update($data);

        return Redirect::to('/event/' . $event->id);
    }

    public function destroy($event_id)
    {
        Event::destroy($event_id);

        return Redirect::to('/events');
    }
}
