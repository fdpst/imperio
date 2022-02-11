<pre>
<img src="{{Request::root()}}/logo.png" alt="LOGOTIPO" height="200">

<h1 style="text-transform: uppercase;"><strong>Hola!</h1>

<h2 style="text-transform: uppercase;"><strong style="color: black;text-transform: uppercase;"></strong>El cliente : {{$data['nombre_cliente']}}</strong></h2>

<strong style="color: black;text-transform: uppercase;">Ha reservado cita para: </strong>
<strong style="color: orange;">{{$data['nombre_tienda']}}</strong> 

<strong style="color: black;text-transform: uppercase;">Fecha y hora:</strong>
<strong style="color: orange;">{{date("d/m/Y H:i:s", strtotime($data['start']))}}</strong>
<strong style="color: black;text-transform: uppercase;">Hasta</strong>
<strong style="color: orange;">{{date("d/m/Y H:i:s", strtotime($data['end']))}}</strong>

<strong style="color: black;">Sera atendido por : </strong>
<strong style="color: orange;text-transform: uppercase;">{{$data['nombre_empleado']}}</strong>

<strong style="color: black;text-transform: uppercase;">Servicios solicitados:</strong>

@foreach($data['servicios'] as $servicio)
    {{$servicio['nombre']}}<br>
@endforeach
</pre>