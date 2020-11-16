@extends('layouts.front')
@php
	$sucursal = $data['registrado']->sucursal;
	$retail = $sucursal->retail;
	
@endphp
@section('scripts')
	@parent
    <script type="text/javascript">
		$("#navbars ul li a[href^='#']").on('click', function(e) {
  
			if ( $(this).hasClass("btn-cambiar-pass")) {
			console.log("Btn Cambiar Contraseña");
			} else if ( $(this).hasClass("btn-salir")) {
			console.log("Btn Salir");
			} else {
			// prevent default anchor click behavior
			e.preventDefault();
	
			// store hash
			var hash = this.hash;
	
			// animate
			$('html, body').animate({
				scrollTop: $(hash).offset().top
				}, 300, function(){
	
				// when done, add hash to url
				// (default click behaviour)
				window.location.hash = hash;
				});
			}
		});
	</script>    
  
	<script type="text/javascript">
		var _data = {!! json_encode($data) !!};
		
		_methods.cambiarPasswordSubmit = function() {
			var _this = this;
			var _registro = _this.cambiarPassword;
			var scope = 'frm-cc';
			var _errorMsg = null;
			
			if (_registro.enviando) {
				return false;
			}

			this.$validator.validateAll(scope).then(function() {
				
				_registro.enviando = true;
				_this._call(_registro.url_post,'POST',_registro.form).then(function(data) {
					//location.reload();
					alert(data.message);
					_registro.form.password = null;
					_registro.enviando = false;
					$('.close','#modalPassword').trigger('click');
				}, function(error) {
					if (error.status != 422) {
						_this.toastError(error.message);
					} else {
						var mensaje = [];
						_.forEach(error.data.errors, function(msj,campo) {
							mensaje.push(msj);
						});

						alert(mensaje.join('\n\r'));
					}
					_registro.enviando = false;
				});          
			
			}).catch(function(e) {
				_registro.enviando = false;
			});
		};	

		_methods.guardarContactoSubmit = function() {
			var _this = this;
			var _registro = _this.guardarContacto;
			var scope = 'frm-gc';
			var _errorMsg = null;
			
			if (_registro.enviando) {
				return false;
			}

			this.$validator.validateAll(scope).then(function() {
				
				_registro.enviando = true;
				_this._call(_registro.url_post,'POST',_registro.form).then(function(data) {
					//location.reload();
					alert('Gracias por dejar tu contacto');
					_registro.form.mensaje = null;
					_registro.enviando = false;
				}, function(error) {
					if (error.status != 422) {
						alert(error.message);
					} else {
						var mensaje = [];
						_.forEach(error.data.errors, function(msj,campo) {
							mensaje.push(msj);
						});

						alert(mensaje.join('\n\r'));
					}
					_registro.enviando = false;
				});          
			
			}).catch(function(e) {
				_registro.enviando = false;
			});
		};			

        this._mounted.push(function(_this) {
            console.debug(_this);
        });

        var loginPage = true;
	</script>
@endsection
@section('content')
  <div id="ranking" class="ranking">
	<h2>Ranking de posiciones</h2>

	<table class="table tablas-ruta mx-auto table-borderless">
	  <thead class="thead-ruta">
		<tr>
		  <th scope="col">Sucursal</th>
		  <th scope="col">Alcance mínimo de unidades</th>
		  <th scope="col">Target Attach</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <th scope="row">Sucursal 1</th>
		  <td></td>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Sucursal 2</th>
		  <td></td>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Sucursal 3</th>
		  <td></td>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Sucursal 4</th>
		  <td></td>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Sucursal 5</th>
		  <td></td>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Sucursal 6</th>
		  <td></td>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Sucursal 7</th>
		  <td></td>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Sucursal 8</th>
		  <td></td>
		  <td>350</td>
		</tr>
	  </tbody>
	</table>
  </div>


  <div id="ventas" class="ventas">
	<h2>Ventas</h2>

	<table class="table tablas-ruta mx-auto table-borderless">
	  <thead class="thead-ruta">
		<tr>
		  <th scope="col">Producto</th>
		  <th scope="col">Total</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <th scope="row">Producto 1</th>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Producto 2</th>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Producto 3</th>
		  <td>350</td>
		</tr>
		<tr>
		  <th scope="row">Producto 4</th>
		  <td>350</td>
		</tr>
	  </tbody>
	</table>
  </div>

  @if(isset($data['productos']) && $data['productos'])
  <div id="productos" class="productos">

	<h2>Productos</h2>

	<div class="row productos-int mx-auto">
		@foreach ($data['productos'] as $item)
			<div class="col-sm">
				<img src="{{$item->imagen_url}}" class="rounded mx-auto d-block" alt="{{$item->nombre}}">
				<p>{{$item->nombre}}</p>
			</div>
		@endforeach
	</div>
  </div>
  @endif
  


  	@if(isset($retail->premio) && $retail->premio)
		<div id="premios" class="vendedores">

			<div class="row vendedores-int mx-auto align-items-center">
				<div class="col-sm-6">
					<img src="{{$retail->premio->imagen_web_url}}" class="rounded d-block container-fluid" alt="Premio 01">
				</div>
				<div class="col-sm-6 text-left">
					{!! $retail->premio->descripcion !!}
				</div>
			</div>

		</div>
	@endif


	@if(isset($retail->mecanica) && $retail->mecanica)
	<div id="mecanica" class="mecanica">

		<h2>Mecánica</h2>
		{!! $retail->mecanica->cuerpo !!}
	</div>
	@endif

  <div id="contacto" class="contacto">

	<h2>Contacto</h2>

	<form class="form-signin" v-on:submit.prevent="guardarContactoSubmit('frm-gc')" data-vv-scope="frm-gc">
	  <p class="p mb-3 font-weight-normal">Haz tu consulta y nos pondremos en contacto contigo a la brevedad.</p>
	  <label for="inputConsulta" class="sr-only">Consulta</label>
	  <textarea id="inputConsulta" class="form-control" placeholder="Consulta" rows="5" cols="60" required v-model="guardarContacto.form.mensaje"></textarea>
	  
	  <button class="btn btn-lg btn-001" type="submit">Enviar</button>
	</form>
	
  </div>

  <!-- Modal Password -->
  <div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel"></h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <h2>Contraseña</h2>
		  <p>Ingresa una nueva contraseña.</p>
		  <form class="form-password" v-on:submit.prevent="cambiarPasswordSubmit('frm-cc')" data-vv-scope="frm-cc">
			<input type="password" id="inputContrasena" class="form-control" placeholder="Nueva contraseña" required v-model="cambiarPassword.form.password">
			
			<button class="btn btn-lg btn-002 btn-block" type="submit">Enviar datos</button>
		  </form>
		</div>
	  </div>
	</div>
  </div>	

@endsection
@section('css')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<style>
	.container .navbar-ruta {
		background-color: {{ Auth::user()->sucursal->retail->color_hexa }}!important;
	}
	.sucursal-header {
		color: {{ Auth::user()->sucursal->retail->color_hexa }}!important;
	}
</style>
@endsection