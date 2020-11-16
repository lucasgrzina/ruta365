<!-- User Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('user_id')}">
    {!! Form::label('user_id', 'User Id') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control','v-model' => 'selectedItem.user_id']) !!}
    <span class="help-block" v-show="errors.has('user_id')">(% errors.first('user_id') %)</span>
</div>

<!-- Sucursal Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('sucursal_id')}">
    {!! Form::label('sucursal_id', 'Sucursal Id') !!}
    {!! Form::text('sucursal_id', null, ['class' => 'form-control','v-model' => 'selectedItem.sucursal_id']) !!}
    <span class="help-block" v-show="errors.has('sucursal_id')">(% errors.first('sucursal_id') %)</span>
</div>

<!-- Tipo Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('tipo')}">
    {!! Form::label('tipo', 'Tipo') !!}
    {!! Form::text('tipo', null, ['class' => 'form-control','v-model' => 'selectedItem.tipo']) !!}
    <span class="help-block" v-show="errors.has('tipo')">(% errors.first('tipo') %)</span>
</div>

<!-- Imagen Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('imagen')}">
    {!! Form::label('imagen', 'Imagen') !!}
    {!! Form::text('imagen', null, ['class' => 'form-control','v-model' => 'selectedItem.imagen']) !!}
    <span class="help-block" v-show="errors.has('imagen')">(% errors.first('imagen') %)</span>
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('descripcion')}">
    {!! Form::label('descripcion', 'Descripcion') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control','v-model' => 'selectedItem.descripcion']) !!}
    <span class="help-block" v-show="errors.has('descripcion')">(% errors.first('descripcion') %)</span>
</div>
<div class="clearfix"></div>