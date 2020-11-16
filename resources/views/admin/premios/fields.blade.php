<!-- Retail Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('retail_id')}">
    {!! Form::label('retail_id', 'Retail*') !!}
    <select v-if="!selectedItem.id" v-model="selectedItem.retail_id" class="form-control" name="retail_id" v-validate="'required'" data-vv-validate-on="'none'">
        <option :value="null">Seleccione</option>
        <option v-for="item in info.retails" :value="item.id">(% item.nombre %)</option>
    </select>
    <span v-else class="form-control">(% selectedItem.retail.nombre %)</span>
    <span class="help-block" v-show="errors.has('retail_id')">(% errors.first('retail_id') %)</span>
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6" :class="{'has-error': errors.has('imagen_web')}">
    {!! Form::label('imagen_web', 'Imagen (WEB)') !!}
    <div class="thumb-wrap">
        <button-type v-if="selectedItem.imagen_web" type="remove-list" @click="removeImagen('web')"></button-type>
        <file-upload
            
            :multiple="false"
            :headers="_fuHeader"
            ref="uploadImagenWeb"
            extensions="gif,jpg,jpeg,png,webp,svg"
            accept="image/png,image/gif,image/jpeg,image/webp,image/svg"            
            input-id="imagenweb"
            v-model="files.imagen_web"
            post-action="{{ route('uploads.store-file') }}"
            @input-file="inputImagenWeb"
            class="thumbnail">
                <img class="img-responsive" src="{{ asset('admin/img/generic-upload.png') }}" v-if="!selectedItem.imagen_web_url">
                <img class="img-responsive" :src="selectedItem.imagen_web_url" v-else>
                <div class="progress m-t-5 m-b-0" v-if="files.imagen_web.length > 0">
                    <div class="progress-bar" :style="{ width: files.imagen_web[0].progress+'%' }"></div>
                </div>
        </file-upload>
    </div>    
    <span class="help-block" v-show="errors.has('imagen_web')">(% errors.first('imagen_web') %)</span>
</div>

<div class="form-group col-sm-6" :class="{'has-error': errors.has('imagen_mobile')}">
    {!! Form::label('imagen_mobile', 'Imagen (Mobile)') !!}
    <div class="thumb-wrap">
        <button-type v-if="selectedItem.imagen_mobile" type="remove-list" @click="removeImagen('mobile')"></button-type>
        <file-upload
            
            :multiple="false"
            :headers="_fuHeader"
            ref="uploadImagenMobile"
            extensions="gif,jpg,jpeg,png,webp,svg"
            accept="image/png,image/gif,image/jpeg,image/webp,image/svg"            
            input-id="imagenmobile"
            v-model="files.imagen_mobile"
            post-action="{{ route('uploads.store-file') }}"
            @input-file="inputImagenMobile"
            class="thumbnail">
                <img class="img-responsive" src="{{ asset('admin/img/generic-upload.png') }}" v-if="!selectedItem.imagen_mobile_url">
                <img class="img-responsive" :src="selectedItem.imagen_mobile_url" v-else>
                <div class="progress m-t-5 m-b-0" v-if="files.imagen_mobile.length > 0">
                    <div class="progress-bar" :style="{ width: files.imagen_mobile[0].progress+'%' }"></div>
                </div>
        </file-upload>
    </div>    
    <span class="help-block" v-show="errors.has('imagen_mobile')">(% errors.first('imagen_mobile') %)</span>
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('descripcion')}">
    {!! Form::label('descripcion', 'Descripcion') !!}
    <vue-mce v-model="selectedItem.descripcion" :config="tinyConfig"/>
    <span class="help-block" v-show="errors.has('descripcion')">(% errors.first('descripcion') %)</span>
</div>