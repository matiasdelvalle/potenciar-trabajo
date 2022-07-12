@extends('admin.layout.app')

@section('css')
<link href="{{ asset('/admin_style/assets/select2/select2.css') }}" 						type="text/css" 	rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
<style>
	.form-group{
		margin-left:0px!important;
		margin-right:0px!important;
	}
</style>
@endsection

@section('content')
<div>
	<div class="panel" id="app" data-app>
        <div class="panel-heading nopaddingbottom">
            <h4 class="panel-title">Edición de Secretaria</h4>
            <p>Introduzca la información de la secretaria.</p>
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
            
            <form id="basicForm"  class="form-horizontal"  method="POST" enctype="multipart/form-data" action="{{ url('secretarias',$d->secretaria_id) }}">
			    @if($d->secretaria_id != "") {{ method_field('PATCH') }} @endif
			    <input name="id"     type="hidden" value="{{ $d->secretaria_id }}"/>
			    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                <v-row>
                    <v-col cols="3">
                        <v-subheader>Secretaria</v-subheader>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field label="Secretaria" placeholder="Escriba el nombre de la secretaria..." name="nombre" value="{{ $d->nombre }}" required></v-text-field>
                    </v-col>
                </v-row>

                @if($d->secretaria_id)
                <v-row>
                    <v-col cols="3">
                        <v-subheader>Estado</v-subheader>
                    </v-col>
                    <v-col cols="4">
                        <v-select 
                            label="Estado" 
                            placeholder="Estado..." 
                            name="estado_registro_id"  
                            v-model="estado"
                            :items="items"
                            item-text="descripcion"
                            item-value="estado_registro_id">
                        </v-select>
                    </v-col>
                </v-row>                
                
                @endif

                <hr>
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button class="btn btn-success btn-quirk btn-wide mr5">Actualizar</button>
                        @if($d->secretaria_id)
                        <button class="btn btn-success btn-quirk btn-wide mr5" onclick="eliminar( {{ $d->secretaria_id }} );return false" style="display:none"><i class="fa fa-trash"></i> Eliminar</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="eliminar+{{ $d->secretaria_id }}" action="{{ url('secretarias').'/'.$d->secretaria_id }}" method="POST" style="display: none;">
    <input type="hidden" value="{{ $d->secretaria_id }}">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
</form>
@endsection

@section('js')
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("/admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    // $('#estado').select2();
    function eliminar(id){
        swal({
        	title: '{{ env("APP_NAME") }}',
            text: '¿Está seguro de eliminar esta Secretaria?',
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
    const app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            estado: {{ isset($d->estado_registro_id) ? $d->estado_registro_id : 0 }},
            items: {!! $estados !!}
        }),      
    })
  </script>
@endsection