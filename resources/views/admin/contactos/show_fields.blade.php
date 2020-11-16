<tr>
	<td>{!! Form::label('id', 'Id') !!}</td>
	<td>(% selectedItem.id %)</td>    
</tr>

<tr>
	<td>{!! Form::label('registrado_id', 'Registrado Id') !!}</td>
	<td>(% selectedItem.registrado.nombre + ' ' + selectedItem.registrado.apellido %)</td>    
</tr>

<tr>
	<td>{!! Form::label('registrado_id', 'Sucursal / Retail') !!}</td>
	<td>(% selectedItem.registrado.sucursal.nombre + ' / ' + selectedItem.registrado.sucursal.retail.nombre %)</td>    
</tr>


<tr>
	<td>{!! Form::label('mensaje', 'Mensaje') !!}</td>
	<td>(% selectedItem.mensaje %)</td>    
</tr>

<tr>
	<td>{!! Form::label('leido', 'Leido') !!}</td>
	<td>
		<span v-if="selectedItem.leido" class="label label-success">SI</span>
		<span v-else class="label label-danger">NO</span>
	</td>    
</tr>

<tr>
	<td>{!! Form::label('created_at', 'Fecha') !!}</td>
	<td>(% selectedItem.created_at | datetimeFormat %)</td>    
</tr>
