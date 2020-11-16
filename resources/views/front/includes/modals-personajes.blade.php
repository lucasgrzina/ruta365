<div class="modal fade modal-personajes" id="modal-boy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Selecciona al protagonista de la historia</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					@foreach ($data['miCuento']['info']['personajes']['boy'] as $k => $item)
						<div :class="{'col-6 col-sm-4 col-md-2 text-center mb-3 col-personaje': true,'active': miCuento.form.personaje === '{{$item}}'}" class="">
							<img src="{{ asset('images/boy-0'.($k+1).'.png') }}" alt="Niño" title="Niño" @click="seleccionarPersonaje('boy','{{$item}}')" width="70">
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-personajes" id="modal-girl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Selecciona al protagonista de la historia</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					@foreach ($data['miCuento']['info']['personajes']['girl'] as $k => $item)
						<div :class="{'col-6 col-sm-4 col-md-2 text-center mb-3 col-personaje': true,'active': miCuento.form.personaje === '{{$item}}'}" class="">
							<img src="{{ asset('images/girl-0'.($k+1).'.png') }}" alt="Niña" title="Niña" @click="seleccionarPersonaje('girl','{{$item}}')">
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>