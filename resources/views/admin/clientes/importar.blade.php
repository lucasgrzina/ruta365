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
            files: []
        };          

        _methods.inputFiles = function (n,o) {
          var _this = this;
          this.inputFile(n,o,function(file) {
              //_this.errors.remove('files');
              _this.selectedItem.file_url = file.response.data.path;
              _this.selectedItem.file = file.response.data.file;          
              console.debug(_this.selectedItem);  
          }, function(file) {
            //_this.errors.add('light_logo',file.error, 'server');
          },'uploadFile');
        }   

        _methods.removeImportar = function() {
            this.selectedItem.file = null;
            this.selectedItem.file_url = null;
        }   
        
        _methods.importar = function() {
            var _this = this;
            var _ajaxMethod = _this.ajaxPost ;
            var _is_valid = _this.validateForm();
            return _this.$validator.validateAll().then(function(result) {
                if (result && _is_valid) {
                    return _ajaxMethod(_this.url_importar_archivo,_this.selectedItem,true,_this.errors).then(function(data){
                        setTimeout(function() {
                            document.location = _this.url_index;
                        },1000);
                    });                            
                }
            });
        };        


    </script>
    
    <script type="text/javascript" src="{{ asset('vendor/vee-validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/crud/js/cu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/crud/js/show.js') }}"></script>
@endsection

@section('content-header')
    {!! AdminHelper::contentHeader('Clientes','Importar',false) !!}
@endsection

@section('content')
    @include('admin.components.switches')
    <div class="content">
        <div class="box box-default box-cu">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6" :class="{'has-error': errors.has('file')}">
                        {!! Form::label('file', 'Archivo') !!}<br>
                        <div class="input-group">
                          <div  type="text" class="form-control">
                            <div class="progress m-t-5 m-b-0" v-if="files.files.length > 0 && files.files[0].progress < 100">
                                <div class="progress-bar" :style="{ width: files.files[0].progress+'%' }"></div>
                            </div>            
                            <a target="_blank" v-if="selectedItem.file" :href="selectedItem.file_url">(% selectedItem.file %)</a>
                          </div>
                          <span class="input-group-btn">
                            <file-upload
                                :multiple="false"
                                :headers="_fuHeader"
                                ref="uploadFile"
                                input-id="file"
                                v-model="files.files"
                                post-action="{{ route('uploads.store-file') }}"
                                @input-file="inputFiles"
                                class="btn btn-default">
                                    <span>Buscar...</span>
                            </file-upload>         
                          </span>
                        </div> 
                           
                        <span class="help-block" v-show="errors.has('file')">(% errors.first('file') %)</span>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <button-type v-if="selectedItem.file" type="save" :promise="importar"></button-type>
                <button-type type="cancel" @click="cancel()"></button-type>
            </div>            
        </div>    
    </div>
@endsection