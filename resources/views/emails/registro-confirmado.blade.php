@extends('emails.template')
@section('content')

    <h1 class="h1 mb-3 font-weight-normal" style="text-align: center;">¡Felicitaciones, tu cuenta ya está activada!</h1>
    <p class="p mb-3 font-weight-normal" style="text-align: center;">Hola {{$registrado->nombre}}, muchas gracias por haberte registrado.<br>
      Ya está todo listo para que puedas ingresar en Ruta 365.<br>
      Haz click en el siguiente botón.<br>
      ¡Muchas gracias!</p>

    <a href="{{route('home')}}" class="link-001" target="_self"><div class="btn btn-lg btn-002 btn-block">Ingresar en Ruta 365</div></a>
@endsection