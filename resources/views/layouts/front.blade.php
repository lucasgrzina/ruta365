<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Microsoft Ruta365</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css?1') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    @yield('css')  
    <script type="text/javascript">
      var _csrfToken = '{!! csrf_token() !!}';
      var _methods = {};
      var _components = {};
      var _dictionary = {
        es: {
          messages: {
            _default: 'El campo no es válido.',
            required: 'El campo es obligatorio.',
            email: 'El campo debe ser un correo electrónico válido.',
            regex: 'El formato ingresado es incorrecto'
          },
          custom: {
            password: {
              confirmed: 'Las contraseñas ingresadas no coinciden',
            }
          }    
        }
      };
      var _generalData = {
          alert: {
              show: false,
              type: '',
              title: '',
              message: ''
          },
          lang: {!! json_encode( trans('admin') ) !!},
          usuario: {!! \Auth::check() ? json_encode(array_only(\Auth::user()->toArray(),['nombre','apellido','id'])) : 'null' !!},
      };
      var _mounted = [];            
</script>        
  </head>
  <body class="text-center">
    <div id="app" style="display: contents;">
      
      @if(Auth::guest() || !config('constantes.homeActiva'))
        <!-- HEADER -->
        @include('../front/includes/header')
        <!--END MAIN HEADER-->

        @yield('content')                      

        <!-- FOOTER -->
        @include('../front/includes/footer')
        <!--END FOOTER-->
      @else
        <div class="container-fluid">
          <!-- HEADER -->
          @include('../front/includes/header')
          <!--END MAIN HEADER-->

          @yield('content')                      

          <!-- FOOTER -->
          @include('../front/includes/footer')
          <!--END FOOTER-->          
        </div>
      @endif
    </div>
    <script>window.jQuery || document.write('<script src="js/jquery-3.5.1.min.js"><\/script>')</script>
    <script src="js/bootstrap.bundle.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/vue.js') }}"></script>
    <script src="{{ asset('vendor/vee-validate.min.js') }}"></script>
    <script src="{{ asset('vendor/vue-resource.min.js') }}"></script>

    @yield('scripts')
    <script src="{{ asset('js/template.js') }}"></script>         
  </body>
</html>