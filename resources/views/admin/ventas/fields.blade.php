<!-- Sucursal Id Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('sucursal_id')}">
    {!! Form::label('sucursal_id', 'Sucursal*') !!}
    <select v-model="selectedItem.sucursal_id" class="form-control" name="sucursal_id" v-validate="'required'" data-vv-validate-on="'none'" :disabled="selectedItem.sucursal_id">
        <option :value="null">Seleccione</option>
        <option v-for="item in info.sucursales" :value="item.id">(% item.nombre %)</option>
    </select>
    
    <span class="help-block" v-show="errors.has('sucursal_id')">(% errors.first('sucursal_id') %)</span>
</div>

<!-- Cantidad Dispositivos Field -->
<div class="form-group col-sm-6" :class="{'has-error': errors.has('cantidad_dispositivos')}">
    {!! Form::label('cantidad_dispositivos', 'Cantidad Dispositivos') !!}
    {!! Form::text('cantidad_dispositivos', null, ['class' => 'form-control','v-model' => 'selectedItem.cantidad_dispositivos']) !!}
    <span class="help-block" v-show="errors.has('cantidad_dispositivos')">(% errors.first('cantidad_dispositivos') %)</span>
</div>

<div class="col-xs-12"><h3>Productos</h3></div>
<div class="clearfix"></div>
<div class="col-xs-12">
    <div class="table-responsive">
        <table class="table table-condensed">
            <tr>
                
                <th width="70%">Nombre</th>
                <th>Imagen</th>
                <th>Cantidad</th>
            </tr>
            <tr v-for="item in selectedItem.productos">
                
                <td><input type="text" class="form-control input-xs" disabled="true" v-model="item.producto.nombre"></td>
                <td><div style="width: 80px; height: 40px; background-size: cover; background-position: center;" v-bind:style="{ backgroundImage: 'url(' + item.producto.imagen_url + ')' }"></div></td>
                <td><input type="number" class="form-control input-xs" v-model="item.cantidad"></td>
            </tr>
        </table>
    </div>
</div>

<div class="clearfix"></div>