<li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
  <a href="{!! route('admin.home') !!}"><i class="fa fa-chevron-right"></i><span>Dashboard</span></a>
</li>
@if (\App\Helpers\AdminHelper::mostrarMenu(['usuarios','roles-y-permisos','clientes']))    
<li class=" treeview menu-open {{ Request::is('users*') || Request::is('roles*') || Request::is('clientes*') ? 'active' : '' }}">
  <a href="#">
    <i class="fa fa-user-shield"></i> <span>Administración</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu" style="">
    @if (\App\Helpers\AdminHelper::mostrarMenu('usuarios'))    
    <li class="{{ Request::is('usuarios*') ? 'active' : '' }}">
      <a href="{!! route('usuarios.index') !!}"><i class="fa fa-user"></i><span>Usuarios - Staff</span></a>
    </li>
    @endif
    @if (\App\Helpers\AdminHelper::mostrarMenu('roles-y-permisos'))
    <li class="{{ Request::is('roles*') ? 'active' : '' }}">
      <a href="{!! route('roles.index') !!}"><i class="fa fa-user"></i><span>Roles</span></a>
    </li>
    @endif

    @if (\App\Helpers\AdminHelper::mostrarMenu('registrados'))
    <li class="{{ Request::is('registrados*') ? 'active' : '' }}">
        <a href="{!! route('registrados.index') !!}"><i class="fa fa-chevron-right"></i><span>Registrados</span></a>
    </li>
    @endif

    @if (\App\Helpers\AdminHelper::mostrarMenu('paises'))
    <li class="{{ Request::is('paises*') ? 'active' : '' }}">
        <a href="{!! route('paises.index') !!}"><i class="fa fa-chevron-right"></i><span>Paises</span></a>
    </li>
    @endif

    @if (\App\Helpers\AdminHelper::mostrarMenu('retails'))
    <li class="{{ Request::is('retails*') ? 'active' : '' }}">
        <a href="{!! route('retails.index') !!}"><i class="fa fa-chevron-right"></i><span>Retails</span></a>
    </li>
    @endif
    
    @if (\App\Helpers\AdminHelper::mostrarMenu('banners'))
    <li class="{{ Request::is('banners*') ? 'active' : '' }}">
        <a href="{!! route('banners.index') !!}"><i class="fa fa-chevron-right"></i><span>Banners</span></a>
    </li>
    @endif
    @if (\App\Helpers\AdminHelper::mostrarMenu('premios'))
    <li class="{{ Request::is('premios*') ? 'active' : '' }}">
        <a href="{!! route('premios.index') !!}"><i class="fa fa-chevron-right"></i><span>Premios</span></a>
    </li>
    @endif
    @if (\App\Helpers\AdminHelper::mostrarMenu('productos'))
    <li class="{{ Request::is('productos*') ? 'active' : '' }}">
        <a href="{!! route('productos.index') !!}"><i class="fa fa-chevron-right"></i><span>Productos</span></a>
    </li>
    @endif
    @if (\App\Helpers\AdminHelper::mostrarMenu('mecanicas'))
    <li class="{{ Request::is('mecanicas*') ? 'active' : '' }}">
        <a href="{!! route('mecanicas.index') !!}"><i class="fa fa-chevron-right"></i><span>Mecanicas</span></a>
    </li>
    @endif    
  </ul>
</li>
@endif


@if (\App\Helpers\AdminHelper::mostrarMenu('contactos'))
<li class="{{ Request::is('contactos*') ? 'active' : '' }}">
    <a href="{!! route('contactos.index') !!}"><i class="fa fa-chevron-right"></i><span>Contactos</span></a>
</li>
@endif
@if (\App\Helpers\AdminHelper::mostrarMenu('alertas'))
<li class="{{ Request::is('alertas*') ? 'active' : '' }}">
    <a href="{!! route('alertas.index') !!}"><i class="fa fa-chevron-right"></i><span>Alertas</span></a>
</li>
@endif
@if (\App\Helpers\AdminHelper::mostrarMenu('materiales'))
<li class="{{ Request::is('materiales*') ? 'active' : '' }}">
    <a href="{!! route('materiales.index') !!}"><i class="fa fa-chevron-right"></i><span>Materiales</span></a>
</li>
@endif
@if (\App\Helpers\AdminHelper::mostrarMenu('ventas'))
<li class="{{ Request::is('ventas*') ? 'active' : '' }}">
    <a href="{!! route('ventas.index') !!}"><i class="fa fa-chevron-right"></i><span>Ventas</span></a>
</li>
@endif
@if (\App\Helpers\AdminHelper::mostrarMenu('ranking') && auth()->user()->hasAnyRole(['Comprador','Marketing Manager']))
<li class="{{ Request::is('ranking*') ? 'active' : '' }}">
    <a href="{!! route('admin.ranking') !!}"><i class="fa fa-chevron-right"></i><span>Ranking</span></a>
</li>
@endif