<tr>
	<td>{!! Form::label('id', 'Id') !!}</td>
	<td>(% selectedItem.id %)</td>    
</tr>

<tr>
	<td>{!! Form::label('nombre', 'Nombre') !!}</td>
	<td>(% selectedItem.nombre %)</td>    
</tr>

<tr>
	<td>{!! Form::label('pais_id', 'Pais') !!}</td>
	<td>(% selectedItem.pais ? selectedItem.pais.nombre : '--' %)</td>    
</tr>

<tr>
	<td>{!! Form::label('logo', 'Logo') !!}</td>
	<td><img :src="selectedItem.logo_url" class="img-responsive" style="max-width: 50px;"></td>    
</tr>

<tr>
	<td>{!! Form::label('color_hexa', 'Color Hexa') !!}</td>
	<td>(% selectedItem.color_hexa %)</td>    
</tr>

<tr>
	<td>{!! Form::label('created_at', 'Created At') !!}</td>
	<td>(% selectedItem.created_at %)</td>    
</tr>

<tr>
	<td>{!! Form::label('updated_at', 'Updated At') !!}</td>
	<td>(% selectedItem.updated_at %)</td>    
</tr>

