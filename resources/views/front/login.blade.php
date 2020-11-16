@extends('layouts.front')
@section('scripts')
	@parent
	<script type="text/javascript">
		var _data = {!! json_encode($data) !!};
		
		_methods.loginSubmit = function(scope) {
			var _this = this;
			var _login = _this.login;
			//var scope = 'frm-login';
			var _url = _login.vista === 'login' ? _login.url_post : _login.url_post_recuperar;
			var _form = _login.vista === 'login' ? _login.form : _login.formRecuperar;
			var _errorMsg = null;
			
			//console.debug('entraaa');
			_login.enviado = true;
			this.$validator.validateAll(scope).then(function() {
				
				_login.enviando = true;
				_this._call(_url,'POST',_form,true,_this.errors,scope).then(function(data) {
					console.debug(data);
					if (data.url_redirect) {
						document.location = data.url_redirect;
					} else {
						if (_login.vista === 'login') {
							location.reload();
						} else {
							// _this.toastOk('Hemos enviado los pasos a seguir a tu correo electrónico.');
							alert(data.message);
							_this.cambiarVista('login');
						}
					
					}
					_login.enviando = false;
				}, function(error) {
					if (error.status != 422) {
						//console.debug(error.data.message);
						alert(error.data.message);
					} else {
						if (error.data.errors.email) {
							alert(error.data.errors.email[0]);
						}
					}
				
					_login.enviando = false;
				});          
			
			}).catch(function(e) {
				console.debug(e.response);
				_login.enviando = false;
			});
		}
		
		_methods.cambiarVista = function (vista) {
			var _this = this;
			var _login = _this.login;


			_login.enviado = false;
			if (vista === 'login') {
			_login.formRecuperar.email = null;
			} else {
			_login.form.email = null;
			_login.form.password = null;
			}
			_login.vista = vista;

		};		

        this._mounted.push(function(_this) {
            console.debug(_this);
        });

        var loginPage = true;
	</script>
@endsection
@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection
@section('content')
	<div class="container" v-if="login.vista === 'login'">
		<form class="form-signin" v-on:submit.prevent="loginSubmit('frm-login')" data-vv-scope="frm-login">
			<h1 class="h1 mb-3 font-weight-normal">Bienvenido a Ruta365</h1>
			<h2 class="h2 mb-3 font-weight-normal">Completa tus datos para ingresar.</h2>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus v-model="login.form.email">
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required v-model="login.form.password">
			<div class="checkbox mb-3">
				<a href="javascript:void(0);" @click="cambiarVista('recuperar')" class="olvidaste-001">Olvidaste tus datos?</a>
			</div>
			<button class="btn btn-lg btn-001 btn-block" type="submit" :disabled="login.enviando"><span v-if="login.enviando"></span>Enviar datos</button>
			<a href="{{route('registro')}}" class="link-001" target="_self"><div class="btn btn-lg btn-002 btn-block">Si no estás registrado, haz click aquí.</div></a>
		</form>
	</div>
    <div v-else class="container">
		<form class="form-signin" v-on:submit.prevent="loginSubmit('frm-recuperar')" data-vv-scope="frm-recuperar">
			<h1 class="h1 mb-3 font-weight-normal">¿Olvidaste tus datos?</h1>
			<h2 class="h2 mb-3 font-weight-normal">Ingresa tu email y te enviaremos una nueva contraseña.</h2>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus v-model="login.formRecuperar.email">
			<button class="btn btn-lg btn-001 btn-block" type="submit" :disabled="login.enviando"><span v-if="login.enviando"></span>Enviar datos</button>
		</form>
	</div>	

@endsection