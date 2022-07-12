@extends('admin.layout.app')

@section('css')
<link href='{{ asset("assets/sweetalert2/sweetalert2.min.css") }}' type="text/css"     rel="stylesheet"></link>
<style>
.datos_personales,
.datos_parlamentarios,
.contacto,
.oficina,
.direcciones{
	/*display: none;*/
}
.upermisos{
	font-weight: normal;
	color:#676c6c;
	cursor: pointer;
	padding-top:5px;
}
.form-control, .select2{
	margin-bottom: 20px;
}

</style>
@endsection

@section('content')
<div class="panel">
	
	<div class="panel-heading">
		<h4 class="panel-title">Usuarios</h4>
		<!--<p class="nomargin">{{ env('APP_NAME')}}</p>-->
	</div>


	<div class="panel-body nopadding">

		@if (count($errors) > 0)
			<div class="col-md-12">
			    <div class="alert alert-danger col-md-12">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			</div>
		@endif


		<form method="POST" enctype="multipart/form-data" action="{{ url('admin/permisos',$d->id) }}" class="col-md-12">
			<div class="row">
				@if($d->id != ""	) {{ method_field('PATCH') }} @endif
				<input name="id" type="hidden" value="{{ $d->id }}"/>
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				<div class="col-md-12">
					<div class="col-md-12 form-horizontal">
						
					</div>
				</div>
			</div>
			<div class="col-md-12" style="margin-top: 10px">
				<div class="form-group">
					<div class="col-md-6">
						<button type="submit" name="submit" class="btn-xs btn-success" id="submit"><i class="fa fa-save"></i> Guardar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection


@section('js')
<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script type="text/javascript">
</script>
@endsection