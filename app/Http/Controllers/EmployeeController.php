<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{

    public function create()
    {
        if (Auth::check()) {
            if (\App\Place::first())
                return view('employees.create');
            return view('places.create');
        } else {
            abort(403);
        }
    }

    public function store()
    {
        $data = request()->validate([
            'id' => 'unique:employees,id|required|alpha_num|size:5',
            'name' => 'string|required',
            'last_name' => 'string|required',
            'birthdate' => 'date|required',
            'department' => 'string|required',
            'image' => 'image',
        ]);

        $error = "";
        $waiting = \App\Tool::where('epc', 'WAITING')->pluck('id')->first();
        if ($waiting != "") {
            $error = request('id');
            return view('loading', compact('waiting', 'error'))->with('type', 'tool');
        }

        $waiting = Employee::where('epc', 'WAITING')->pluck('id')->first();
        if ($waiting != "") {
            $error = request('id');
            return view('loading', compact('waiting', 'error'))->with('type', 'employee');
        }

        if (request('image')) {
            $imagepath = request('image')->store('uploads');
            Image::make(request('image'))->resize(400, 400)->save(public_path("images/" . $imagepath));
            // Image::make(request('image'))->resize(400, 400)->save("/home4/desstecc/public_html/herramientas/images/" . $imagepath);
            $data['image'] = $imagepath;
        }

        $data['epc'] = "WAITING";
        $waiting = Employee::create($data)->id;
        return view('loading', compact('waiting', 'error'))->with('type', 'employee');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function showAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::all();
            return DataTables::of($data)
                ->setRowAttr([
                    'href' => '/employee/{{ $id }}',
                ])
                ->make(true);
        }
        return view('employees.showAll');
    }

    public function edit(Employee $employee)
    {
        if (Auth::check()) {
            return view('employees.edit', compact('employee'));
        } else {
            abort(403);
        }
    }

    public function update(Employee $employee)
    {
        $data = request()->validate([
            'id' => 'required|alpha_num|size:5',
            'name' => 'string|required',
            'last_name' => 'string|required',
            'birthdate' => 'date|required',
            'department' => 'string|required',
            'image' => 'image|nullable',
        ]);

        if (request('image')) {
            $imagepath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("img/{$imagepath}"))->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                // $constraint->upsize();
            });
            $image->save();
            if ($employee->image != 'uploads/employee.png') {
                unlink(public_path('img/' . $employee->image));
            }
        } else {
            $imagepath = $employee->image;
        }

        $employee->update(array_merge(
            $data,
            ['image' => $imagepath]
        ));

        return Redirect::to('/employee/' . $employee->id);
    }

    public function destroy($employee_id)
    {
        Employee::destroy($employee_id);

        return Redirect::to('/employees');
    }
}
