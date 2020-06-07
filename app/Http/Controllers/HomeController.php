<?php

namespace App\Http\Controllers;

use App\Employee, App\Event, App\Tool;

class HomeController extends Controller
{
    public function index()
    {
        $outTools = Tool::where('status', 0)->limit(5)->get();

        $inTools = Tool::where('status', 1)->limit(5)->get();

        $events = Event::orderBy('created_at', 'desc')->limit(5)->get();

        $employees = Employee::orderBy('created_at', 'desc')->limit(5)->get();

        return view('home', compact('outTools', 'inTools', 'events', 'employees'));
    }
}
