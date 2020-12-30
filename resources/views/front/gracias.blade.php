@extends('layouts.front')
@section('content')
<div class="container">
	<form class="form-signin">
	  <h1 class="h1 mb-3 font-weight-normal">{!! isset($data['gracias']) && isset($data['gracias']['titulo']) ? $data['gracias']['titulo'] : 'Bienvenido a Ruta365' !!}</h1>
	  <h2 class="h2 mb-3 font-weight-normal">{!! isset($data['gracias']) && isset($data['gracias']['subtitulo']) ? $data['gracias']['subtitulo'] : 'Completa tus datos para ingresar.' !!}</h2>
	</form>
</div>
@endsection
@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection