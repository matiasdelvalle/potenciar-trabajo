@extends('admin.layout.app')

@section('css')
<link href="{{ asset('/assets/toastr/toastr.min.css') }}" 						type="text/css"     rel="stylesheet">
<link href="{{ asset('/assets/select2/select2.css') }}"    						type="text/css"     rel="stylesheet">
<link href="{{ asset('assets/animate/animate.css') }}"    						type="text/css"     rel="stylesheet">
<link href="{{ asset('/assets/bootstrap-datepicker/css/datepicker.css') }}"   	type="text/css"     rel="stylesheet">
<link href="{{ asset('/assets/sweetalert2/sweetalert2.min.css') }}" 			type="text/css" 	rel="stylesheet">
@endsection


@section('content')
<div class="panel">

	<div class="panel-heading">
		<h4 class="panel-title">Permisos</h4>
		<p class="nomargin">{{ env('APP_NAME')}}</p>
	</div>

	<div class="panel-body nopadding">
		<div class="col-md-12  table-responsive">
			<table class="table table-hover table-striped nomargin">
	            <thead>
	              <tr>
	                <th class="col_4" style="padding:10px;">Usuario</th>
	                <th class="col_4" style="padding:10px;">Roles</th>
	                <th class="col_4" style="padding:10px;"></th>
	              </tr>
	            </thead>
				<tbody>

	            </tbody>
			</table>

			<a href="{{ url('admin/usuarios/create') }}" class="btn btn-create" data-toggle="tooltip" title="Agregar Usuario" data-placement="left">
				<i class="s-iconz__size icon-File-Edit"></i>
			</a>
		</div>
	</div>

</div>
@endsection

@section('js')
<script src="{{ asset('assets/select2/select2.full.js') }}"></script>
<script type="text/javascript">
	$('.select2').select2();
</script>
@endsection

