@component('mail::message')
# Solicitud

El usuario con los siguientes datos esta solicitando permisos de administrador:
<div style="background-color:lightgray">
    @foreach($user as $key => $param)
    @if($key != 'id')
    &emsp;<h4 style="display: inline">{{ $key }}:</h4>
    <p style="display: inline">{{$param}}</p><br>
    @endif
    @endforeach
</div>
<br>
@component('mail::button', ['url' => $user['id'], 'color' => 'green'])
Otorgar permisos de administrador
@endcomponent
@component('mail::button', ['url' => $user['id'], 'color' => 'red'])
Denegar permisos
@endcomponent
@component('mail::button', ['url' => $user['id']])
Ver usuario
@endcomponent
Gracias,<br>
{{ config('app.name') }}
@endcomponent