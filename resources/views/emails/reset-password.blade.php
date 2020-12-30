@extends('emails.template')
@section('content')

    <h1 class="h1 mb-3 font-weight-normal" style="text-align: center;">Nueva contraseña</h1>
    <p class="p mb-3 font-weight-normal" style="text-align: center;">
        Hola {{$user->nombre}}, hemos generado una nueva contraseña para ti, {{$clave}}.<br>
        Una vez que ingreses a Ruta 365 puedes modificarla haciendo click en el botón Cambiar Contraseña, ubicado en el sector derecho de la botonera principal.<br><br>
        Muchas gracias.
    </p>

    <a href="{{route('home')}}" class="link-001" target="_self"><div class="btn btn-lg btn-002 btn-block">Ingresar en Ruta 365</div></a>
@endsection