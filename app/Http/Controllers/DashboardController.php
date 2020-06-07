<?php

namespace App\Http\Controllers;

use App\Charts\ChartA, App\Charts\ChartB, App\Charts\ChartC;
use Illuminate\Http\Request;
use App\Event, App\Tool, App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReqMail;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mailUpdate(Request $request)
    {
        if ($request->ajax()) {
            $user = User::where('id', $request->user_id)->first();
            if ($user->get_mail) {
                $user->decrement('get_mail');
                return response()->json(['update' => $user->get_mail]);
            } else {
                $user->increment('get_mail');
                return response()->json(['update' => $user->get_mail]);
            }
        }
    }

    public function adminReq(Request $request)
    {
        if ($request->ajax()) {
            $requester = User::where('id', $request->user_id)->first()->toArray();
            foreach(User::where('admin', 1)->get()->pluck('email') as $userMail)
                Mail::to($userMail)->send(new AdminReqMail($requester));
            return response()->json();
        }
    }

    public function index()
    {
        Carbon::setLocale('es');
        $popularTools = null;
        $ioSem = null;
        $busyHours = null;
        $activeEmployees = null;
        $colors = collect(['#355fda', '#85c699', '#612992', '#f7288d', '#dfd613', '#46e928', '#FF6347', '#B22222', '#DAA520', '#FF4500', '#008B8B']);
        if (Event::first() && Tool::first()) {

            $events = Event::orderBy('created_at', 'desc')
                ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->get();

            if ($events->isNotEmpty()) {
                // === Herramientas más populares ===
                $toolIDs = array();
                foreach ($events as $event) {
                    $aux = $event->tools()->pluck('tool_id');
                    if ($aux) {
                        foreach ($aux as $auxx) {
                            if (array_key_exists($auxx, $toolIDs))
                                $toolIDs[$auxx] += 1;
                            else
                                $toolIDs[$auxx] = 1;
                        }
                        if (sizeof($toolIDs) >= 10)
                            break;
                    }
                }
                arsort($toolIDs);
                $popularTools = new ChartA;
                $popularTools->labels(array_keys($toolIDs));
                $popularTools->dataset('HerramientasPopulares', 'doughnut', array_values($toolIDs))
                    ->backgroundColor($colors->shuffle());

                // === Empleados más activos ===
                $employeesIDs = array();
                foreach ($events as $event) {
                    $aux = $event->pluck('employee_id');
                    if ($aux) {
                        if (array_key_exists($auxx, $employeesIDs))
                            $employeesIDs[$auxx] += 1;
                        else
                            $employeesIDs[$auxx] = 1;
                        if (sizeof($employeesIDs) >= 10)
                            break;
                    }
                }
                arsort($employeesIDs);
                $activeEmployees = new ChartA;
                $activeEmployees->labels(array_keys($employeesIDs));
                $activeEmployees->dataset('EmpleadosActivos', 'doughnut', array_values($employeesIDs))
                    ->backgroundColor($colors->shuffle());

                // === Numero de eventos promedio por hora ===
                $groups = $events->sortBy('created_at')->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('h');
                });
                $counts = array();
                foreach ($groups as $group) {
                    $counts[$group[0]->created_at->format('H') . 'h'] = $group->count();
                }
                $total = array_sum($counts);

                $busyHours = new ChartC;
                $busyHours->labels(array_keys($counts));
                $busyHours->dataset('Porcentaje', 'bar', array_values(array_map(
                    function ($val, $total) {
                        return round($val * 100 / $total, 2);
                    },
                    $counts,
                    array_fill(0, count($counts), $total)
                )))
                    ->backgroundColor($colors->shuffle());
            }

            // === Numero de eventos por día ===
            $days = range(13, 7);
            $week1 = array();
            foreach ($days as $day) {
                $dName = Carbon::today()->subDays($day)->getTranslatedShortDayName('dd');
                if ($dName != 'sáb.' && $dName != 'dom.')
                    $week1[$dName] = Event::orderBy('created_at', 'desc')
                        ->whereBetween('created_at', [Carbon::today()->subDays($day), Carbon::today()->subDays($day - 1)])
                        ->get()->count();
            }
            $days = range(6, 0);
            $week2 = array();
            foreach ($days as $day) {
                $dName = Carbon::today()->subDays($day)->getTranslatedShortDayName('dd');
                if ($dName != 'sáb.' && $dName != 'dom.')
                    $week2[] = Event::orderBy('created_at', 'desc')
                        ->whereBetween('created_at', [Carbon::today()->subDays($day), Carbon::today()->subDays($day - 1)])
                        ->get()->count();
            }

            $ioSem = new ChartB;
            $ioSem->labels(array_keys($week1));
            $ioSem->dataset('Semana en curso', 'line', array_values($week2))
                ->options([
                    'borderColor' => 'rgba(0, 0, 255, 0.5)',
                    'fill' => 'false',
                ]);
            $ioSem->dataset('Semanana pasada', 'line', array_values($week1))
                ->options([
                    'borderColor' => 'rgba(255,0, 0,  0.5)',
                    'fill' => 'false',
                ]);
        }
        return view('dashboard', compact('popularTools', 'ioSem', 'busyHours', 'activeEmployees'));
    }
}
