@extends('admin.layout.app')

@section('css')
<link href='{{ asset("admin_style/assets/sweetalert2/sweetalert2.min.css") }}' type="text/css"     rel="stylesheet"></link>
@endsection

@section('content')
<div class="panel">
	
	<div class="panel-heading">
		<h4 class="panel-title">Grupos</h4>
		<p class="nomargin">{{ env('APP_NAME')}}</p>
	</div>

	<div class="panel-body nopadding">
		<form method="POST" enctype="multipart/form-data" action="{{ url('roles',$d->id) }}" class="col-md-12 form-horizontal">

			@if($d->id != "") {{ method_field('PATCH') }} @endif
			<input name="id" type="hidden" value="{{ $d->id }}"/>
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

			<div class="form-group">
				<label class="col-md-1 control-label">Nombre</label>
		        <div class="col-md-7">
					<input type="text" placeholder="Name" class="form-control" name="name" value="{{ $d->name }}">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-1 control-label">Descripción</label>
		        <div class="col-md-7">
					<input type="text" placeholder="label" class="form-control" name="label" value="{{ $d->label }}">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-1 control-label">Permisos</label>
		        <div class="col-md-7">
					@foreach ($permissions as $permission)
				 	<div class="checkbox">
				    	<label>
				      		<input name="permission[]" id="{{$permission->id}}" value="{{$permission->id}}" type="checkbox" @if( $d->hasPermission($permission->name)  ) checked @endif> {{ $permission->label }}
				    	</label>
				  	</div>
				  	@endforeach
				</div>
			</div>
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
			<input name="id" type="hidden" value="{{ $d->id }}"/>
			<div class="form-group">
				<div class="col-md-6 col-md-offset-1">
                	<button type="submit" name="submit" class="btn-xs btn-success"><i class="fa fa-save"></i> Guardar</button>
               		<button href="javascript:void(0)" class="btn-xs btn-success" onclick="eliminar({{ $d->id }});return false;"><i class="fa fa-trash"></i> Eliminar</button>
				</div>
			</div>
		</form>

		<form id="eliminar+{{ $d->id }}" action="{{ url('roles').'/'.$d->id }}" method="POST" style="display: none;">
			<input type="hidden" value="{{ $d->id }}">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
		</form>	

	</div>
</div>
@endsection

@section('js')
<script src='{{ asset("admin_style/assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script type="text/javascript">
	function eliminar(id){
        swal({
        	title: '{{ env("APP_NAME") }}',
            text: '¿Está seguro de eliminar este Role?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText:  'Cancelar',
		}).then((result) => {
		  	if (result) {
    			document.getElementById('eliminar+'+id).submit();
		  	}
		});
    }
</script>
@endsection