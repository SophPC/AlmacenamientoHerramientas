@component('mail::message')
# Alerta

Ha ocurrido un problema.

Los siguientes parámetros fueron especificados:
<div style="background-color:rgba(252, 7, 7, 0.45)">
    @foreach($alerta as $key => $param)
    @if($key != 'id')
    &emsp;<h4 style="display: inline">{{ $key }}:</h4><p style="display: inline">{{$param}}</p><br>
    @endif
    @endforeach
</div>
<br>
Para más información visite el link de la incidencia:
@component('mail::button', ['url' => $alerta['id']])
Incidencia
@endcomponent
Gracias,<br>
{{ config('app.name') }}
@endcomponent
