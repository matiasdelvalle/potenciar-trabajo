@extends('admin.layout.app')

@section('css')
<style>
    .select2-container {
        z-index: 9999;
    }
    
</style>
@endsection

@section('content')

<ol class="breadcrumb breadcrumb-quirk">
    <li><a href="{{ url('/') }}"><i class="fa fa-home mr5"></i> Inicio</a></li>
    <li><a href="{{ url('programas') }}">Programas</a></li>
    <li class="active">Detalle de Programa</li>
</ol>

<div class="" id="app">

    <div class="detalle-programa">
        <div class="card-programa__info">
            <div class="card-programa__autoridad-cabecera">
            <h1>{{ $d->nombre }}</h1>
            <div style="margin: 0;" class="item-programa div-edit">
                <a href="{{ url('programas') }}/{{ $d->programa_id }}/edit" class="btn-edit__style">
                    <i class="fa-solid fa-pen"></i>
                </a>
            </div>
            </div>
            <div class="underline"></div>
            <div class="gridPrograma-header">
            <div class="item-programa">
                <i class="fa fa-gear"></i> <span>Acrónimo</span>
                <h2>{{ $d->acronimo }}</h2>
            </div>
            <div class="item-programa">
                <i class="fa fa-building"></i> <span>Secretaría</span>
                <h2>{{ $d->secretaria ? $d->secretaria->nombre : '-'}}</h2>
            </div>

            <div class="item-programa">
                <i class="fa fa-building"></i> <span>Sub-secretaría</span>
                <h2>{{ $d->subsecretaria ? $d->subsecretaria->nombre : '-' }}</h2>
            </div>
            <div class="item-programa">
                <i class="fa fa-building"></i> <span>Dirección</span>
                <h2>{{ $d->direccion ? $d->direccion->nombre : '-' }}</h2>
            </div>
            </div>
           
        </div>
    </div>
    <div class="tabs effect-2">
        <!-- tab-title -->
        <input type="radio" id="tab-1" name="tab-effect-2" checked="checked">
        <span>
        <i class="fa-solid fa-user-tie"></i><span>Autoridades</span>
        </span>

        <input type="radio" id="tab-2" name="tab-effect-2">
        <span style="border-radius: 0 10px 0 0;">
        <i class="fa-solid fa-user-gear"></i><span>Técnicos</span>
        </span>

        

        <!-- tab-content -->
        <div class="tab-content">
            <section id="tab-item-1">
                <div class="no-data__grid" v-if="autoridades.length == 0">
                    <h2>Aún no hay autoridades cargadas</h2>
                    <button class="btn-add" id="add-autoridad" @click="createAutoridad"><i style="margin-right:5px" class="fa-solid fa-plus"></i> Cargar autoridad</button>
                </div>

                <div class="d-grid">
                    <div class="div-add-tecnico" v-if="autoridades.length > 0">
                       <button class="btn-add-tecnico" id="add-autoridad" @click="createAutoridad"> <i class="fa fa-user-plus d-block"></i> <span class="text-min"></span> </button>
                    </div>
                    <div class="card-programa__autoridad" v-for="autoridad in autoridades" v-if="autoridades.length > 0">
                        <div class="card-programa__autoridad-cabecera">
                            <div>
                                <h2>@{{ autoridad.apellido + ', '+autoridad.nombre }}</h2>
                            </div>
                            <div class="card-programa__iconos">
                                <button class="btn-edit" @click="$root.editAutoridad(autoridad)"> <i class="fa fa-pencil icon-edit"></i></button>
                                <button @click="$root.deleteAutoridad(autoridad.autoridad_id)"> <i class="fa fa-trash icon-trash"></i> </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div>
                                    <i class="fa fa-user"></i><span>Usuario</span>
                                    <h5>@{{ autoridad.usuario }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div>
                                    <i class="fa fa-at"></i><span>Mail</span>
                                    <h5>@{{ autoridad.mail }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div>
                                    <i class="fa fa-briefcase"></i> <span>Tipo de autoridad</span>
                                    <h5>@{{ autoridad.autoridad_tipo ? autoridad.autoridad_tipo.nombre : '-' }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div>
                                    <i class="fa fa-phone"></i><span>Teléfono</span>
                                    <h5>@{{ autoridad.telefono }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div>
                                    <i class="fa fa-eye"></i><span>Observaciones</span>
                                    <h5>@{{ autoridad.observaciones }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="tab-item-2">
                <div class="no-data__grid" v-if="tecnicos.length == 0">
                    <h2>Aún no hay técnicos cargados</h2>
                    <button class="btn-add" id="add-tecnico" @click="createTecnico"><i style="margin-right:5px" class="fa-solid fa-plus"></i> Cargar técnico</button>
                </div>
                <div class="">
              
                   <div class="d-grid">
                   <div class="div-add-tecnico" v-if="tecnicos.length > 0">
                       <button class="btn-add-tecnico" id="add-tecnico" @click="createTecnico"> <i class="fa fa-user-plus d-block"></i> <span class="text-min"></span> </button>
                    </div>
                <div class="card-programa__autoridad" v-for="tecnico in tecnicos" v-if="tecnicos.length > 0">
                    <div class="card-programa__autoridad-cabecera">
                        <div>
                            <h2>@{{ tecnico.apellido+', '+tecnico.nombre }}</h2>
                        </div>
                        <div class="card-programa__iconos">
                            <button class="btn-edit" @click="$root.editTecnico(tecnico)"> <i class="fa fa-pencil icon-edit"></i></button>
                            <button @click="$root.deleteTecnico(tecnico.tecnico_id)"> <i class="fa fa-trash icon-trash"></i> </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                            <div>
                                <i class="fa fa-user"></i><span>Usuario</span>
                                <h5>@{{ tecnico.usuario }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                            <div>
                                <i class="fa fa-at"></i><span>Mail</span>
                                <h5>@{{ tecnico.mail }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                            <div>
                                <i class="fa fa-phone"></i><span>Teléfono</span>
                                <h5>@{{ tecnico.telefono }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div>
                                <i class="fa fa-eye"></i><span>Observaciones</span>
                                <h5>@{{ tecnico.observaciones }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </section>
            <section id="tab-item-3">
                <h1>Dropzone</h1>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modal-autoridad" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Agregar Autoridad</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label for="autoridad_autoridad_tipo">Autoridad Tipo:</label>
                        <select name="autoridad_tipo" class="select2" style="width:100%" id="autoridad_tipo_id">
                            <option value="">Seleccione el tipo de autoridad</option>
                            <option v-for="a in autoridades_tipo" :value="a.autoridad_tipo_id">@{{ a.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_nombre">Nombre:</label>
                        <input class="form-control autoriddades_nombre" type="text" v-model="detalle.nombre" placeholder="Introduzca el nombre de la autoridad">
                        <label id="autoridades-nombre-error" class="error" for="autoridades_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_apellido">Apellido:</label>
                        <input class="form-control autoridades_apellido" type="text" v-model="detalle.apellido" placeholder="Introduzca el apellido de la autoridad">
                        <label id="autoridades-apellido-error" class="error" for="autoridades_apellido" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_usuario">Usuario gde:</label>
                        <input class="form-control" type="text" v-model="detalle.usuario" placeholder="Introduzca el usuario gde de la autoridad">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_telefono">Teléfono:</label>
                        <input class="form-control" type="text" v-model="detalle.telefono" placeholder="Introduzca el número de teléfono de la autoridad">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_mail">E-mail:</label>
                        <input class="form-control" type="text" v-model="detalle.mail" placeholder="Introduzca el e-mail de la autoridad">
                        <label id="autoridades-mail-error" class="error" for="autoridades_mail" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridad_observaciones">Observaciones:</label>
                        <input class="form-control" type="text" v-model="detalle.observaciones" placeholder="Introduzca las observaciones">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" @click="updateAutoridad" v-if="detalle.autoridad_id != null">Actualizar</button>
                        <button class="btn btn-success btn-crear" @click="storeAutoridad" v-if="detalle.autoridad_id == null">Agregar autoridad</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-autoridad2" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Editar Autoridad</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label for="autoridad_autoridad_tipo">Autoridad Tipo:</label>
                        <select name="autoridad_tipo" class="select2" style="width:100%" id="autoridad_tipo_id">
                            <option value="">Seleccione el tipo de autoridad</option>
                            <option v-for="a in autoridades_tipo" :value="a.autoridad_tipo_id">@{{ a.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_nombre">Nombre:</label>
                        <input class="form-control autoriddades_nombre" type="text" v-model="detalle.nombre" placeholder="Introduzca el nombre de la autoridad">
                        <label id="autoridades-nombre-error" class="error" for="autoridades_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_apellido">Apellido:</label>
                        <input class="form-control autoridades_apellido" type="text" v-model="detalle.apellido" placeholder="Introduzca el apellido de la autoridad">
                        <label id="autoridades-apellido-error" class="error" for="autoridades_apellido" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_usuario">Usuario gde:</label>
                        <input class="form-control" type="text" v-model="detalle.usuario" placeholder="Introduzca el usuario gde de la autoridad">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_telefono">Teléfono:</label>
                        <input class="form-control" type="text" v-model="detalle.telefono" placeholder="Introduzca el número de teléfono de la autoridad">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_mail">E-mail:</label>
                        <input class="form-control" type="text" v-model="detalle.mail" placeholder="Introduzca el e-mail de la autoridad">
                        <label id="autoridades-mail-error" class="error" for="autoridades_mail" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridad_observaciones">Observaciones:</label>
                        <input class="form-control" type="text" v-model="detalle.observaciones" placeholder="Introduzca las observaciones">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" @click="updateAutoridad" v-if="detalle.autoridad_id != null">Actualizar</button>
                        <button class="btn btn-success btn-crear" @click="storeAutoridad" v-if="detalle.autoridad_id == null">Agregar autoridad</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-tecnico" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Agregar Tecnico</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label for="tecnico_nombre">Nombre:</label>
                        <input class="form-control" type="text" v-model="detalle.nombre" placeholder="Introduzca el nombre del técnico">
                        <label id="tecnico-nombre-error" class="error" for="tecnico_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="tecnico_apellido">Apellido:</label>
                        <input class="form-control" type="text" v-model="detalle.apellido" placeholder="Introduzca el apellido del técnico">
                        <label id="tecnico-apellido-error" class="error" for="tecnico_apellido" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_usuario">Usuario gde:</label>
                        <input class="form-control" type="text" v-model="detalle.usuario" placeholder="Introduzca el usuario gde del técnico">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_telefono">Telefono:</label>
                        <input class="form-control" type="text" v-model="detalle.telefono" placeholder="Introduzca el número de teléfono del técnico">
                    </div>
                    <div class="form-group">
                        <label for="tecnico_mail">E-mail:</label>
                        <input class="form-control" type="text" v-model="detalle.mail" placeholder="Introduzca el e-mail del técnico">
                        <label id="tecnico-mail-error" class="error" for="tecnico_tecnico" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="tecnico_observaciones">Observaciones:</label>
                        <input class="form-control" type="text" v-model="detalle.observaciones" placeholder="Introduzca las observaciones">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" @click="updateTecnico" v-if="detalle.tecnico_id != null">Actualizar</button>
                        <button class="btn btn-success" @click="storeTecnico" v-if="detalle.tecnico_id == null">Agregar técnico</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-tecnico2" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Editar Tecnico</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label for="tecnico_nombre">Nombre:</label>
                        <input class="form-control" type="text" v-model="detalle.nombre" placeholder="Introduzca el nombre del técnico">
                        <label id="tecnico-nombre-error" class="error" for="tecnico_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="tecnico_apellido">Apellido:</label>
                        <input class="form-control" type="text" v-model="detalle.apellido" placeholder="Introduzca el apellido del técnico">
                        <label id="tecnico-apellido-error" class="error" for="tecnico_apellido" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_usuario">Usuario gde:</label>
                        <input class="form-control" type="text" v-model="detalle.usuario" placeholder="Introduzca el usuario gde del técnico">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_telefono">Telefono:</label>
                        <input class="form-control" type="text" v-model="detalle.telefono" placeholder="Introduzca el número de teléfono del técnico">
                    </div>
                    <div class="form-group">
                        <label for="tecnico_mail">E-mail:</label>
                        <input class="form-control" type="text" v-model="detalle.mail" placeholder="Introduzca el e-mail del técnico">
                        <label id="tecnico-mail-error" class="error" for="tecnico_tecnico" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="tecnico_observaciones">Observaciones:</label>
                        <input class="form-control" type="text" v-model="detalle.observaciones" placeholder="Introduzca las observaciones">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" @click="updateTecnico" v-if="detalle.tecnico_id != null">Actualizar</button>
                        <button class="btn btn-success" @click="storeTecnico" v-if="detalle.tecnico_id == null">Agregar técnico</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@section('js')
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src="{{ asset('/admin_style/assets/moment/moment-with-locales.min.js')}}"></script>
<script src='{{ asset("/admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script src="{{ asset('/admin_style/assets/vue/vue') }}"></script>
<script>
    let App = Vue.createApp({
        data() {
            return {
                url:'{{ url("api/v1/programas/autoridades") }}',
                url_tecnico: '{{ url("api/v1/programas/tecnicos") }}',
        		data:[],
                autoridades: [],
                tecnicos: [],
                autoridades_tipo: {!! $autoridadesTipo !!},
                detalle: {}
            }
    	},
    	methods: {
            init: function(){
                let self = this
				moment.locale('es');
    			this.myTimeout = setTimeout(function(){
                    this.ajax()
    			}.bind(this), 100);
    		},
    		goTo: function(page){
                this.page = page;
    			this.ajax();
    		},
            show: function(tipo){
                document.getElementById(tipo).classList.add('btn-autoridad--active');
                if(tipo == 'autoridades'){
                    document.getElementById('tecnicos').classList.remove('btn-autoridad--active');
                    document.getElementById('show-tecnicos').style.display = 'none';
                    document.getElementById('add-autoridad').style.display = 'block';
                    document.getElementById('add-tecnico').style.display = 'none';
                }
                if(tipo == 'tecnicos'){
                    document.getElementById('autoridades').classList.remove('btn-autoridad--active');
                    document.getElementById('show-autoridades').style.display = 'none';
                    document.getElementById('add-autoridad').style.display = 'none';
                    document.getElementById('add-tecnico').style.display = 'block';
                }
                document.getElementById('show-'+tipo).style.display = '';
            },
            editAutoridad: function(obj){
                this.cleanError();
                this.detalle = obj;
                $('#modal-autoridad2').modal('show');
                $('.select2').select2();
                $('.select2').val(obj.autoridad_tipo_id).trigger('change');
            },
            createAutoridad: function(){
                this.cleanError();
                this.detalle = {};
                $('#modal-autoridad').modal('show');
                $('.select2').select2();
            },
            cleanError: function(){
                let error = document.querySelectorAll('.error');
                for(let i = 0; i < error.length; i++){
                    error[i].style.display = 'none';
                }
            },
            storeAutoridad: function(){
                this.cleanError();
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("programa_id", "{{ $d->programa_id }}")
                for ( var key in this.detalle ) {
                    formData.append(key, this.detalle[key]);
                }
                formData.append("autoridad_tipo", $('#autoridad_tipo_id').val() );
                fetch( this.url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                    .then(data => {
                        if(data.status == 400){
                            for(i in data.error){
                                document.getElementById('autoridades-'+i+'-error').style.display = 'block';
                                document.getElementById('autoridades-'+i+'-error').textContent = data.error[i][0];
                            }
                        }else{
                            self.ajax();
                            $('#modal-autoridad').modal('hide');                        
                        }
                })
                .then(function(texto) {
                    console.warn(texto);
                })
                .catch(function(err) {
                    console.log(err);
                });
            },
            updateAutoridad: function(){
                this.cleanError();                
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("_method", "PUT");
                for ( var key in this.detalle ) {
                    formData.append(key, this.detalle[key]);
                }
                formData.append("autoridad_tipo", $('#autoridad_tipo_id').val() );
                fetch( this.url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                    .then(data => {
                        if(data.status == 400){
                            console.log( data );
                            for(i in data.error){
                                document.getElementById('autoridades-'+i+'-error').style.display = 'block';
                                document.getElementById('autoridades-'+i+'-error').textContent = data.error[i][0];
                            }
                        }else{
                            self.ajax();
                            $('#modal-autoridad').modal('hide');                        
                        }
                })
                .then(function(texto) {
                    console.log(texto);
                })
                .catch(function(err) {
                    console.log(err);
                });
            },
            deleteAutoridad: function(id){
                self = this;
                swal({
                    title: "{{ env('APP_NAME') }}",
                    text: '¿Está seguro de eliminar esta Autoridad?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText:  'Cancelar',
                }).then((result) => {
                    if (result) {
                        let self = this;
                        var formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("_method", "DELETE");
                        formData.append("autoridad_id", id)
                        fetch(this.url, {
                            method: 'POST',
                            body: formData
                        })
                        .then(function(response) {
                            if(response.ok) {
                                self.ajax();
                                return response.text()
                            } else {
                                throw response;
                            }
                        })
                        .then(function(texto) {
                            console.log(texto);
                        })
                        .catch(function(err) {
                            console.log(err);
                        });
                    }
                });
            },
            editTecnico: function(obj){
                this.detalle = obj;
                $('#modal-tecnico2').modal('show');
                $('.select2').select2();
            },
            createTecnico: function(){
                this.cleanError();                
                this.detalle = {};
                $('#modal-tecnico').modal('show');
                $('.select2').select2();
            },
            storeTecnico: function(){
                this.cleanError();
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("programa_id", "{{ $d->programa_id }}")
                for ( var key in this.detalle ) {
                    formData.append(key, this.detalle[key]);
                }
                fetch( this.url_tecnico, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                    .then(data => {
                        if(data.status == 400){
                            console.log( data );
                            for(i in data.error){
                                document.getElementById('tecnico-'+i+'-error').style.display = 'block';
                                document.getElementById('tecnico-'+i+'-error').textContent = data.error[i][0];
                            }
                        }else{
                            self.ajax();
                            $('#modal-tecnico').modal('hide');                        
                        }
                })
                .then(function(texto) {
                    console.log(texto);
                })
                .catch(function(err) {
                    console.log(err);
                });
            },
            updateTecnico: function(){
                this.cleanError();                
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("_method", "PUT");
                for ( var key in this.detalle ) {
                    formData.append(key, this.detalle[key]);
                }
                fetch( this.url_tecnico, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                    .then(data => {
                        if(data.status == 400){
                            console.log( data );
                            for(i in data.error){
                                document.getElementById('tecnico-'+i+'-error').style.display = 'block';
                                document.getElementById('tecnico-'+i+'-error').textContent = data.error[i][0];
                            }
                        }else{
                            self.ajax();
                            $('#modal-tecnico').modal('hide');                        
                        }
                })
                .then(function(texto) {
                    console.log(texto);
                })
                .catch(function(err) {
                    console.log(err);
                });
            },
            deleteTecnico: function(id){
                self = this;
                swal({
                    title: "{{ env('APP_NAME') }}",
                    text: '¿Está seguro de eliminar este Tecnico?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText:  'Cancelar',
                }).then((result) => {
                    if (result) {
                        let self = this;
                        var formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("_method", "DELETE");
                        formData.append("tecnico_id", id)
                        fetch(this.url_tecnico, {
                            method: 'POST',
                            body: formData
                        })
                        .then(function(response) {
                            if(response.ok) {
                                self.ajax();
                                return response.text()
                            } else {
                                throw response;
                            }
                        })
                        .then(function(texto) {
                            console.log(texto);
                        })
                        .catch(function(err) {
                            console.log(err);
                        });
                    }
                });
            },          
    		async ajax(){
    			let parameters  = '?';
    				parameters += 'id='+{{ $d->programa_id}};
    			const res  = await fetch(this.url + parameters, { 
    				method: 'GET'
    			});
	    		const data = await res.json();
	    		this.data  = data;
                this.autoridades = data.autoridades;
	    		this.tecnicos = data.tecnicos;
    		},
    	},
    	mounted() {
    		this.init();
    	}
  	});
  	App.mount('#app');
</script>
@endsection
