@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('admin/crud/css/show.css') }}"/>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var _data = {!! json_encode($data) !!};

        _methods.fondoInfoCluster = function (categoria, campo) {
            var _this = this;
            return _this.selectedItem['cat_'+ categoria + '_' + campo] > 0 ? 'bg-info' : 'bg-danger';
        }
    </script>
    <script type="text/javascript" src="{{ asset('vendor/vee-validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/crud/js/cu.js') }}"></script>
    
@endsection

@section('content-header')
{!! AdminHelper::contentHeader("Retails: {$data['selectedItem']->nombre} ({$data['selectedItem']->pais->nombre})", 'Objetivos') !!}
@endsection

@section('content')
    <div class="content">
        <div class="box box-default box-show">
            <div class="box-body no-padding">
                <div class="table-responsive">

                        <table class="table table-view-info  table-condensed">
                            <thead>
                                <tr>
                                    <th>Sucursal</th>
                                        <template v-if="selectedItem.tipo === 'I'">
                                            <th>Target Attach</th>
                                            <th>Piso Unid. Office</th>
                                        </template>
                                        <template v-else>
                                            <th>Categoría</th>
                                            <th>Target Attach</th>
                                            <th>Piso Unid. Office</th>
                                        </template>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sucursal in selectedItem.sucursales" :key="sucursal.id">
                                    <td>(% sucursal.nombre %)</td>
                                    <template v-if="selectedItem.tipo === 'I'">
                                        <td><input type="number" class="form-control input-xs" v-model="sucursal.target_attach"></td>
                                        <td><input type="number" class="form-control input-xs" v-model="sucursal.piso_unidades_office"></td>
                                    </template>
                                    <template v-else>
                                        <td>
                                            <select v-model="sucursal.categoria_cluster" class="form-control">
                                                <option :value="0">Seleccione</option>
                                                <option :value="1">Categoria 1</option>
                                                <option :value="2">Categoria 2</option>
                                                <option :value="3">Categoria 3</option>
                                                <option :value="4">Categoria 4</option>
                                                <option :value="5">Categoria 5</option>
                                            </select>                                            
                                        </td>
                                        <td>
                                            <p :class="[fondoInfoCluster(sucursal.categoria_cluster,'target_attach'),'text-center','p-10','m-0']">
                                                (% selectedItem['cat_'+sucursal.categoria_cluster+'_target_attach'] > 0 ? selectedItem['cat_'+sucursal.categoria_cluster+'_target_attach'] : 'Sin cargar' %)
                                            </p>
                                        </td>
                                        <td>
                                            <p :class="[fondoInfoCluster(sucursal.categoria_cluster,'puo'),'text-center','p-10','m-0']">
                                                (% selectedItem['cat_'+sucursal.categoria_cluster+'_puo'] > 0 ? selectedItem['cat_'+sucursal.categoria_cluster+'_puo'] : 'Sin cargar' %)
                                            </p>

                                        </td>

                                    </template>
                                </tr>
                                
                            </tbody>
                        </table>
                </div>                
            </div>
            <div class="box-footer text-right">
                @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                    <button-type type="save" :promise="store" v-if="selectedItem.sucursales.length > 0"></button-type>
                @endif
                <button-type type="back" @click="goTo(url_index)"></button-type>
            </div>        
        </div>
    </div>    
@endsection