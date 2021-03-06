@extends('layouts.app')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('admin/crud/css/show.css') }}"/>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
		var _data = {!! json_encode($data) !!};
        console.log(_data);
    </script>

@endsection
@section('content')
<div class="container">
    <div class="row">
    	<div class="col-xs-12">
    		<h1>Bienvenido</h1>
            @if(auth()->user()->hasAnyRole(['Comprador','Marketing Manager']))
                
                    <div class="box box-default box-show">
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-view-info  table-condensed">
                                    <tbody>
                                        <tr>
                                            <td>ID</td>
                                            <td>(% user.id %)</td>
                                        </tr>
                                        <tr>
                                            <td>Nombre</td>
                                            <td>(% user.nombre %)</td>
                                        </tr>
                                        <tr>
                                            <td>Apellido</td>
                                            <td>(% user.apellido %)</td>
                                        </tr>
                                        <tr>
                                            <td>Sucursal<span v-if="user.sucursales.length > 1">es</span></td>
                                            <td><span v-for="(sucursal, index) in user.sucursales">(% sucursal.nombre %) <span v-if="index != user.sucursales.length - 1">, </span></span></td>
                                        </tr>
                                        <tr>
                                            <td>Retail</td>
                                            <td>(% user.retail.nombre %) ((% user.retail.pais %))</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (\App\Helpers\AdminHelper::mostrarMenu('alertas'))
                    <a class="btn btn-sm btn-primary" href="{!! route('alertas.index') !!}"><i class="fa fa-link"></i> Alertas</a>
                    @endif
                    @if (\App\Helpers\AdminHelper::mostrarMenu('materiales'))
                    <a class="btn btn-sm btn-primary" href="{!! route('materiales.index') !!}"><i class="fa fa-link"></i> Materiales</a>
                    @endif
                    @if (\App\Helpers\AdminHelper::mostrarMenu('ventas'))
                    <a class="btn btn-sm btn-primary" href="{!! route('ventas.index') !!}"><i class="fa fa-link"></i> Ventas</a>
                    @endif
                    @if (\App\Helpers\AdminHelper::mostrarMenu('ranking'))
                    <a class="btn btn-sm btn-primary" href="{!! route('admin.ranking') !!}"><i class="fa fa-link"></i> Ranking</a>
                    @endif
                
            @else
			<p>Seleccioná una opción del menú de la izquierda para comenzar.</p>
            @endif	
    	</div>
	</div>
    <div class="row">
    	<div class="col-xs-6">
    	</div>
	</div>	
</div>
@endsection
