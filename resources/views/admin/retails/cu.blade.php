@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('admin/crud/css/cu.css') }}"/>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('vendor/vue-upload-component/vue-upload-component.min.js') }}"></script>
    <script type="text/javascript">
        Vue.component('file-upload', VueUploadComponent);
        var _data = {!! json_encode($data) !!};
        _data.files = {
            logos: [],
        };  

        _methods.inputLogo = function (n,o) {
          var _this = this;
          this.inputFile(n,o,function(file) {
              //_this.errors.remove('files');
              _this.selectedItem.logo_url = file.response.data.path;
              _this.selectedItem.logo = file.response.data.file;          
          }, function(file) {
            //_this.errors.add('light_logo',file.error, 'server');
          },'uploadLogo');
        };   

        _methods.removeLogo = function() {
            this.selectedItem.logo = null;
            this.selectedItem.logo_url = null;
        }; 

        _methods.paisSeleccionado = function () {
            var _this = this;
            var _item = _.find(_this.info.paises,function(item) {
                return item.id == _this.selectedItem.pais_id;
            });
            return _item;
        };

        _methods.alCambiarPais = function () {
            var _this = this;
            _this.selectedItem.pais = _this.selectedItem.pais_id ? _this.paisSeleccionado() : null;
        };   

        _methods.alCambiarTipo = function () {
            var _this = this;

            if (_this.selectedItem.tipo === 'I') {
                _this.selectedItem.cat_1_target_attach = 0;
                _this.selectedItem.cat_2_target_attach = 0;
                _this.selectedItem.cat_3_target_attach = 0;
                _this.selectedItem.cat_4_target_attach = 0;
                _this.selectedItem.cat_5_target_attach = 0;

                _this.selectedItem.cat_1_puo = 0;
                _this.selectedItem.cat_2_puo = 0;
                _this.selectedItem.cat_3_puo = 0;
                _this.selectedItem.cat_4_puo = 0;
                _this.selectedItem.cat_5_puo = 0;
            }
        };
        

    </script>
    <script type="text/javascript" src="{{ asset('vendor/vee-validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/crud/js/cu.js') }}"></script>
@endsection

@section('content-header')
    {!! AdminHelper::contentHeader('Retails',isset($data['selectedItem']->id) && $data['selectedItem']->id > 0 ? trans('admin.edit') : trans('admin.add_new'),false) !!}
@endsection

@section('content')
    @include('admin.components.switches')
    <div class="content">
        <div class="box box-default box-cu">
            <div class="box-body">
                <div class="row">
                        @include('admin.retails.fields')
                </div>
            </div>
            <div class="box-footer text-right">
                <button-type type="save" :promise="store"></button-type>
                <button-type type="cancel" @click="cancel()"></button-type>
            </div>            
        </div>    
    </div>
@endsection