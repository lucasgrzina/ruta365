@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('admin/crud/css/index.css') }}"/>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var _data = {!! json_encode($data) !!};

        _methods.obtenerCantPorProducto = function (productos, producto) {
            var _this = this;
            
            var _prodSeleccionado = _.find(productos,function(item) {
                return item.producto_id === producto.id;
            });
            return _prodSeleccionado ? Number(_prodSeleccionado.cantidad) : 0;

        };

		_methods.alCambiar = function(campo) {
			var _this = this;
			var _errorMsg = null;
			var _url = null;
			var _data = [];
			var _valorCampo = null;
			
			_valorCampo = _this.filters[campo];

			if (campo === 'pais_id') {
				 
				_this.filters.retail_id = null;
				_this.filters.sucursal_id = null;

				_url = '{{route("combo.retails")}}';
				_data = {
					pais_id: _valorCampo
				};

				_this.$set(_this.info,'retails',[]);
				_this.$set(_this.info,'sucursales',[]);
			} else {
				_this.filters.sucursal_id = null;

				_url = '{{route("combo.sucursales")}}';
				_data = {
					retail_id: _valorCampo
				};

				_this.$set(_this.info,'sucursales',[]);
			}

			if (_valorCampo) {
				_this._call(_url,'POST',_data).then(function(data) {
					console.debug(data);
					if (campo === 'pais_id') {
						_this.$set(_this.info,'retails',data);
					} else {
						_this.$set(_this.info,'sucursales',data);
					}
					// _this.registro.enviando = false;
				}, function(error) {
					// _this.registro.enviando = false;
				});          

			}
			
		};        

        this._mounted.push(function(_this) {
            if (_this.owner) {
                _this.doFilter();
            } else {
                _this.loading = false;
            }
            
        });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/vuejs-paginate/vuejs-paginate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/crud/js/index.js') }}"></script>
@endsection

@section('content-header')
{!! AdminHelper::contentHeader('Ventas',trans('admin.list'),'new','create()') !!}
@endsection

@section('content')
    @include('admin.components.switches')
    <div class="content">
        <div class="box box-default box-page-list">
            <div class="box-body box-filter">
                <div class="form-inline">
                    <div class="form-group" v-if="!owner">
                        <select v-model="filters.pais_id" class="form-control input-sm" name="pais_id" @change="alCambiar('pais_id')">
                            <option v-for="item in info.paises" :value="item.id">(% item.nombre %)</option>
                            <option :value="null">Paises (todos)</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="!owner">
                        <select v-model="filters.retail_id" class="form-control input-sm" name="retail_id" @change="alCambiar('retail_id')">
                            <option v-for="item in info.retails" :value="item.id">(% item.nombre %)</option>
                            <option :value="null">Retails (todos)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select v-model="filters.sucursal_id" class="form-control input-sm" name="sucursal_id">
                            <option v-for="item in info.sucursales" :value="item.id">(% item.nombre %)</option>
                            <option :value="null">Sucursales (todos)</option>
                        </select>
                    </div>
                   
                    <!-- cualquier otro campo -->
                    @include('admin.includes.crud.index-filters-btn')
                </div>
            </div>
            <div class="box-body box-list no-padding">
                    @include('admin.ventas.table')
            </div>
            <div class="box-footer">
                <div class="col-sm-8 left">
                    <span v-if="!loading">(% paging.total %) registro(s)</span>
                </div>
                <div class="col-sm-4 right">
                    @include('admin.includes.crud.index-pagination')
                </div>
            </div>
            @include('admin.includes.crud.index-loading')            
        </div>
    </div>
@endsection

