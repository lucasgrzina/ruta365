@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('admin/crud/css/show.css') }}"/>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('admin/crud/js/show.js') }}"></script>
    <script type="text/javascript">
        var _data = {!! json_encode($data) !!};

        _methods.mostrarTipo = function(tipo) {
            switch (tipo) {
                case 'R':
                    return 'POP';
                    break;
                case 'P':
                    return 'POE';
                    break;
                case 'F':
                    return 'Foto sucursal';
                    break;                    
            }
        };        

    </script>
@endsection

@section('content-header')
{!! AdminHelper::contentHeader('Materiales', 'Ver') !!}
@endsection

@section('content')
    <div class="content">
        <div class="box box-default box-show">
            <div class="box-body no-padding">
                <div class="table-responsive">
                        <table class="table table-view-info  table-condensed">
                            <tbody>
                                @include('admin.materiales.show_fields')
                            </tbody>
                        </table>
                </div>                
            </div>
            <div class="box-footer text-right">
                @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                    <button-type v-if="selectedItem.tipo != 'R'" type="edit" @click="edit(selectedItem)"></button-type>
                @endif
                <button-type type="back" @click="goTo(url_index)"></button-type>
            </div>        
        </div>
    </div>    
@endsection