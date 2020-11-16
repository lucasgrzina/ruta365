<!-- Registrado Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('registrado_id')}">
    {!! Form::label('registrado_id', 'Registrado Id') !!}
    {!! Form::text('registrado_id', null, ['class' => 'form-control','v-model' => 'selectedItem.registrado_id']) !!}
    <span class="help-block" v-show="errors.has('registrado_id')">(% errors.first('registrado_id') %)</span>
</div>

<!-- Mensaje Field -->
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('mensaje')}">
    {!! Form::label('mensaje', 'Mensaje') !!}
    {!! Form::textarea('mensaje', null, ['class' => 'form-control','v-model' => 'selectedItem.mensaje']) !!}
    <span class="help-block" v-show="errors.has('mensaje')">(% errors.first('mensaje') %)</span>
</div>

<!-- Leido Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('leido')}">
    {!! Form::label('leido', 'Leido') !!}
    {!! Form::text('leido', null, ['class' => 'form-control','v-model' => 'selectedItem.leido']) !!}
    <span class="help-block" v-show="errors.has('leido')">(% errors.first('leido') %)</span>
</div>
<div class="clearfix"></div>