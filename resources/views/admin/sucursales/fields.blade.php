<!-- Nombre Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('nombre')}">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control','v-model' => 'selectedItem.nombre']) !!}
    <span class="help-block" v-show="errors.has('nombre')">(% errors.first('nombre') %)</span>
</div>

<!-- Codigo Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('codigo')}">
    {!! Form::label('codigo', 'Codigo') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control','v-model' => 'selectedItem.codigo']) !!}
    <span class="help-block" v-show="errors.has('codigo')">(% errors.first('codigo') %)</span>
</div>

<!-- Retail Id Field -->
<template v-if="origen && origen === 'parent'">
    <div class="form-group col-sm-6">
        {!! Form::label('retail_id', 'Retail') !!}
        <span class="form-control">(% selectedItem.retail.nombre %)</span>
    </div>
</template>
<template v-else>
    <div class="form-group col-sm-6" :class="{'has-error': errors.has('retail_id')}">
        {!! Form::label('retail_id', 'Retail Id') !!}
        {!! Form::text('retail_id', null, ['class' => 'form-control','v-model' => 'selectedItem.retail_id']) !!}
        <span class="help-block" v-show="errors.has('retail_id')">(% errors.first('retail_id') %)</span>
    </div>    
</template>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('observaciones')}">
    {!! Form::label('observaciones', 'Observaciones') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control','v-model' => 'selectedItem.observaciones']) !!}
    <span class="help-block" v-show="errors.has('observaciones')">(% errors.first('observaciones') %)</span>
</div>
<div class="clearfix"></div>