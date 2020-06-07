<?php

namespace App\Http\Controllers;

use App\EventTool;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;
use App\Tool;

class ToolController extends Controller
{

    public function create()
    {
        if (Auth::check()) {
            if (\App\Place::first())
                return view('tools.create');
            return view('places.create');
        } else {
            abort(403);
        }
    }

    public function store()
    {
        $data = request()->validate([
            'id' => 'unique:tools,id|required|alpha_num|size:5',
            'name' => 'string|required',
            'copy' => '',
            'type' => 'string|required',
            'image' => 'image',
        ]);

        // ¿Hay empleado fuera que pueda registrar la herramienta?
        $inORouts = \App\Event::selectRaw('inORout')
            ->whereIn('created_at', function ($query) {
                $query->selectRaw('MAX(created_at)')->from('events')->groupBy('employee_id')->get()->toArray();
            })
            ->get();
        if ($inORouts->isEmpty())
            // return back()->withErrors('your error message')->withInput();
            throw ValidationException::withMessages(['other' => 'No hay empleado fuera del almacen que pueda registrar la herramienta']);
        else {
            $inORouts->toArray();
            for ($i = 0; $i < count($inORouts); $i++) {
                if (!$inORouts[$i]['inORout'])
                    break;
                else if ($i == (count($inORouts) - 1))
                    throw ValidationException::withMessages(['other' => 'No hay empleado fuera del almacen que pueda registrar la herramienta']);
            }
        }

        $error = "";
        // ¿Hay otra herramienta esperando EPC?
        $waiting = Tool::where('epc', 'WAITING')->pluck('id')->first();
        if ($waiting) {
            $error = request('id');
            return view('loading', compact('waiting', 'error'))->with('type', 'tool');
        }

        // ¿Hay un empleado esperando EPC?
        $waiting = \App\Employee::where('epc', 'WAITING')->pluck('id')->first();
        if ($waiting) {
            $error = request('id');
            return view('loading', compact('waiting', 'error'))->with('type', 'employee');
        }

        if (request('image')) {
            $imagepath = request('image')->store('uploads');
            Image::make(request('image'))->resize(400, 400)->save(public_path("images/" . $imagepath));
            // Image::make(request('image'))->resize(400, 400)->save("/home4/desstecc/public_html/herramientas/images/" . $imagepath);
            // ->resize(400, 400, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // });
            $data['image'] = $imagepath;
        }

        // Determinar #copia
        $find = Tool::where('name', $data['name'])->orderBy('created_at', 'desc')->pluck('copy')->first();
        $data['copy'] = $find + 1;

        $data['epc'] = "WAITING";
        $waiting = Tool::create($data)->id;
        return view('loading', compact('waiting', 'error'))->with('type', 'tool');
    }

    public function show(Tool $tool)
    {
        return view('tools.show', compact('tool'));
    }

    public function showAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Tool::all();
            return DataTables::of($data)
                ->setRowAttr([
                    'href' => '/tool/{{ $id }}',
                ])
                ->make(true);
        }

        // $tools = Tool::orderBy('created_at', 'desc')->paginate(25);

        return view('tools.showAll');
    }

    public function edit(Tool $tool)
    {
        if (Auth::check()) {
            return view('tools.edit', compact('tool'));
        } else {
            abort(403);
        }
    }

    public function update(Tool $tool)
    {
        $data = request()->validate([
            'id' => 'required|alpha_num|size:5',
            'name' => 'string|required',
            'copy' => 'string|required',
            'type' => 'string|required',
            'image' => 'image|nullable',
        ]);

        if (request('image')) {
            $imagepath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("image/{$imagepath}"))->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                // $constraint->upsize();
            });
            $image->save();
            if ($tool->image != 'uploads/tool.jpeg') {
                unlink(public_path('image/' . $tool->image));
            }
        } else {
            $imagepath = $tool->image;
        }

        $tool->update(array_merge(
            $data,
            ['image' => $imagepath]
        ));

        return Redirect::to('/tool/' . $tool->id);
    }

    public function destroy($tool_id)
    {
        EventTool::where('tool_id', $tool_id)->delete();
        Tool::destroy($tool_id);

        return Redirect::to('/tools');
    }
}
