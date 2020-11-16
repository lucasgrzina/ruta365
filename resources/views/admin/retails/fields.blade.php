<!-- Nombre Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('nombre')}">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control','v-model' => 'selectedItem.nombre']) !!}
    <span class="help-block" v-show="errors.has('nombre')">(% errors.first('nombre') %)</span>
</div>

<!-- Pais Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('pais_id')}">
    {!! Form::label('pais_id', 'País*') !!}
    <select v-model="selectedItem.pais_id" class="form-control" name="pais_id" v-validate="'required'" data-vv-validate-on="'none'" @change="alCambiarPais">
        <option :value="null">Seleccione</option>
        <option v-for="item in info.paises" :value="item.id">(% item.nombre %)</option>
    </select>
    <span class="help-block" v-show="errors.has('pais_id')">(% errors.first('pais_id') %)</span>
</div>


<div class="form-group col-sm-6" :class="{'has-error': errors.has('logo')}">
    {!! Form::label('logo', 'Logo') !!}<br>
    <div class="input-group">
        <div  type="text" class="form-control">
        <div class="progress m-t-5 m-b-0" v-if="files.logos.length > 0 && files.logos[0].progress < 100">
            <div class="progress-bar" :style="{ width: files.logos[0].progress+'%' }"></div>
        </div>            
        <a target="_blank" v-if="selectedItem.logo" :href="selectedItem.logo_url">(% selectedItem.logo %)</a>
        </div>
        <span class="input-group-btn">
        <file-upload
            :multiple="false"
            :headers="_fuHeader"
            ref="uploadLogo"
            input-id="file"
            v-model="files.logos"
            post-action="{{ route('uploads.store-file') }}"
            @input-file="inputLogo"
            class="btn btn-default">
                <span>Buscar...</span>
        </file-upload>         
        </span>
    </div>
    <!--span class="form-control text-left border-0">
        <a target="_blank" v-if="selectedItem.logo" :href="selectedItem.logo_url">(% selectedItem.logo %)</a>
    </span-->
        
    <span class="help-block" v-show="errors.has('logo')">(% errors.first('logo') %)</span>
</div>


<!-- Color Hexa Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('color_hexa')}">
    {!! Form::label('color_hexa', 'Color Hexa') !!}
    {!! Form::text('color_hexa', null, ['class' => 'form-control','v-model' => 'selectedItem.color_hexa']) !!}
    <span class="help-block" v-show="errors.has('color_hexa')">(% errors.first('color_hexa') %)</span>
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-6" :class="{'has-error': errors.has('tipo')}">
    {!! Form::label('tipo', 'Tipo de objetivos') !!}
    <select v-model="selectedItem.tipo" class="form-control" name="tipo" v-validate="'required'" data-vv-validate-on="'none'" @change="alCambiarTipo">
        <option :value="'I'">Tienda por tienda</option>
        <option :value="'C'">Clusterizado</option>
    </select>
    <span class="help-block" v-show="errors.has('tipo')">(% errors.first('tipo') %)</span>
</div>
<template v-if="selectedItem.tipo === 'C'">
    <div class="clearfix"></div>
        <div class="col-xs-12"><h3>Clusters</h3></div>
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Categoría</th>
                        <th width="150">Target Attach</th>
                        <th width="150">Piso Unid. Office</th>
                    </tr>
                    <tr>
                        <td>Categoría 1</td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_1_target_attach"></td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_1_puo"></td>
                    </tr>
                    <tr>
                        <td>Categoría 2</td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_2_target_attach"></td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_2_puo"></td>
                    </tr>
                    <tr>
                        <td>Categoría 3</td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_3_target_attach"></td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_3_puo"></td>
                    </tr>
                    <tr>
                        <td>Categoría 4</td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_4_target_attach"></td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_4_puo"></td>
                    </tr>
                    <tr>
                        <td>Categoría 5</td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_5_target_attach"></td>
                        <td><input type="number" class="form-control input-xs" v-model="selectedItem.cat_5_puo"></td>
                    </tr>
    
                </table>
            </div>
        </div>
    </template>
<div class="col-xs-12"><h3>Usuarios</h3></div>
<div class="clearfix"></div>
<div class="col-xs-12">
    <div class="table-responsive">
        <table class="table table-condensed">
            <tr>
                <th>Rol</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Clave</th>
                <th>Acciones</th>
            </tr>
            <tr v-for="item in selectedItem.usuarios">
                <td>(% item.role ? item.role.name : ' -- '%)</td>
                <td><input type="text" class="form-control input-xs" v-model="item.nombre"></td>
                <td><input type="text" class="form-control input-xs" v-model="item.apellido"></td>
                <td><input type="email" class="form-control input-xs" v-model="item.email"></td>
                <td><input type="text" class="form-control input-xs" v-model="item.password"></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>

<div class="clearfix"></div>

