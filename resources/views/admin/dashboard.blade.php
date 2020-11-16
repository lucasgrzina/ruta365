@extends('layouts.app')
@section('scripts')
    @parent
    <script type="text/javascript">
		var _data = {!! json_encode($data) !!};

    </script>
@endsection
@section('content')
<div class="container">
    <div class="row">
    	<div class="col-xs-12">
    		<h1>Bienvenido</h1>
			<p>Seleccioná una opción del menú de la izquierda para comenzar.</p>	
    	</div>
	</div>
    <div class="row">
    	<div class="col-xs-6">
    	</div>
	</div>	
</div>
@endsection
