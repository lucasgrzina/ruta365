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
<!-- Cuerpo Field -->
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('cuerpo')}">
    {!! Form::label('cuerpo', 'Cuerpo') !!}
    <vue-mce v-model="selectedItem.cuerpo" :config="tinyConfig"/>
    <span class="help-block" v-show="errors.has('cuerpo')">(% errors.first('cuerpo') %)</span>
</div>
