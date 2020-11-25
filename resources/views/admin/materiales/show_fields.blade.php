<tr>
	<td>{!! Form::label('id', 'Id') !!}</td>
	<td>(% selectedItem.id %)</td>    
</tr>

<tr>
	<td>{!! Form::label('user_id', 'Usuario') !!}</td>
	<td>(% selectedItem.usuario.nombre + ' ' + selectedItem.usuario.apellido %)</td>    
</tr>

<tr>
	<td>{!! Form::label('sucursal_id', 'Sucursal') !!}</td>
	<td>(% selectedItem.sucursal.nombre %)</td>    
</tr>
<tr>
	<td>{!! Form::label('sucursal_id', 'Retail') !!}</td>
	<td>(% selectedItem.sucursal.retail.nombre %)</td>    
</tr>
<tr>
	<td>{!! Form::label('sucursal_id', 'Pais') !!}</td>
	<td>(% selectedItem.sucursal.retail.pais.nombre %)</td>    
</tr>

<tr>
	<td>{!! Form::label('tipo', 'Tipo') !!}</td>
	<td>(% selectedItem.tipo === 'P' ? 'POP' : 'Foto sucursal' %)</td>    
</tr>

<tr>
	<td>{!! Form::label('imagen', 'Imagen') !!}</td>
	<td>
		<a :href="selectedItem.imagen_url" target="_blank">
			<img style="width:50px" :src="selectedItem.imagen_url">
		</a>
	</td>    
</tr>

<tr>
	<td>{!! Form::label('descripcion', 'Descripcion') !!}</td>
	<td>(% selectedItem.descripcion %)</td>    
</tr>

<tr>
	<td>{!! Form::label('created_at', 'Created At') !!}</td>
	<td>(% selectedItem.created_at %)</td>    
</tr>

<tr>
	<td>{!! Form::label('updated_at', 'Updated At') !!}</td>
	<td>(% selectedItem.updated_at %)</td>    
</tr>

