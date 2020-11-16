<!-- Razon Social Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('razon_social')}">
    {!! Form::label('razon_social', 'Razon Social') !!}
    {!! Form::text('razon_social', null, ['class' => 'form-control','v-model' => 'selectedItem.razon_social']) !!}
    <span class="help-block" v-show="errors.has('razon_social')">(% errors.first('razon_social') %)</span>
</div>

<!-- Cuit Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('cuit')}">
    {!! Form::label('cuit', 'Cuit') !!}
    {!! Form::text('cuit', null, ['class' => 'form-control','v-model' => 'selectedItem.cuit']) !!}
    <span class="help-block" v-show="errors.has('cuit')">(% errors.first('cuit') %)</span>
</div>

<!-- Nombre Fantasia Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('nombre_fantasia')}">
    {!! Form::label('nombre_fantasia', 'Nombre Fantasia') !!}
    {!! Form::text('nombre_fantasia', null, ['class' => 'form-control','v-model' => 'selectedItem.nombre_fantasia']) !!}
    <span class="help-block" v-show="errors.has('nombre_fantasia')">(% errors.first('nombre_fantasia') %)</span>
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('observaciones')}">
    {!! Form::label('observaciones', 'Observaciones') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control','v-model' => 'selectedItem.observaciones']) !!}
    <span class="help-block" v-show="errors.has('observaciones')">(% errors.first('observaciones') %)</span>
</div>
<div class="clearfix"></div>