@if(Auth::guest() || !config('constantes.homeActiva'))
<div class="container-fluid header-top">
    <img src="{{asset('img/Logo-Grande.png')}}" alt="Microsoft Ruta 365">
</div>
@else
<div class="container">
    <div class="top-menu d-flex bd-highlight mb-0 align-items-center ">
      <div class="mr-auto p-2 bd-highlight"><a href="#"><img src="{{asset('img/Logo-01.png')}}" alt="Target"></a></div>
      <div class="p-2 bd-highlight"><a href="#">
        @if(isset($data['registrado']))
        <img src="{{$data['registrado']->sucursal->retail->logo_url}}" alt="Target">
        @endif
      </a></div>
      <!--div class="p-2 bd-highlight "><a href="#"><img src="{{asset('img/Logo-03.png')}}" alt="Target"></a></div-->
    </div>
    
    <nav class="navbar navbar-expand-xl navbar-ruta">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbars">
        <ul class="navbar-nav mr-auto smooth-scroll">
          <li class="nav-item active">
            <a class="nav-link" href="#inicio" @click="irA('#inicio')">Inicio<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#ranking" @click="irA('#ranking')">Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#ventas" @click="irA('#ventas')">Ventas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#productos" @click="irA('#productos')">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#premios" @click="irA('#premios')">Premios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#mecanica" @click="irA('#mecanica')">Mecánica</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#fotos-sucursales"  @click="irA('#fotos-sucursales')">Fotos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#contacto" @click="irA('#contacto')">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn-cambiar-pass" href="#" data-toggle="modal" data-target="#modalPassword">Cambiar contraseña</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn-salir" href="{{route('logout')}}">Salir</a>
          </li>
        </ul>
      </div>
    </nav>

    <h2 id="inicio" class="text-left sucursal-header">{{$data['registrado']->sucursal->nombre}}</h2>

    <div class="header-home container-fluid">
      @if($data['registrado']->sucursal->retail->banner)
        @if($data['registrado']->sucursal->retail->banner->imagen_web)
          <img src="{{$data['registrado']->sucursal->retail->banner->imagen_web_url}}" class="mx-auto container-fluid header-desktop" alt="Header Home">
        @endif
        @if($data['registrado']->sucursal->retail->banner->imagen_mobile)
          <img src="{{$data['registrado']->sucursal->retail->banner->imagen_mobile_url}}" class="mx-auto container-fluid header-mobile" alt="Header Home">
        @endif
      @else
        <img src="{{asset('img/Header-home.jpg')}}" class="mx-auto container-fluid header-desktop" alt="Header Home">
        <img src="{{asset('img/Header-home-mobile.jpg')}}" class="mx-auto container-fluid header-mobile" alt="Header Home">
      @endif
    </div>

    <div class="container inicio-cuadros">
      <div class="row">
        <div class="col-sm back-grey-01">
          <img src="{{asset('img/Icon-01.png')}}" class="mx-auto d-block" alt="Target">
          <h3>{{number_format($data['estadisticas']['target_attach'],0)}}%</h3>
          <p>Target Attach</p>
        </div>
        <div class="col-sm back-grey-02">
          <img src="{{asset('img/Icon-02.png')}}" class="mx-auto d-block" alt="Actual">
          <h3>{{number_format ($data['estadisticas']['actual_attach'],0)}}%</h3>
          <p>Attach Actual</p>
        </div>
        <div class="col-sm back-grey-03">
          <img src="{{asset('img/Icon-03.png')}}" class="mx-auto d-block" alt="Ventas">
          <h3>{{$data['estadisticas']['minimo_un_cumplir']}}</h3>
          <p>Mínimo de unidades a cumplir</p>
        </div>
        <div class="col-sm back-grey-04">
          <img src="{{asset('img/Icon-04.png')}}" class="mx-auto d-block" alt="Posición">
          <h3>{{$data['estadisticas']['cantidad_office']}}</h3>
          <p>Unidades actuales</p>
        </div>
      </div>
    </div>
  </div>
  
@endif
