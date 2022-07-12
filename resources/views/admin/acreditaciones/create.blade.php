@extends('admin.layout.app')
@section('css')
<link href="{{ asset('/admin_style/assets/select2/select2.css') }}" 						type="text/css" 	rel="stylesheet">
<link href="{{ asset('/admin_style/assets/bootstrap-datepicker/css/datepicker.css') }}"   	type="text/css"     rel="stylesheet">
@endsection

@section('content')
<div>
	<div class="panel">
        <div class="panel-heading nopaddingbottom">
            <h4 class="panel-title">ALTA DE ACREDITACIONES</h4>
            <p>Introduzca la información de la acreditación.</p>
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
                <form id="basicForm" method="POST"  action="{{ url('acreditaciones',$d->entidad_id) }}" class="form-horizontal" novalidate="novalidate">
                    @if($d->entidad_id != "") {{ method_field('PATCH') }} @endif
                    <input name="id" type="hidden" value="{{ $d->entidad_id }}"/>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Razon Social <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="razon_social" class="form-control" placeholder="Escriba el nombre del programa..." required="" aria-required="true" value="{{ $d->razon_social }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cuit <span class="text-danger">*</span> </label>
                        <div class="col-sm-8">
					        <input type="text" name="cuit" maxlength="13" class="form-control" placeholder="Escriba el CUIT del programa..." required="" aria-required="true" value="{{ $d->cuit }}">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Expediente GDE </label>
                        <div class="col-sm-8">
					        <input type="text" name="expediente" class="form-control" placeholder="Escriba el expediente del programa..." required="" aria-required="true"  value="{{ $d->expediente }}">
                        </div>
                    </div>

                    <div class="form-group hide">
                        <label class="col-sm-3 control-label">Memo</label>
                        <div class="col-sm-8">
					        <input type="text" name="memo" class="form-control" placeholder="Escriba memo..." required="" aria-required="true"  value="{{ $d->memo }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">RLM</label>
                        <div class="col-sm-8">
					        <input type="text" name="rlm" class="form-control" placeholder="Escriba la rlm..." required="" aria-required="true" value="{{ $d->rlm }}">
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Resolución</label>
                        <div class="col-sm-8">
					        <input type="text" name="resolucion" class="form-control" placeholder="Resolución..." required="" aria-required="true" value="{{ $d->resolucion }}">
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">IF</label>
                        <div class="col-sm-8">
                            <input type="text" name="if" class="form-control" placeholder="IF..." required="" aria-required="true" value="{{ $d->if }}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Re</label>
                        <div class="col-sm-8">
                            <input type="text" name="re" class="form-control" placeholder="Re..." required="" aria-required="true" value="{{ $d->re }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Providencia</label>
                        <div class="col-sm-8">
                            <input type="text" name="providencia" class="form-control" placeholder="Providencia..." required="" aria-required="true" value="{{ $d->providencia }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Fecha Vigencia Autoridades</label>
                        <div class="col-sm-8">
                            <input type="text"  class="form-control fecha_vigencia_autoridades_text" placeholder="Fecha Vigencia Autoridades..." required="" aria-required="true" value="{{ $d->fecha_vigencia_autoridades ? \Carbon\Carbon::parse($d->fecha_vigencia_autoridades)->format('d-m-Y') : '' }}">
                            <input type="hidden" name="fecha_vigencia_autoridades" class="form-control fecha_vigencia_autoridades" value="{{ $d->fecha_vigencia_autoridades }}">
                        </div>
                    </div>

                    <div class="text-center"><p><b>CARACTERISTICAS</b></p></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tipo Conformación</label>
                        <div class="col-sm-8">
                            <select name="estatal_id" id="estatal_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->estatal)
                                <option value="{{ $d->estatal_id }}" selected="selected">{{ $d->estatal->descripcion }}</option>
                                @endif
                            </select>
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Forma Juridica </label>
                        <div class="col-sm-8">
                            <select name="forma_juridica_id" id="forma_juridica_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->FormasJuridicas)
                                <option value="{{ $d->forma_juridica_id }}" selected="selected">{{ $d->FormasJuridicas->descripcion }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Programa </label>
                        <div class="col-sm-8">
                            <select name="programa_id" id="programa_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->programa)
                                <option value="{{ $d->programa_id }}" selected="selected">{{ $d->programa->nombre }}</option>
                                @endif
                            </select>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Repartición </label>
                        <div class="col-sm-8">
                            <select name="reparticion_id" id="reparticion_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->reparticion)
                                <option value="{{ $d->reparticion_id }}" selected="selected">{{ $d->reparticion->descripcion }}</option>
                                @endif                                
                            </select>                            
                        </div>
                    </div>
                    
                    <div class="text-center"><p><b>DIRECCION REAL</b></p></div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Dirección Real </label>
                        <div class="col-sm-8">
					        <input type="text" name="dl_direccion" class="form-control" placeholder="Escriba la dirección real..." required="" aria-required="true"  value="{{ $d->dl_direccion }}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provincia Real </label>
                        <div class="col-sm-8">
                            <select name="dl_provincia_id" id="dl_provincia_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->provinciadl)
                                <option value="{{ $d->dl_provincia_id }}" selected="selected">{{ $d->provinciadl->nombre }}</option>
                                @endif                                
                            </select>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Municipio Real</label>
                        <div class="col-sm-8">
                            <select name="dl_municipio_id" id="dl_municipio_id_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->municipiodl)
                                <option value="{{ $d->dl_municipio_id }}" selected="selected">{{ $d->municipiodl->nombre }}</option>
                                @endif                                
                            </select>
                        </div>
                    </div>                    
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Localidad Real </label>
                        <div class="col-sm-8">
                            <select name="dl_localidad_id" id="dl_localidad_id_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->localidaddl)
                                <option value="{{ $d->dl_localidad_id }}" selected="selected">{{ $d->localidaddl->nombre }}</option>
                                @endif                                
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="text-center"><p><b>DIRECCION FISCAL</b></p></div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Dirección Fiscal</label>
                        <div class="col-sm-8">
					        <input type="text" name="df_direccion" class="form-control" placeholder="Escriba la dirección fiscal..." required="" aria-required="true" value="{{ $d->df_direccion }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provincia Fiscal </label>
                        <div class="col-sm-8">
                            <select name="df_provincia_id" id="df_provincia_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->provinciadf)
                                <option value="{{ $d->df_provincia_id }}" selected="selected">{{ $d->provinciadf->nombre }}</option>
                                @endif                                
                            </select>
                        </div>
                    </div>


                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Municipio Fiscal</label>
                        <div class="col-sm-8">
                            <select name="df_municipio_id" id="df_municipio_id_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->municipiodf)
                                <option value="{{ $d->df_municipio_id }}" selected="selected">{{ $d->municipiodf->nombre }}</option>
                                @endif                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Localidad Fiscal </label>
                        <div class="col-sm-8">
                            <select name="df_localidad_id" id="df_localidad_id_select2" class="form-control" style="width:100%">
                                <option value="">Seleccione</option>
                                @if($d->localidaddf)
                                <option value="{{ $d->df_localidad_id }}" selected="selected">{{ $d->localidaddf->nombre }}</option>
                                @endif                                
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-center"><p><b>OTROS</b></p></div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Certificado Vigencia</label>
                        <div class="col-sm-8">
					        <input type="text" name="certificado_vigencia" class="form-control" placeholder="Escriba la dirección fiscal..." required="" aria-required="true" value="{{ $d->certificado_vigencia }}">
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Convenio</label>
                        <div class="col-sm-8">
					        <input type="text" name="convenio" class="form-control" placeholder="Escriba el Convenio..." required="" aria-required="true" value="{{ $d->convenio }}">
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Devolucion</label>
                        <div class="col-sm-8">
					        <input type="text" name="devolucion" class="form-control" placeholder="Escriba la Devolución..." required="" aria-required="true"  value="{{ $d->devolucion }}">
                        </div>
                    </div>
                    
                    
                    @if($d->entidad_id)
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Estado Registro</label>
                        <div class="col-sm-8">
                            <select id="estado_registro_select2" class="form-control" name="estado_registro_id" style="width: 100%">
                                <option value="">Seleccione</option>
                                @if($d->estado)
                                <option value="{{ $d->estado_registro_id }}" selected="selected">{{ $d->estado->descripcion }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit"   class="btn btn-success btn-quirk btn-wide mr5">
                                @if($d->entidad_id)
                                Actualizar
                                @else
                                Dar de alta
                                @endif
                            </button>
                            @if($d->entidad_id)
                            <button class="btn btn-danger btn-quirk btn-wide mr5" onclick="eliminar( {{ $d->entidad_id }}, event );return false"><i class="fa fa-trash"></i> Eliminar</button>
                            <a class="btn btn-warning btn-quirk btn-wide mr5" href="{{ url('acreditaciones/'.$d->entidad_id) }}">Volver </a>
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        </div>
</div>

<form id="eliminar+{{ $d->entidad_id }}" action="{{ url('acreditaciones').'/'.$d->entidad_id }}" method="POST" style="display: none;">
    <input type="hidden" value="{{ $d->entidad_id }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
</form>


@endsection
@section('js')
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("/admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script src="{{ asset('/admin_style/assets/moment/moment-with-locales.min.js')}}"></script>
<script src='{{ asset("/admin_style/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}'></script>
<script src='{{ asset("/admin_style/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js") }}'></script>
<script>

    function eliminar(id,event ){
        event.preventDefault();
        swal({
        	title: '{{ env("APP_NAME") }}',
            text: '¿Está seguro de eliminar esta Acreditación?',
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

    $('#forma_juridica_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    tipo: 'forma_juridica'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#programa_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    tipo: 'programa'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#reparticion_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    tipo: 'reparticion'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });    

    $('#estatal_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    tipo: 'estatal_tipos'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#df_provincia_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    tipo: 'provincia'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#df_municipio_id_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    provincia_id: $('#df_provincia_select2').val(),
                    search: params.term,
                    tipo: 'municipio'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#df_localidad_id_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    provincia_id: $('#df_provincia_select2').val(),
                    municipio_id: $('#df_municipio_id_select2').val(),
                    search: params.term,
                    tipo: 'localidad'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#dl_provincia_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    tipo: 'provincia'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#dl_municipio_id_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    provincia_id: $('#dl_provincia_select2').val(),
                    search: params.term,
                    tipo: 'municipio'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });

    $('#dl_localidad_id_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    provincia_id: $('#dl_provincia_select2').val(),
                    municipio_id: $('#dl_municipio_id_select2').val(),
                    search: params.term,
                    tipo: 'localidad'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });    
    $('#estado_registro_select2').select2({
        ajax: {
            url: '{{ url("api/v1/autocomplete") }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    tipo: 'estado_registro'
                }
                return query;
            },
            dataType: 'json',
        },
        minimumInputLength: 0,
    });    
    $('.fecha_vigencia_autoridades_text').datepicker({
        format: 'dd-mm-yyyy',
		autoclose: true,
        setDate: null
	}).on('changeDate', function(ev) {
        $('.fecha_vigencia_autoridades').val( moment( new Date(ev.date) ).format('Y-MM-DD') );
    });
</script>
@endsection