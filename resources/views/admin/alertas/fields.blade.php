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

<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('descripcion')}">
    {!! Form::label('descripcion', 'Descripcion') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control','v-model' => 'selectedItem.descripcion',':disabled' => '!owner']) !!}
    <span class="help-block" v-show="errors.has('descripcion')">(% errors.first('descripcion') %)</span>
</div>

<!-- Leido Field -->
<div v-if="selectedItem.id" class="form-group col-sm-6" :class="{'has-error': errors.has('leido')}">
    {!! Form::label('leido', 'Leido') !!}<br>
    <span v-if="owner" :class="{'label': true, 'label-success': selectedItem.leido,'label-danger': !selectedItem.leido}">
        (% selectedItem.leido ? 'SI' : 'NO' %)
    </span>
    <switch-button v-else v-model="selectedItem.leido" theme="bootstrap" type-bold="true"></switch-button>
    <span class="help-block" v-show="errors.has('leido')">(% errors.first('leido') %)</span>
</div>

<!-- Observaciones Field -->
<div v-if="selectedItem.id" class="form-group col-sm-12 col-lg-12" :class="{'has-error': errors.has('observaciones')}">
    {!! Form::label('observaciones', 'Observaciones') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control','v-model' => 'selectedItem.observaciones',':disabled' => 'owner']) !!}
    <span class="help-block" v-show="errors.has('observaciones')">(% errors.first('observaciones') %)</span>
</div>
<div class="clearfix"></div>