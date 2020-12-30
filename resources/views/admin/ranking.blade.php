@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('admin/crud/css/index.css') }}"/>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var _data = {!! json_encode($data) !!};
        _methods.cambiarCategoria = function() {
			var _this = this;
			
			if (!_this.categoria) {
				alert('Debe seleccionar una categoria');
				return false;
			}

            _this.loading = true;
            _this.ajaxGet(_this.url_ranking_categoria.replace('_CAT_',_this.categoria)).then(function(data) {
				_this.loading = false;
				_this.tabla = data;
				console.debug(data);
            }, function(error) {
                
                _this.loading = false;

            });            
        };


        this._mounted.push(function(_this) {
        });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/vuejs-paginate/vuejs-paginate.js') }}"></script>
    <!--script type="text/javascript" src="{{ asset('admin/crud/js/index.js') }}"></script-->
@endsection

@section('content-header')
@if(auth()->user()->hasAnyRole(['Comprador','Marketing Manager']))
    {!! AdminHelper::contentHeader('Ranking',trans('admin.list')) !!}
@endif
@endsection

@section('content')
    @include('admin.components.switches')
    <div class="content">
        <div class="box box-default box-page-list">
            <div class="box-body box-filter">
                <div class="form-inline">
                    <div class="form-group" v-if="retail.tipo === 'C'">
                        <select v-model="categoria" class="form-control input-sm" name="categoria">
                            <option v-for="item in categorias" :value="item">Categoría (% item %)</option>
                            <option :value="null">Seleccione</option>
                        </select>
                    </div>
					<div class="form-group" v-if="retail.tipo === 'C'">
						<button-type type="filter" @click="cambiarCategoria()"></button-type>      
					</div>
                </div>
            </div>
            <div class="box-body box-list no-padding">
				<div class="table-responsive">
					<table class="table m-b-0" id="alertas-table">
						<thead>
							<tr>
								<th class="td-id">POS</th>
								<th>Sucursal</th>
								<th>Total dispositivos</th>
								<th>Total Units Office</th>
								<th>Alcance en % attach</th>
								<th>Alcance en Units Office</th>
								<th>Target Attach</th>
								<th>Piso de unidades Office</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item, index) in tabla">
							<td>(% index + 1 %)</td>
							<td>(% item.nombre %)</td>
							<td>(% item.cantidad_dispositivos %)</td>
							<td>(% item.cantidad_office %)</td>
							<td>(% item.ta ? item.ta : 0 %)%</td>
							<td>(% item.tco ? item.tco : 0 %)%</td>
							<td :class="{'text-center':true,'bg-success': item.ta >= item.target_attach,'bg-danger': item.ta < item.target_attach}">(% item.target_attach %)%</td>
							<td :class="{'text-center':true,'bg-success': item.cantidad_office >= item.puo,'bg-danger': item.cantidad_office < item.puo}">(% item.puo %)</td>

							</tr>
						</tbody>
					</table>
				</div>                    
            </div>
            <div class="box-footer">
                <div class="col-sm-8 left">
                    
                </div>
                <div class="col-sm-4 right">
                    
                </div>
            </div>
            @include('admin.includes.crud.index-loading')            
        </div>
    </div>
@endsection

