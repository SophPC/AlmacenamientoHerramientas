<?php

namespace App\Listeners;

use App\Providers\LecturaMicroEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Employee, App\Event, App\Tool, App\Place, App\User;
use App\Http\Controllers\IncidenceController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertMail;

class ProcesamientoMicroListener implements ShouldQueue
{
    // /**
    //  * Create the event listener.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     //
    // }

    protected function alerta($alerta)
    {
        $alerta['id'] = url('/incidence', IncidenceController::microStore($alerta));
        foreach (User::where('get_mail', 1)->get()->pluck('email') as $userMail) {
            Mail::to($userMail)->send(new AlertMail($alerta));
        }
    }

    /**
     * Handle the event.
     *
     * @param  LecturaMicroEvent  $event
     * @return void
     */
    public function handle(\App\Events\LecturaMicroEvent $eventX)
    {

        // === Verificando la existencia del LUGAR ===
        if (Place::where('id', $eventX->lugar)->get()->isEmpty())
            return $this->alerta([
                'MENSAJE' => "No existe el lugar",
                'LUGAR' => $eventX->lugar,
            ]);

        $EPCs = explode(",", substr($eventX->EPCs, 0, -1));

        // ===========================
        // === Alta de herramienta ===
        // ===========================
        $aux = Tool::where('epc', 'WAITING')->first(); //And only
        if ($aux) {
            if (count($EPCs) == 2) {
                for ($i = 0; $i < 2; $i++) {
                    $employee = Employee::where('epc', $EPCs[$i])->first();
                    if ($employee)
                        break;
                }
            } else {
                return $this->alerta([
                    'MENSAJE' => "Más de dos EPCs (empleado y herramienta) en alta de herramienta",
                    'LUGAR' => $eventX->lugar,
                    'EPCs' => implode(", ", $EPCs)
                ]);
            }

            $event = Event::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->first();
            if ($event->inORout)
                return $this->alerta([
                    'MENSAJE' => "El ultimo evento del empleado antes del alta de herramienta fue entrada",
                    'LUGAR' => $eventX->lugar,
                    'ID_EMPLEADO' => $employee->id,
                    'ID_ULTIMO_EVENTO' => $event->id,
                ]);

            $event = Event::create([
                'employee_id' => $employee->id,
                'place_id' => $eventX->lugar,
                'inORout' => 1,
            ]);
            if ($aux->status)
                $aux->update(['status' => 0, 'epc' => $EPCs[$i ^= 1]]);
            else
                $aux->update(['status' => 1, 'epc' => $EPCs[$i ^= 1]]);
            $event->tools()->syncWithoutDetaching($aux->id);
            // return "Alta Herramienta: " . $aux->id . "\nOK";
            return 1;
        }

        // ========================
        // === Alta de empleado ===
        // ========================
        $aux = Employee::where('epc', 'WAITING')->first();
        if ($aux) {
            if (count($EPCs) > 1)
                return $this->alerta([
                    'MENSAJE' => "Más de una EPC en alta de empleado",
                    'LUGAR' => $eventX->lugar,
                    'EPCs' => implode(", ", $EPCs)
                ]);
            $event = Event::create([
                'employee_id' => $aux->id,
                'place_id' => $eventX->lugar,
                'inORout' => 1,
            ]);

            $aux->update(['epc' => $EPCs[0]]);
            return 1;
        }

        // ====================
        // === Nuevo Evento ===
        // ====================
        $employee = "";
        $tools = array();
        $status = array();
        $count = count($EPCs);

        for ($i = 0; $i < $count; $i++) {
            $aux = Employee::where('epc', $EPCs[$i])->first();
            if ($aux) { // Es empleado
                if (!$employee){ // No se ha leido a ningun empleado
                    $employee = $aux->id;
                    $inORout = Event::where('employee_id', $employee)->orderBy('created_at', 'desc')->pluck('inORout')->first();
                    continue;
                }
                else
                    return $this->alerta([
                        'MENSAJE' => "Se leyo a mas de un empleado durante un evento",
                        'LUGAR' => $eventX->lugar,
                        'ID_EMPLEADO' => $employee,
                        'ID_EMPLEADO_2' => $aux->id
                    ]);
            }
            else{ // Es herramienta
                $tool = Tool::where('epc', $EPCs[$i])->first();
                if ($tool) {
                    $status[] = $tool->status;
                    $tools[] = $tool->id;
                } else { // No existe herramienta con esa EPC
                    if (!$employee) // Todavía no se leía un empleado
                        return $this->alerta([
                            'MENSAJE' => "No existe la EPC en la base de datos",
                            'LUGAR' => $eventX->lugar,
                            'EPC' => $EPCs[$i]
                        ]);
                    return $this->alerta([
                        'MENSAJE' => "No existe la EPC de la herramienta en la base de datos",
                        'LUGAR' => $eventX->lugar,
                        'ID_EMPLEADO' => $employee,
                        'EPC' => $EPCs[$i]
                    ]);
                }
            }
            if ($i == ($count - 1) && !$employee) // Ultima EPC se leyó y no hay empleado
                return $this->alerta([
                    'MENSAJE' => "No hay empleado en el evento",
                    'LUGAR' => $eventX->lugar,
                    'EPCs' => implode(", ", $EPCs)
                ]);
        }

        if ($count > 1) { // Evento con herramientas
            // Incongruencia en entradas y salidas de la herramienta
            $i = 0;
            foreach ($status as $stat) {
                if ($stat xor $inORout) // Si no son iguales
                    return $this->alerta([
                        'MENSAJE' => "Incongruencia en entradas y salidas de la herramienta",
                        'LUGAR' => $eventX->lugar,
                        'ID_EMPLEADO' => $employee,
                        'STATUS_EMPLEADO' => $inORout,
                        'ID_HERRAMIENTA' => $tools[$i],
                        'STATUS_HERRAMIENTA' => $stat
                    ]);
                $i++;
            }

            // Actualización status de herramientas
            foreach ($tools as $toolID) {
                $tool = Tool::where('id', $toolID)->first();
                if ($tool->status) //El anterior fue 1 (entrada)
                    $tool->update(['status' => 0]);
                else //El anterior fue 0 (salida)
                    $tool->update(['status' => 1]);
            }
        }
        
        $event = Event::create([
            'place_id' => $eventX->lugar,
            'employee_id' => $employee,
            'inORout' => !$inORout,
            ]);
            
        if (isset($tools)) //Evento con herramientas
            $event->tools()->syncWithoutDetaching($tools);

        return 1;
    }
}
