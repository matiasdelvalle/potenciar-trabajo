@extends('admin.layout.app')

@section('css')
<link href='{{ asset("admin_style/assets/sweetalert2/sweetalert2.min.css") }}' type="text/css" rel="stylesheet">
</link>
<style>
	.upermisos {
		font-weight: normal;
		color: #676c6c;
		cursor: pointer;
		padding-top: 5px;
	}

	.form-control,
	.select2 {
		margin-bottom: 20px;
	}
</style>
@endsection

@section('content')
<div class="panel">

	<div class="panel-heading">
		<h4 class="panel-title">Usuarios</h4>
		<p class="nomargin">{{ env('APP_NAME')}}</p>
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


		<form method="POST" enctype="multipart/form-data" action="{{ url('cambiarpass') }}" class="col-md-12">
			<div class="row">
				<input name="id" type="hidden" value="{{ $d->id }}" />
				<input name="_token" type="hidden" value="{{ csrf_token() }}" />

				<div class="col-md-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 cl-lg-6">
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">E-mail:</label>
									<input type="text" placeholder="E-mail" class="form-control email" name="email" value="{{ $d->email }}" readonly>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Nombre:</label>
									<input type="text" placeholder="nombre" class="form-control nombres" name="nombre" value="{{ $d->name }}" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Contraseña Actual:</label>
									<input type="password" placeholder="Contraseña Actual" class="form-control" name="password_actual">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Contraseña Nueva:</label>
									<input type="password" placeholder="Contraseña Actual" class="form-control" name="password">
								</div>
							</div>                            
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Confirmar Contraseña:</label>
									<input type="password" placeholder="Confirmar Contraseña" class="form-control" name="password_confirmation">
								</div>
							</div>
						</div>


					</div>
					<div class="buttons-save">
						<button type="submit" name="submit" class="btn-xs btn-success" id="submit"><i class="fa fa-save"></i> Guardar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection


@section('js')
<script src='{{ asset("admin_style/assets/toastr/toastr.min.js") }}'></script>
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
@endsection