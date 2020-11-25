<!-- Registrado Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('user_id')}">
    {!! Form::label('user_id', 'Usuario') !!}
    <span class="form-control">(% selectedItem.usuario.nombre + ' ' + selectedItem.usuario.apellido %)</span>
    <span class="help-block" v-show="errors.has('user_id')">(% errors.first('user_id') %)</span>
</div>

<!-- Sucursal Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('sucursal_id')}">
    {!! Form::label('sucursal_id', 'Sucursal*') !!}
    <select v-if="owner" v-model="selectedItem.sucursal_id" class="form-control" name="sucursal_id" v-validate="'required'" data-vv-validate-on="'none'">
        <option :value="null">Seleccione</option>
        <option v-for="item in info.sucursales" :value="item.id">(% item.nombre %)</option>
    </select>
    <span v-else class="form-control">(% selectedItem.sucursal ? selectedItem.sucursal.nombre : '' %)</span>
    <span class="help-block" v-show="errors.has('sucursal_id')">(% errors.first('sucursal_id') %)</span>
</div>

<!-- Tipo Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('tipo')}">
    {!! Form::label('tipo', 'Tipo') !!}
    <span v-if="selectedItem.tipo === 'P'" class="form-control">POP</span>
    <span v-if="selectedItem.tipo === 'F'" class="form-control">Foto sucursal</span>
    <span class="help-block" v-show="errors.has('tipo')">(% errors.first('tipo') %)</span>
</div>

<!-- Imagen Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('imagen')}">
    {!! Form::label('imagen', 'Imagen') !!}
    <div class="thumb-wrap">
        <button-type v-if="selectedItem.imagen" type="remove-list" @click="removeImagen()"></button-type>
        <file-upload
            
            :multiple="false"
            :headers="_fuHeader"
            ref="uploadImagen"
            extensions="gif,jpg,jpeg,png,webp,svg"
            accept="image/png,image/gif,image/jpeg,image/webp,image/svg"            
            input-id="imagenweb"
            v-model="files.imagen"
            post-action="{{ route('uploads.store-file') }}"
            @input-file="inputImagen"
            class="thumbnail">
                <img class="img-responsive" src="{{ asset('admin/img/generic-upload.png') }}" v-if="!selectedItem.imagen_url">
                <img class="img-responsive" :src="selectedItem.imagen_url" v-else>
                <div class="progress m-t-5 m-b-0" v-if="files.imagen.length > 0">
                    <div class="progress-bar" :style="{ width: files.imagen[0].progress+'%' }"></div>
                </div>
        </file-upload>
    </div>    
    <span class="help-block" v-show="errors.has('imagen')">(% errors.first('imagen') %)</span>
</div>
<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('descripcion')}">
    {!! Form::label('descripcion', 'Descripcion') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control','v-model' => 'selectedItem.descripcion']) !!}
    <span class="help-block" v-show="errors.has('descripcion')">(% errors.first('descripcion') %)</span>
</div>
<div class="clearfix"></div>