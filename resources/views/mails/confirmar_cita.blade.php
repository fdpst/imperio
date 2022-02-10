<pre>
<img src="{{Request::root()}}/logo.png" alt="LOGOTIPO" height="200">

<h1 style="text-transform: uppercase;"><strong>¡Hola!  </strong>{{$data['nombre_cliente']}}</h1>

<strong style="color: black;text-transform: uppercase;">Su cita para: </strong>
<strong style="color: orange;">{{$data['nombre_tienda']}}</strong> 
Ha sido creada correctamente

<strong style="color: black;text-transform: uppercase;">Fecha y hora:</strong>
<strong style="color: orange;">{{date("d/m/Y H:i:s", strtotime($data['start']))}}</strong>
<strong style="color: black;text-transform: uppercase;">Hasta</strong>
<strong style="color: orange;">{{date("d/m/Y H:i:s", strtotime($data['end']))}}</strong>

<strong style="color: black;">Sera atendido por : </strong>
<strong style="color: orange;text-transform: uppercase;">{{$data['nombre_empleado']}}</strong>

<strong style="color: black;text-transform: uppercase;">Servicios solicitados:</strong>

@foreach($data['servicios'] as $servicio)
    {{$servicio['nombre']}} <br>
@endforeach

Gracias!!!

Imperio Varón 
</pre>