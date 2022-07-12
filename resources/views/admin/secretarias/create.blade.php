@extends('admin.layout.app')
@section('css')
<link href="{{ asset('/admin_style/assets/select2/select2.css') }}" 						type="text/css" 	rel="stylesheet">
<style>
</style>
@endsection

@section('content')
<div>
	<div class="panel">
        <div class="panel-heading nopaddingbottom">
            <h4 class="panel-title">ALTA DE PROGRAMA</h4>
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
                <form id="basicForm" method="POST"  action="{{ url('programas',$d->id) }}" class="form-horizontal" novalidate="novalidate">
                    @if($d->id != "") {{ method_field('PATCH') }} @endif
                    <input name="id" type="hidden" value="{{ $d->id }}"/>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="nombre" class="form-control" placeholder="Escriba el nombre del programa..." required="" aria-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Acrónimo </label>
                        <div class="col-sm-8">
					        <input type="text" name="acronimo" class="form-control" placeholder="Escriba el acrónimo del programa..." required="" aria-required="true">
                        </div>
                    </div>

				    <div class="form-group">
                        <label class="col-sm-3 control-label">Secretarias <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select id="secretarias" class="select2" name="secretaria" style="width: 100%">
                                <option value="">Seleccione</option>
                                @foreach($secretarias as $secretaria)
                                <option value="{{ $secretaria->secretaria_id }}">{{ $secretaria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

				    <div class="form-group">
                        <label class="col-sm-3 control-label">Sub-secretaría</label>
                        <div class="col-sm-8">
                            <select id="subsecretarias" class="select2" name="subsecretaria" style="width: 100%">
                            </select>
                        </div>
                    </div>

				    <div class="form-group">
                        <label class="col-sm-3 control-label">Dirección</label>
                        <div class="col-sm-8">
                            <select id="direcciones" class="select2" name="direccion" style="width: 100%">
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit"   class="btn btn-success btn-quirk btn-wide mr5">Dar de alta</button>
                        </div>
                    </div>

                </form>
            </div><!-- panel-body -->
        </div>
</div>



@endsection
@section('js')
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script>
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
    $('#subsecretarias').prop("disabled", true).select2();
    $('#direcciones').prop("disabled", true).select2();

</script>
@endsection