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


		<form method="POST" enctype="multipart/form-data" action="{{ url('usuarios',$d->id) }}" class="col-md-12">
			<div class="row">
				@if($d->id != "") {{ method_field('PATCH') }} @endif
				<input name="id" type="hidden" value="{{ $d->id }}" />
				<input name="_token" type="hidden" value="{{ csrf_token() }}" />

				<div class="col-md-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 cl-lg-6">
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">E-mail:</label>
									<input type="text" placeholder="E-mail" class="form-control email" name="email" value="{{ $d->email }}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Nombre:</label>
									<input type="text" placeholder="nombre" class="form-control nombres" name="nombre" value="{{ $d->name }}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Telefono:</label>
									<input type="text" placeholder="Telefono" class="form-control" name="telefono" value="{{ $d->telefono }}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Funcion:</label>
									<select name="funcion" id="" class="select2" style="width:100%">
										<option value="">Seleccione</option>
										@foreach($funciones as $f)
										@if($d->id)
										<option @if( $f->funcion_id == $d->funcion ) selected="selected" @endif value="{{ $f->funcion_id }}">{{ $f->nombre }}</option>
										@else
										<option value="{{ $f->funcion_id }}">{{ $f->nombre }}</option>
										@endif
										@endforeach
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Contraseña Nueva:</label>
									<input type="password" placeholder="Contraseña Nueva" class="form-control" name="password">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label">Confirmar Contraseña:</label>
									<input type="password" placeholder="Confirmar Contraseña" class="form-control" name="password_confirmation">
								</div>
							</div>
						</div>

						<div class=" col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
							<div class="form-group box-select-roles">
								<label class="control-label label-seleccion">Seleccione los roles del usuario (1 mínimo)</label>
								<div>
									@foreach ($roles as $role)
									@if(Auth::user()->hasRole('admin'))
									<div class="checkbox">
										<label class="label-select">
											<input name="role[]" id="{{$role->id}}" value="{{$role->id}}" type="checkbox" @if( $d->hasRole($role->name) ) checked @endif> {{ $role->label }}
										</label>
									</div>
									@elseif( Auth::user()->hasRole($role->name) )
									<div class="checkbox">
										<label class="label-select">
											<input name="role[]" id="roles-{{$role->id}}" value="{{$role->id}}" type="checkbox" @if( $d->hasRole($role->name) ) checked @endif> {{ $role->label }}
										</label>
									</div>
									@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
					<div class="buttons-save">
						<button type="submit" name="submit" class="btn-xs btn-success" id="submit"><i class="fa fa-save"></i> Guardar</button>
						<button class="btn-xs btn-success" onclick="eliminar( {{ $d->id }} );return false"><i class="fa fa-trash"></i> Eliminar</a>
					</div>
				</div>
				<div class="col-md-5">
					<div class="col-md-12" style="margin: 20px 0">
					</div>
					<div class="col-md-12" style="margin: 20px 0">
					</div>
					<div class="col-md-12" style="margin: 20px 0">
					</div>
				</div>
			</div>
		</form>
		<form id="eliminar+{{ $d->id }}" action="{{ url('usuarios').'/'.$d->id }}" method="POST" style="display: none;">
			<input type="hidden" value="{{ $d->id }}">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection


@section('js')
<script src='{{ asset("admin_style/assets/toastr/toastr.min.js") }}'></script>
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script type="text/javascript">
	$('.select2').select2();
	function eliminar(id) {
		swal({
			title: '{{ env("APP_NAME") }}',
			text: '¿Está seguro de eliminar este Usuario?',
			showCloseButton: true,
			showCancelButton: true,
			confirmButtonText: 'Eliminar',
			cancelButtonText: 'Cancelar',
		}).then((result) => {
			if (result) {
				document.getElementById('eliminar+' + id).submit();
			}
		});
	}
</script>
@endsection