@extends('admin.layout.app')

@section('css')
<link href="{{ asset('/admin_style/assets/select2/select2.css') }}" 						type="text/css" 	rel="stylesheet">
<style>
	.form-group{
		margin-left:0px!important;
		margin-right:0px!important;
	}
</style>
@endsection

@section('content')
<div>
	<div class="panel">
        <div class="panel-heading nopaddingbottom">
            <h4 class="panel-title">Edición del Programa</h4>
            <p>Introduzca la información del programa.</p>
        </div>

        <div class="panel-body">

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

            <hr>
            
            <form id="basicForm"  class="form-horizontal"  method="POST" enctype="multipart/form-data" action="{{ url('programas',$d->programa_id) }}">
			    @if($d->programa_id != "") {{ method_field('PATCH') }} @endif
			    <input name="id" type="hidden" value="{{ $d->programa_id     }}"/>
			    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Nombre <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="nombre" class="form-control" placeholder="Escriba el nombre del programa..." required="" aria-required="true" value="{{ $d->nombre }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Acrónimo </label>
                    <div class="col-sm-8">
					    <input type="text" name="acronimo" class="form-control" placeholder="Escriba el acrónimo del programa..." required="" aria-required="true" value="{{ $d->acronimo }}">
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-sm-3 control-label">Secretarias <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <select id="secretarias" class="select2" name="secretaria" style="width: 100%">
                            <option value="">Seleccione</option>
                            @foreach($secretarias as $secretaria)
                            <option value="{{ $secretaria->secretaria_id }}" @if($secretaria->secretaria_id == $d->secretaria_id) selected="selected" @endif>{{ $secretaria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-sm-3 control-label">Sub-secretaría</label>
                    <div class="col-sm-8">
                        <select id="subsecretarias" class="select2" name="subsecretaria" style="width: 100%">
                            <option value="">Seleccione</option>
                            @foreach($subsecretarias as $subsecretaria)
                            <option value="{{ $subsecretaria->subsecretaria_id }}" @if($subsecretaria->subsecretaria_id == $d->subsecretaria_id) selected="selected" @endif>{{ $subsecretaria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-8">
                        <select id="direcciones" class="select2" name="direccion" style="width: 100%">
                            <option value="">Seleccione</option>
                            @foreach($direcciones as $direccion)
                            <option value="{{ $direccion->direccion_id }}" @if($direccion->direccion_id == $d->direccion_id) selected="selected" @endif>{{ $direccion->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-sm-3 control-label">Estado</label>
                    <div class="col-sm-8">
                        <select id="estado" class="select2" name="estado_registro_id" style="width: 100%">
                            @foreach($estados as $estado)
                            <option value="{{ $estado->estado_registro_id }}" @if($estado->estado_registro_id == $d->estado_registro_id) selected="selected" @endif>{{ $estado->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button class="btn btn-success btn-quirk btn-wide mr5">Actualizar</button>
                        <button class="btn btn-success btn-quirk btn-wide mr5" onclick="eliminar( {{ $d->programa_id }} );return false"><i class="fa fa-trash"></i> Eliminar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="eliminar+{{ $d->programa_id }}" action="{{ url('programas').'/'.$d->programa_id }}" method="POST" style="display: none;">
    <input type="hidden" value="{{ $d->id }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
</form>
@endsection

@section('js')
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("/admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script>

    $('#subsecretarias').select2();
    $('#direcciones').select2();
    $('#estado').select2();

    let secretarias     = JSON.parse('{!! $secretarias !!}');
    let subsecretarias  = JSON.parse('{!! $subsecretarias !!}');
    let direcciones     = JSON.parse('{!! $direcciones !!}');

    $('#secretarias').select2().on('change', function (e) {
        let newOptions = '<option value="">Seleccione</option>';
        $('#direcciones').select2('destroy').html(newOptions).prop("disabled", true).select2();
        for(let id in subsecretarias){
            if( subsecretarias[id].secretaria_id == $(this).val() ){
                newOptions += '<option value="'+ subsecretarias[id].subsecretaria_id +'">'+ subsecretarias[id].nombre +'</option>';
            }
        }
        $('#subsecretarias').select2('destroy').html(newOptions).prop("disabled", false).select2().on('change', function(e){
            let newOptions = '<option value="">Seleccione</option>';
            for(let id in direcciones){
                if( direcciones[id].subsecretaria_id == $(this).val() ){
                    newOptions += '<option value="'+ direcciones[id].direccion_id +'">'+ direcciones[id].nombre +'</option>';
                }
            }
            $('#direcciones').select2('destroy').html(newOptions).prop("disabled", false).select2();
        });
    });
    // $('#subsecretarias').prop("disabled", false).select2();
    // $('#direcciones').prop("disabled", false).select2();
    function eliminar(id){
        swal({
        	title: '{{ env("APP_NAME") }}',
            text: '¿Está seguro de eliminar este Programa?',
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