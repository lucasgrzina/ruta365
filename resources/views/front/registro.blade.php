@extends('layouts.front')
@section('scripts')
	@parent
	<script type="text/javascript">
		var _data = {!! json_encode($data) !!};

		_methods.registroSubmit = function() {
			var _this = this;
			var _registro = _this.registro;
			var scope = 'frm-registro';
			var _errorMsg = null;
			
			_registro.enviado = true;
			this.$validator.validateAll(scope).then(function() {
				
				_registro.enviando = true;
				_this._call(_registro.url_post,'POST',_registro.form,true,_this.errors,scope).then(function(data) {
					//location.reload();
					//alert('Muchas gracias por haberte registrado.\nValidaremos los datos y muy pronto te enviaremos un email para que puedas ingresar al sitio.');
					document.location = '{{route('registro.gracias')}}';
					_registro.enviando = false;
				}, function(error) {
					if (error.status != 422) {
						_this.toastError(error.message);
					} else {
						var mensaje = [];
						_.forEach(error.data.errors, function(msj,campo) {
							mensaje.push(msj);
						});

						alert(mensaje.join('\n\r'));
						/*error.data.errors. {
							alert(error.data.errors.email[0]);
						}*/
					}
					_registro.enviando = false;
				});          
			
			}).catch(function(e) {
			_registro.enviando = false;
			});
		};
		
		_methods.alCambiar = function(campo) {
			var _this = this;
			var _errorMsg = null;
			var _url = null;
			var _data = [];
			var _valorCampo = null;
			
			if (_this.registro.enviando) {
				return false;
			}
				
			_valorCampo = _this.registro.form[campo];

			if (campo === 'pais_id') {
				 
				_this.registro.form.retail_id = null;
				_this.registro.form.sucursal_id = null;

				_url = '{{route("combo.retails")}}';
				_data = {
					pais_id: _valorCampo
				};

				_this.$set(_this.registro.info,'retails',[]);
				_this.$set(_this.registro.info,'sucursales',[]);
			} else {
				_this.registro.form.sucursal_id = null;

				_url = '{{route("combo.sucursales")}}';
				_data = {
					retail_id: _valorCampo
				};

				_this.$set(_this.registro.info,'sucursales',[]);
			}

			if (_valorCampo) {
				_this.registro.enviando = true;
				_this._call(_url,'POST',_data).then(function(data) {
					console.debug(data);
					if (campo === 'pais_id') {
						_this.$set(_this.registro.info,'retails',data);
					} else {
						_this.$set(_this.registro.info,'sucursales',data);
					}
					_this.registro.enviando = false;
				}, function(error) {
					_this.registro.enviando = false;
				});          

			}
			
		};		

        this._mounted.push(function(_this) {
        });

        var registroPage = true;
	</script>
@endsection
@section('css')
<link href="{{ asset('css/registro.css') }}" rel="stylesheet">
@endsection
@section('content')

	  <div class="container">
		<form class="form-signin" v-on:submit.prevent="registroSubmit()" data-vv-scope="frm-registro">
		  <h1 class="h1 mb-3 font-weight-normal">¡Regístrate y participa!</h1>
		  <h2 class="h2 mb-3 font-weight-normal">Completa el formulario con tus datos.</h2>
		  <label for="nombre" class="sr-only">Nombre</label>
		  <input type="text" id="nombre" class="form-control" placeholder="Nombre" required autofocus v-model="registro.form.nombre">
		  <label for="apellido" class="sr-only">Apellido</label>
		  <input type="text" id="apellido" class="form-control" placeholder="Apellido" required v-model="registro.form.apellido">
		  <label for="inputEmail" class="sr-only">Email address</label>
		  <input type="email" id="inputEmail" class="form-control" placeholder="Email" required v-model="registro.form.email">
		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required v-model="registro.form.password">
		  <label for="pais" class="sr-only">País</label>
		  <select id="inputPais" class="form-control" v-model="registro.form.pais_id" @change="alCambiar('pais_id')">
			<option :value="null">País</option>
			<option v-for="item in registro.info.paises" :value="item.id">(% item.nombre %)</option>
		  </select>
		  <select id="inputRetail" class="form-control" v-model="registro.form.retail_id" @change="alCambiar('retail_id')">
			<option :value="null">Retail</option>
			<option v-for="item in registro.info.retails" :value="item.id">(% item.nombre %)</option>
		  </select>
		  <select id="inputSucursal" class="form-control" v-model="registro.form.sucursal_id">
			<option :value="null">Sucursal</option>
			<option v-for="item in registro.info.sucursales" :value="item.id">(% item.nombre %)</option>
		   </select>
		  <button class="btn btn-lg btn-001 btn-block" type="submit" :disabled="registro.enviando"><span v-if="registro.enviando"></span>Enviar datos</button>
		</form>
	  </div>

@endsection