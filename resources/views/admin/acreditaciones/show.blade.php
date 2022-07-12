@extends('admin.layout.app')
@section('css')
<link href="{{ asset('/admin_style/assets/select2/select2.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('/admin_style/assets/bootstrap-datepicker/css/datepicker.css') }}"   	type="text/css"     rel="stylesheet">
<style>
    .select2-container {
        z-index: 0;
    }

    .dz-default {
        width: 100%;
        padding: 5% 0;
    }

    .info_general .item-programa h2 {
        margin: 5px 0 10px 0px;
        font-weight: 600;
        font-size: 15px;
    }

    .info_general .item-programa span {
        margin-left: 0px !important;
        font-weight: 300;
    }

    span.select2,
    span.selection {
        margin-left: 0px !important;
    }

    .modal {
        z-index: 9999;
    }

    .swal2-container {
        z-index: 99999;
    }
    input.form-control.indeterminada {
    width: auto;
    display: inline-block;
    height: auto;
    margin-left: 10px;
}
</style>
@endsection
@section('content')

<ol class="breadcrumb breadcrumb-quirk">
    <li><a href="{{ url('/') }}"><i class="fa fa-home mr5"></i> Inicio</a></li>
    <li><a href="{{ url('acreditaciones') }}">Acreditaciones</a></li>
    <li class="active">Detalle de la Acreditación</li>
</ol>

<div id="app">
    <div class="grid-programa">
        <div class="detalle-programa">
            <div class="card-programa__info">
                <div class="grid-razon-header">
                    <h1>{{ $d->razon_social ? $d->razon_social : '-' }}</h1>
                    @can('editar_acreditaciones')
                    <div class="item-programa div-edit">
                        <a href="{{ url('acreditaciones') }}/{{ $d->entidad_id }}/edit" class="btn-edit__style"><i class="fa-solid fa-pen"></i></a>
                    </div>
                    @endcan
                </div>
                <div class="underline"></div>
                <div class="grid-2">
                    <div class="item-programa">
                        <i class="fa-solid fa-id-card"></i><span>CUIT</span>
                        <h2 class="cuit">{{ $d->cuit ? $d->cuit : '-' }}</h2>
                    </div>
                    <div class="item-programa">
                        <i class="fa-solid fa-id-card-clip"></i> <span>Expediente GDE</span>
                        <h2> {{ $d->expediente ? $d->expediente : '-' }}</h2>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="item-programa hide">
                        <i class="fa-solid fa-id-card-clip"></i> <span>Memo</span>
                        <h2> {{ $d->memo ? $d->memo : '-' }}</h2>
                    </div>
                    <div class="item-programa">
                        <i class="fa-solid fa-id-card-clip"></i> <span>RLM</span>
                        <h2> {{ $d->rlm ? $d->rlm : '-' }}</h2>
                    </div>

                    <div class="item-programa">
                        <i class="fa-solid fa-id-card-clip"></i> <span>Providencia</span>
                        <h2> {{ $d->providencia ? $d->providencia : '-' }}</h2>
                    </div>

                    <div class="item-programa">
                        <i class="fa-solid fa-id-card-clip"></i> <span>If</span>
                        <h2> {{ $d->if ? $d->if : '-' }}</h2>
                    </div>

                    <div class="item-programa">
                        <i class="fa-solid fa-id-card-clip"></i> <span>Re</span>
                        <h2> {{ $d->re ? $d->re : '-' }}</h2>
                    </div>

                    <div class="item-programa">
                        <a href="{{ url('qr/') }}?id={{ $d->entidad_id }}" style="color:white"><i class="fa-solid fa-qrcode"></i>Cerficado</a>
                    </div>

                   <!-- <div class="item-programa">
                        <i class="fa-solid fa-id-card-clip"></i> <span>Tiempo de Inactivdad</span>
                        <h2> 
                        {{ Carbon\Carbon::parse( $d->audit_fecha_alta )->diffForHumans( Carbon\Carbon::parse($d->audit_fecha_up ) ) }}</h2>
                    </div>-->
                </div>
            </div>
        </div>

        <div class="box-operativa">
            <div class="header-box-operativa">
             <h3>Información operativa</h3>
                <div>
                    <span class="box-operativa__estado bg-{{ $d->entidadEstado->classname }}">{{ $d->entidadEstado->descripcion }}</span>
                </div>
            </div>
            <div class="underline-b"></div>
            <div class="operativa-grid">
                <div class="operativa-grid__box">
                    <div class="item-programa">
                        <i class="fa-solid fa-wave-square"></i><span>Estado</span>
                        @can('editar_estado_acreditacion')
                        <select name="entidad_estado" id="entidad_estado" style="width:90%">
                            <option value="{{ $d->entidadEstado->estado_id}}">{{ $d->entidadEstado->descripcion }}</option>
                        </select>
                        @else
                        <h5 class="{{ $d->entidadEstado  ? $d->entidadEstado->classname : '' }}">{{ $d->entidadEstado ? $d->entidadEstado->descripcion : '-'}}</h5>
                        @endcan
                    </div>
                </div>

                <div class="grid-2">
                    <div class="operativa-grid__box">
                        <div class="item-programa">
                            <i class="fa-solid fa-calendar-days"></i><span>Creación</span>
                            <h5>{{ $d->audit_fecha_alta ? Carbon\Carbon::parse($d->audit_fecha_alta)->format('d/m/Y H:i') : '-'  }}</h5>
                        </div>
                    </div>
                    <div class="operativa-grid__box">
                        <div class="item-programa">
                            <i class="fa-solid fa-calendar-days"></i><span>Ult. modificación</span>
                            <h5>{{ $d->audit_fecha_up ? Carbon\Carbon::parse($d->audit_fecha_up)->format('d/m/Y H:i') : '-'  }}</h5>
                        </div>
                    </div>
                   
                </div>
                <div class="grid-2">
                    <div class="operativa-grid__box">
                            <div class="item-programa">
                                <i class="fa-solid fa-clock"></i><span>Tiempo inactivo</span>
                                <h5>{{ Carbon\Carbon::parse( $d->audit_fecha_up )->diffForHumans( Carbon\Carbon::parse( Carbon\Carbon::now() ) ) }}</h5>
                            </div>
                        </div>

                        <div class="operativa-grid__box">
                            <div class="item-programa">
                                <i class="fa-solid fa-clock"></i><span>Tiempo en gestión</span>
                                <h5>{{ Carbon\Carbon::parse( $d->audit_fecha_alta )->diffInDays( Carbon\Carbon::parse( Carbon\Carbon::now() ) ) }} dia/s</h5>
                            </div>
                        </div>

                </div>
                <div class="grid-2">
                    <div class="operativa-grid__box">
                        <div class="item-programa">
                            <i class="fa-solid fa-wrench"></i><span>Técnico asignado</span>
                            <h5 class="tecnico-asignado">{{ $d->tecnico ? $d->tecnico->name : '-' }}</h5>
                        </div>
                    </div>
                    <div class="operativa-grid__box">
                        <div class="item-programa">
                            <i class="fa-solid fa-scale-balanced"></i><span>Abogado asignado</span>
                            <h5 class="abogado-asignado">{{ $d->abogado ? $d->abogado->name : '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->funcion == 3)
    @if($d->acreditacion_estado_id == 2)
    @if($d->abogado_id == Auth::user()->id )
    <div class="section-botones">
        <button class="btn-accept m-0" @click="Aceptar()"><i style="margin-right:5px" class="fa-solid fa-check"></i> Aceptar</button>
        <button class="btn-decline m-0" @click="Rechazar()"><i style="margin-right:5px" class="fa-solid fa-xmark"></i> Observar</button>
    </div>
    @endif
    @endif
    @endif

    @if(Auth::user()->funcion == 4)
    @if($d->acreditacion_estado_id == 3)
    @if($d->tecnico_id == Auth::user()->id )
    <div class="section-botones">
        <button class="btn-accept m-0" @click="Aceptar()"><i style="margin-right:5px" class="fa-solid fa-check"></i> Aceptar</button>
        <button class="btn-decline m-0" @click="Rechazar()"><i style="margin-right:5px" class="fa-solid fa-xmark"></i> Observar</button>
    </div>
    @endif
    @endif
    @endif    

    @if(Auth::user()->funcion == 5)
    @if($d->acreditacion_estado_id == 10)
    <div class="section-botones">
        <button class="btn-accept m-0" @click="Aceptar()"><i style="margin-right:5px" class="fa-solid fa-check"></i> Aceptar</button>
        <button class="btn-decline m-0" @click="Rechazar()"><i style="margin-right:5px" class="fa-solid fa-xmark"></i> Observar</button>
    </div>
    @endif
    @endif  

    <div class="tabs effect-2">
        <!-- tab-title -->
        <input type="radio" id="tab-1" name="tab-effect-2" checked="checked"><span><i class="fa-solid fa-circle-info"></i><span>Información</span></span>
        <input type="radio" id="tab-2" name="tab-effect-2"><span><i class="fa-solid fa-address-book"></i><span>Contactos</span></span>
        <input type="radio" id="tab-3" name="tab-effect-2"><span><i class="fa-solid fa-folder-open"></i><span>Archivo</span></span>
        <input type="radio" id="tab-4" name="tab-effect-2"><span><i class="fa-solid fa-right-left"></i><span>Movimientos</span></span>
        <input type="radio" id="tab-5" name="tab-effect-2"><span><i class="fa-solid fa-user-tie"></i><span>Autoridades</span></span>
        <input type="radio" id="tab-6" name="tab-effect-2"><span><i class="fa-solid fa-comment"></i><span>Consultas</span></span>
        <input type="radio" id="tab-7" name="tab-effect-2"><span style="border-radius: 0 10px 0 0"><i class="fa-solid fa-eye"></i><span>Observaciones</span></span>
        <!-- tab-content -->
        <div class="tab-content">
            <section id="tab-item-1">
                <div class="info_general">
                    <div class="div-info_general">
                        <h4>Datos de la acreditación</h4>
                        <div class="grid-infogral">
                            <div class="item-programa">
                                <i class="fa-solid fa-certificate"></i>
                                <span>Certificado de Vigencia</span>
                                <h2>{{ $d->certificado_vigencia ? $d->certificado_vigencia : '-' }}</h2>
                            </div>

                            <div class="item-programa">
                                <i class="fa-solid fa-handshake"></i>
                                <span>Convenio</span>
                                <h2>{{ $d->convenio ? $d->convenio : '-' }}</h2>
                            </div>

                            <div class="item-programa">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                <span>Devolución</span>
                                <h2>{{ $d->devolucion ? $d->devolucion : '-' }}</h2>
                            </div>
                            <div class="item-programa">
                                <i class="fa-solid fa-id-card-clip"></i> <span>Resolución</span>
                                <h2> {{ $d->resolucion ? $d->resolucion : '-' }}</h2>
                            </div>
                        </div>

                        <div class="grid-infogral">


                            <div class="item-programa">
                                <i class="fa fa-building"></i> <span>Programa</span>
                                
                                @if($d->programa)
                                    <h2><a href="{{ url('programas') }}/{{ $d->programa_id }}" target="_blank">{{ $d->programa ? $d->programa->nombre : '-' }}</a></h2>
                                @else
                                    <h2>-</h2>
                                @endif
                                
                            
                            
                            </div>
                            <div class="item-programa">
                                <i class="fa fa-building"></i> <span>Tipo Conformación</span>
                                <h2>{{ $d->estatal ? $d->estatal->descripcion : '-' }}</h2>
                            </div>
                            <div class="item-programa">
                                <i class="fa-solid fa-gavel"></i><span>Forma jurídica</span>
                                <h2>{{ $d->FormasJuridicas ? $d->FormasJuridicas->descripcion : '-' }}</h2>
                            </div>

                            <div class="item-programa">
                                <i class="fa-solid fa-handshake-simple"></i> <span>Repartición</span>
                                <h2>{{ $d->reparticion ? $d->reparticion->descripcion : '-' }}</h2>
                            </div>
                        </div>

                    </div>

                    <div class="div-info_general">
                        <h4>Dirección Real</h4>
                        <div class="grid-info-items">
                            <div class="item-programa">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Dirección Real</span>
                                <h2>{{ $d->dl_direccion ? $d->dl_direccion : '-' }}</h2>
                            </div>

                            <div class="item-programa">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span>Provincia Real</span>
                                <h2>{{ $d->provinciadl ? $d->provinciadl->nombre : '-' }}</h2>
                            </div>

                            <div class="item-programa">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span>Municipio Real</span>
                                <h2>{{ $d->municipiodl ? $d->municipiodl->nombre : '-' }}</h2>
                            </div>

                            <div class="item-programa">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span>Localidad Real</span>
                                <h2>{{ $d->localidaddl ? $d->localidaddl->nombre : '-' }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="div-info_general">
                        <h4>Dirección Fiscal</h4>
                        <div class="grid-info-items">
                            <div class="item-programa">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Dirección Fiscal</span>
                                <h2>{{ $d->df_direccion ? $d->df_direccion : '-' }}</h2>
                            </div>
                            <div class="item-programa">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span>Provincia Fiscal</span>
                                <h2>{{ $d->provinciadf ? $d->provinciadf->nombre : '-' }}</h2>
                            </div>
                            <div class="item-programa">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span>Municipio Fiscal</span>
                                <h2>{{ $d->municipiodf ? $d->municipiodf->nombre : '-' }}</h2>
                            </div>
                            <div class="item-programa">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span>Localidad Fiscal</span>
                                <h2>{{ $d->localidaddf ? $d->localidaddf->nombre : '-' }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="acreditaciones-grid d-none">
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-file-lines"></i><span>Certificado de vigencia</span>
                            <h5>Certificado</h5>
                        </div>
                    </div>
                    <h3>Dirección Real</h3>
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-location-arrow"></i><span>Dirección Fiscal</span>
                            <h5>Certificado</h5>
                        </div>
                    </div>
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-map-location"></i></i><span>Provincia Fiscal</span>
                            <h5>Dirección</h5>
                        </div>
                    </div>

                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-landmark"></i><span>Municipio Fiscal</span>
                            <h5>Certificado</h5>
                        </div>
                    </div>
                    <h3>Dirección Fiscal</h3>
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-map-location"></i><span>Localidad Fiscal</span>
                            <h5>Dirección</h5>
                        </div>
                    </div>
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-location-dot"></i><span>Dirección Real</span>
                            <h5>Certificado</h5>
                        </div>
                    </div>
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-map-location-dot"></i><span>Provincia Real</span>
                            <h5>Dirección</h5>
                        </div>
                    </div>
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-landmark"></i><span>Municipio Real</span>
                            <h5>Certificado</h5>
                        </div>
                    </div>
                    <div class="acreditaciones-grid__box">
                        <div>
                            <i class="fa-solid fa-map-location-dot"></i><span>Localidad Real</span>
                            <h5>Dirección</h5>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tab-item-2">

                <div class="no-data__grid" v-if="contactos.length == 0">
                    <h2> <span class="no-info-cargada">Aún no hay información cargada</span></h2>

                    @can('editar_acreditaciones')

                    <button class="btn-add" @click="createContacto()"><i style="margin-right:5px" class="fa-solid fa-plus"></i> Cargar contacto</button>
                    @endcan
                </div>
                <div class="div-add-tecnico" v-if="contactos.length > 0">
                    <button class="btn-add-tecnico" @click="createContacto()"> <i class="fa fa-plus d-block"></i> <span class="text-min"></span> </button>
                    @can('editar_acreditaciones')
                    @endcan
                </div>

                <div class="card-programa__autoridad2" v-for="contacto in contactos" v-if="contactos.length > 0">

                    <div class="acreditaciones-grid2">
                        <div class="acreditaciones-grid__box2">
                            <i class="fa fa-user"></i><span>Nombre y apellido</span>
                            <h5>@{{ contacto.nombre }} @{{ contacto.apellido }}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-briefcase"></i><span>Cargo</span>
                            <h5>@{{ contacto.autoridad_tipo ? contacto.autoridad_tipo.nombre : '-' }}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-mobile-screen"></i><span>Teléfono principal</span>
                            <h5>@{{ contacto.telefono_principal == null ? '-' : contacto.telefono_principal }}</h5>
                        </div>

                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-phone"></i><span>Teléfono alternativo</span>
                            <h5>@{{ contacto.telefono_alternativo == null ? '-' : contacto.telefono_alternativo }}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa fa-at"></i><span>Mail</span>
                            <h5>@{{ contacto.mail }}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-comment-dots"></i><span>Comentarios</span>
                            <h5>@{{ contacto.observaciones == null ? '-' : contacto.observaciones }}</h5>
                        </div>
                    </div>
                    <div class="card-programa__iconos">
                        <button class="btn-edit" @click="$root.editContacto(contacto)"> <i class="fa fa-pencil icon-edit"></i></button>
                        <button @click="$root.deleteContacto(contacto.contacto_id)"> <i class="fa fa-trash icon-trash"></i> </button>
                    </div>
                    @can('editar_acreditaciones')
                    @endcan
                </div>
            </section>
            <section id="tab-item-3">
                <div class="dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                    <i class="fa-solid fa-upload"></i>
                    <p>Arrastre sus archivos aquí o haga click en este bloque para adjuntar</p>
                </div>
                <div class="archivo-dropzone">
                </div>
                <div class="grid-archivos">
                <div v-for="archivo in archivos" class="card-programa__archivos">
                    
                    <div class="acreditaciones-grid2">
                        <div class="acreditaciones-grid__box2">
                            <div>
                            <i class="fa-solid fa-file-arrow-up"></i><span>Nombre de archivo</span>
                                <h5><a :href="'{{ url('storage') }}/'+ archivo.src" target="_blank">@{{ archivo.src }}</a></h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                            <i class="fa-solid fa-calendar-days"></i><span>Fecha</span>
                                <h5>@{{ DateFormat(archivo.fecha_subida, 'DD-MM-YY H:m') }}</h5>
                            </div>
                        </div>

                        <div class="acreditaciones-grid__box2">
                            <div>
                            <i class="fa-solid fa-user"></i><span>Usuario</span>
                                <h5>@{{ archivo.usuario ? archivo.usuario.name : '-' }}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                            <i class="fa-solid fa-file-zipper"></i><span>Tipo de archivo</span>
                                <h5>@{{ archivo.tipo ? archivo.tipo.descripcion : '' }}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                            <i class="fa-solid fa-comment-dots"></i><span>Descripción</span>
                                <h5> @{{ archivo.descripcion }}</h5>
                            </div>
                        </div>

                        
                    </div>
                    <div class="card-programa__iconos">
                    
                        @can('editar_acreditaciones_archivos')
                        <button class="btn-edit" @click="$root.Comentario(archivo)"> <i class="fa fa-pencil icon-edit"></i></button>
                        <button class="btn-edit" @click="$root.deleteArchivo(archivo)"> <i class="fa fa-trash icon-trash"></i></button>
                        @endcan

                        
                   
                   </div>
                </div>
                </div>

                <table class="table d-none" v-if="archivos.length > 0">
                    <thead>
                        <tr>
                            <th class="text-center">Archivo</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Descripcion</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="archivo in archivos">
                            <td>
                                <a :href="'{{ asset('files') }}/'+ archivo.src" target="_blank">@{{ archivo.src }}</a>
                            </td>
                            <td class="text-right" style="width:200px;">@{{ DateFormat(archivo.fecha_subida, 'DD-MM-YY H:m') }}</td>
                            <td>
                                @{{ archivo.descripcion }}
                            </td>
                            <td>
                                @{{ archivo.tipo ? archivo.tipo.descripcion : '' }}
                            </td>
                            <td>
                                <a href="javascript:void(0)" @click="$root.Comentario(archivo)"><i class="fa fa-pencil"></i></a>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section id="tab-item-4">
                <div class="no-data__grid" v-if="movimientos.length == 0">
                    <h2> <span class="no-info-cargada">Aún no hay información cargada</span></h2>
                </div>
                <div class="card-programa__movimientos" v-for="item in movimientos">
                    <div class="acreditaciones-grid2">
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-comment-dots"></i><span>Usuario</span>
                            <h5>@{{ item.usuario ? item.usuario.name : '-' }}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-calendar-days"></i><span>Fecha</span>
                            <h5>@{{ DateFormat(item.audit_fecha_alta, 'DD/MM/YYYY') }}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-clock"></i><span>Hora</span>
                            <h5>@{{ DateFormat(item.audit_fecha_alta, 'HH:mm') }}</h5>
                        </div>

                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-wave-square"></i><span>Estado actual</span>
                            <h5 :class="item.estado_actual.classname">@{{ item.estado_actual ? item.estado_actual.descripcion : '-' }}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-wave-square"></i><span>Estado anterior</span>
                            <h5 :class="item.estado_previo ? item.estado_previo.classname : ''">@{{ item.estado_previo ? item.estado_previo.descripcion : '-'}}</h5>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <i class="fa-solid fa-download"></i><span>Descarga de archivo</span>
                            <h5 @click="Download(item)" style="cursor:pointer">@{{ item.adjunto ? item.adjunto : '-' }}</h5>
                        </div>
                    </div>
                    <div style="padding: 10px 40px;" class="acreditaciones-grid__box2">
                        <i class="fa-solid fa-comment-dots"></i><span>Descripción</span>
                        <h5>@{{ item.detalle ? item.detalle : '-' }}</h5>
                    </div>
                </div>
            </section>
            <section id="tab-item-5">
                <div class="no-data__grid grid-vencimiento">
                <label class="col-sm-12 control-label">Vencimiento Autoridades: {{ $d->fecha_vigencia_autoridades ? \Carbon\Carbon::parse($d->fecha_vigencia_autoridades)->format('d-m-Y') : ' - ' }}</label>
                  @can('editar_acreditaciones')
                        <a href="{{ url('acreditaciones') }}/{{ $d->entidad_id }}/edit" class="btn-edit__style bg-venc-autoridades"><i class="fa-solid fa-pen"></i></a>

                    @endcan                 
                

                </div>
            
                <div class="no-data__grid bradius-vencimiento" v-if="autoridades.length == 0">
  
                                
                    <h2> <span class="no-info-cargada">Aún no hay información cargada</span></h2>
                    @can('editar_acreditaciones')
                    <button class="btn-add" @click="createAutoridad()"><i style="margin-right:5px" class="fa-solid fa-plus"></i> Cargar autoridad</button>
                    @endcan
                </div>

                <div class="div-add-tecnico" v-if="autoridades.length > 0">
                
                    @can('editar_acreditaciones')
                    <button class="btn-add-tecnico" @click="createAutoridad()"> <i class="fa fa-plus d-block"></i> <span class="text-min"></span> </button>
                    @endcan
                </div>

                <div class="card-programa__autoridad2" v-for="autoridad in autoridades" v-if="autoridades.length > 0">
                
                    <div class="acreditaciones-grid2">
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-user-tie"></i><span>Tipo de autoridad</span>
                                <h5>@{{ autoridad.autoridad_tipo ? autoridad.autoridad_tipo.nombre : '-' }}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-user-tie"></i><span>Nombre y apellido</span>
                                <h5>@{{ autoridad.nombre }} @{{ autoridad.apellido }}</h5>
                            </div>
                        </div>

                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-id-card"></i><span>DNI</span>
                                <h5>@{{ autoridad.dni ? autoridad.dni : '-'}}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-calendar-days"></i><span>Fecha desde</span>
                                <h5>@{{ autoridad.fecha_desde ? $root.DateFormat(autoridad.fecha_desde, 'DD/MM/YY') : '-' }}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-calendar-days"></i><span>Fecha hasta</span>
                                <h5>@{{ autoridad.fecha_hasta ? $root.DateFormat(autoridad.fecha_hasta, 'DD/MM/YY') : '-' }}</h5>
                            </div>
                        </div>
                    </div>
                    @can('editar_acreditaciones')
                    <div class="card-programa__iconos">
                        <button class="btn-edit" @click="$root.editAutoridad(autoridad)"> <i class="fa fa-pencil icon-edit"></i></button>
                        <button @click="$root.deleteAutoridad(autoridad.autoridad_id)"> <i class="fa fa-trash icon-trash"></i> </button>
                    </div>
                    @endcan
                </div>
            </section>
            <section id="tab-item-6">
                <div class="no-data__grid" v-if="consultas.length == 0">
                    <h2> <span class="no-info-cargada">Aún no hay información cargada</span></h2>
                    <button class="btn-add" @click="$root.consulta()"><i style="margin-right:5px" class="fa-solid fa-plus"></i> Cargar consulta</button>
                    @can('editar_acreditaciones')
                    @endcan
                </div>

                <div class="div-add-tecnico" v-if="consultas.length > 0">
                    <button class="btn-add-tecnico" @click="$root.consulta()"> <i class="fa fa-plus d-block"></i> <span class="text-min"></span> </button>
                    @can('editar_acreditaciones')
                    @endcan
                </div>

                <div class="card-programa__consultas" v-for="item in consultas" v-if="consultas.length > 0">
                    <div class="grid-consultas">

                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-user-tie"></i><span>Usuario</span>
                                <h5>@{{ item.usuario ? item.usuario.name : '-' }}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-calendar-days"></i><span>Fecha</span>
                                <h5>@{{ DateFormat(item.audit_fecha_alta, 'DD/MM/YYYY HH:mm') }}</h5>
                            </div>
                        </div>

                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-barcode"></i><span>Código</span>
                                <h5>@{{ item.codigo }}</h5>
                            </div>
                        </div>

                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-comment-dots"></i><span>Respuesta</span>
                                <h5>@{{ item.respuesta }}</h5>
                            </div>
                        </div>
                        </div>

                        <div class="card-programa__iconos">
                            <button class="btn-edit" @click="$root.consulta(item)"> <i class="fa fa-pencil icon-edit"></i></button>
                            @can('editar_acreditaciones')
                            <button class="btn-edit" @click="$root.Respuesta(item)"> <i class="fa fa-arrow-rotate-back icon-edit"></i></button>
                            @endcan
                            <button @click="$root.deleteConsulta(item)"> <i class="fa fa-trash icon-trash"></i> </button>
                        </div>

                        <div style="padding: 0px 40px" class="descripcion-field">
                            <div>
                                <i class="fa-solid fa-comment-dots"></i><span>Descripción</span>
                                <h5>@{{ item.detalle }}</h5>
                            </div>
                        </div>                    
                </div>
            </section>
            <section id="tab-item-7">
                <div class="no-data__grid" v-if="observaciones.length == 0">
                    <h2> <span class="no-info-cargada">Aún no hay información cargada</span></h2>
                    <button class="btn-add" @click="$root.observacion()"><i style="margin-right:5px" class="fa-solid fa-plus"></i> Cargar observación</button>
                    @can('editar_acreditaciones')
                    @endcan
                </div>

                <div class="div-add-tecnico" v-if="consultas.length > 0">
                    <button class="btn-add-tecnico" @click="$root.observacion()"> <i class="fa fa-plus d-block"></i> <span class="text-min"></span> </button>
                    @can('editar_acreditaciones')
                    @endcan
                </div>

                <div class="card-programa__consultas" v-for="item in observaciones" v-if="observaciones.length > 0">
                    <div class="acreditaciones-grid2">
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-user-tie"></i><span>Usuario</span>
                                <h5>@{{ item.usuario ? item.usuario.name : '-' }}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-calendar-days"></i><span>Fecha</span>
                                <h5>@{{ DateFormat(item.audit_fecha_alta, 'DD/MM/YYYY') }}</h5>
                            </div>
                        </div>
                        <div class="acreditaciones-grid__box2">
                            <div>
                                <i class="fa-solid fa-clock"></i><span>Hora</span>
                                <h5>@{{ DateFormat(item.audit_fecha_alta, 'HH:mm') }}</h5>
                            </div>
                        </div>

                    </div>
                    @can('editar_acreditaciones')
                    <div class="card-programa__iconos">
                        <button class="btn-edit" @click="$root.observacion(item)"> <i class="fa fa-pencil icon-edit"></i></button>
                        <button @click="$root.deleteObservacion(item)"> <i class="fa fa-trash icon-trash"></i> </button>
                    </div>
                    @endcan
                    <div class="descripcion-field acreditaciones-grid__box2">
                        <div>
                            <i class="fa-solid fa-comment-dots"></i><span>Observación</span>
                            <h5>@{{ item.descripcion }}</h5>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modal-contacto" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Agregar Contacto</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label for="autoridad_autoridad_tipo">Tipo:</label>
                        <select name="autoridad_tipo" class="select2" style="width:100%" id="autoridades_tipo_select2">
                            <option value="">Seleccione el Cargo</option>
                            <option :value="detalle.cargo" selected="selected">@{{ detalle.autoridad_tipo ? detalle.autoridad_tipo.nombre : '' }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_nombre">Nombre:</label>
                        <input class="form-control autoriddades_nombre" type="text" v-model="detalle.nombre" placeholder="Introduzca el nombre de la Contacto">
                        <label id="contacto-nombre-error" class="error" for="autoridades_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_apellido">Apellido:</label>
                        <input class="form-control autoridades_apellido" type="text" v-model="detalle.apellido" placeholder="Introduzca el apellido de la Contacto">
                        <label id="contacto-apellido-error" class="error" for="autoridades_apellido" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_usuario">Telefono Principal:</label>
                        <input class="form-control" type="text" v-model="detalle.telefono_principal" placeholder="Introduzca el usuario gde de la Contacto">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_telefono">Teléfono Alternativo:</label>
                        <input class="form-control" type="text" v-model="detalle.telefono_alternativo" placeholder="Introduzca el número de teléfono de la Contacto">
                    </div>
                    <div class="form-group">
                        <label for="autoridades_mail">E-mail:</label>
                        <input class="form-control" type="text" v-model="detalle.mail" placeholder="Introduzca el e-mail de la Contacto">
                        <label id="contacto-mail-error" class="error" for="autoridades_mail" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridad_observaciones">Comentarios:</label>
                        <input class="form-control" type="text" v-model="detalle.observaciones" placeholder="Introduzca las observaciones">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" @click="updateContacto" v-if="detalle.contacto_id != null">Actualizar</button>
                        <button class="btn btn-success btn-crear" @click="storeContacto" v-if="detalle.contacto_id == null">Agregar Contacto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-comentario" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Informacion De Archivo</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label>Comentario:</label>
                        <input class="form-control" type="text" v-model="archivo.descripcion" placeholder="Introduzca un comentario">
                    </div>
                    <div class="form-group">
                        <label>Tipo de Archivo:</label>
                        <select name="archivo_tipo_id" id="archivo_tipo" class="select2" style="width:100%">
                            <option value="">Seleccione</option>
                            @foreach($archivo_tipo as $at)
                            <option value="{{ $at->archivo_tipo_id}}">{{ $at->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="updateComentario">Agregar Comentario</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-movimiento" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Movimiento</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label>Comentario:</label>
                        <input class="form-control" type="text" v-model="archivo.descripcion" placeholder="Introduzca un comentario">
                    </div>
                    <div class="form-group">
                        <label>Tipo de Archivo:</label>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="updateComentario">Agregar Comentario</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-aceptar" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Aceptar Acreditación</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label>Comentario:</label>
                        <input class="form-control" type="text" v-model="aceptar_post.detalle" placeholder="Introduzca un comentario">
                    </div>
                    @if(Auth::user()->funcion == 3)
                    <div class="form-group">
                        <label>Providencia:</label>
                        <input class="form-control" type="text" v-model="aceptar_post.providencia" placeholder="Introduzca la Providencia">
                    </div>
                    <div class="form-group">
                        <label>Fecha de Vencimiento de Autoridades:</label>
                        <input class="form-control fecha_vencimiento_autoridades"   type="text"     placeholder="Introduzca la Fecha de Vencimiento">
                        <input class="form-control"                                 type="hidden"   v-model="aceptar_post.fecha_vencimiento_autoridades" >
                    </div>                    
                    @endif
                    @if(Auth::user()->funcion == 4)
                    <div class="form-group">
                        <label>If:</label>
                        <input class="form-control" type="text" v-model="aceptar_post.if" placeholder="Introduzca un If">
                        <label id="aceptar-if-error" class="error" for="autoridades_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label>Re:</label>
                        <input class="form-control" type="text" v-model="aceptar_post.re" placeholder="Introduzca un Re">
                        <label id="aceptar-re-error" class="error" for="autoridades_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Archivo:</label>
                        <input type="file" id="aceptar_file">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="postAceptar()">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-rechazar" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Observar Acreditación</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label>Comentario:</label>
                        <input class="form-control" type="text" v-model="rechazar_post.detalle" placeholder="Introduzca un comentario">
                    </div>
                    <div class="form-group">
                        <label>Archivo:</label>
                        <input type="file" id="rechazar_file">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="postRechazar()">Observar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-consulta" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Consulta</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group hide" >
                        <label>Codigo:</label>
                        <input class="form-control" type="text" v-model="consulta_post.codigo" placeholder="Introduzca un codigo">
                    </div>
                    <div class="form-group">
                        <label>Consulta:</label>
                        <input class="form-control" type="text" v-model="consulta_post.detalle" placeholder="Introduzca su consulta">
                    </div>
                    @can('editar_acreditaciones')
                    <div class="form-group">
                        <label>Respuesta:</label>
                        <input class="form-control" type="text" v-model="consulta_post.respuesta" placeholder="Introduzca su Respuesta">
                    </div>
                    @endcan
                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="postConsulta()">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-observacion" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Observación</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label>Consulta:</label>
                        <input class="form-control" type="text" v-model="observacion_post.descripcion" placeholder="Introduzca su Observación">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="postObservacion()">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-abogado" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Seleccione Abogado</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label>Abogado:</label>
                        <select name="abogado" id="abogado" class="select2" style="width:100%">
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="updateTecnicoAbogado">Actualizar Abogado</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-tecnico" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                <h1>Seleccione Tecnico</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label>Tecnico:</label>
                        <select name="tecnico" id="tecnico" class="select2" style="width:100%">
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-crear" @click="updateTecnicoAbogado">Actualizar Tecnico</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-autoridad" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Agregar Autoridad</h1>
                    <a href="" style="position:absolute;right:15px;top:15px" data-dismiss="modal"><i class="fa fa-close"></i></a>
                    <div class="form-group">
                        <label for="autoridad_autoridad_tipo">Tipo:</label>
                        <select name="autoridad_tipo" class="select2" style="width:100%" id="autoridad-autoridades_tipo_select2">
                            <option value="">Seleccione el Cargo</option>
                            <option :value="detalle.cargo" selected="selected">@{{ detalle.autoridad_tipo ? detalle.autoridad_tipo.nombre : '' }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_nombre">Nombre:</label>
                        <input class="form-control autoriddades_nombre" type="text" v-model="detalle.nombre" placeholder="Introduzca el nombre de la Contacto">
                        <label id="autoridades-nombre-error" class="error" for="autoridades_nombre" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_apellido">Apellido:</label>
                        <input class="form-control autoridades_apellido" type="text" v-model="detalle.apellido" placeholder="Introduzca el apellido de la Contacto">
                        <label id="autoridades-apellido-error" class="error" for="autoridades_apellido" style="display:none">Este campo es requerido.</label>
                    </div>
                    <div class="form-group">
                        <label for="autoridades_usuario">DNI:</label>
                        <input class="form-control" type="text" v-model="detalle.dni" placeholder="Introduzca el dni">
                    </div>
                                 
                    <div class="form-group wrapper_fecha_desde">
                        <label for="autoridades_fecha_desde">Fecha Desde:</label>
                        <input class="form-control date fecha_desde_text"   type="text" placeholder="Fecha Desde">
                        <input class="form-control date fecha_desde"        type="hidden">
                        <label id="autoridades-fecha_desde-error" class="error" for="autoridades_apellido" style="display:none">Este campo es requerido.</label>
                        
                    </div>
                    <div class="form-group wrapper_fecha_hasta">
                        <label for="autoridades_fecha_hasta">Fecha Hasta:</label>
                        <input class="form-control date fecha_hasta_text"     type="text" placeholder="Fecha Hasta">
                        <input class="form-control date fecha_hasta_hidden"   type="hidden">
                        <label id="autoridades-fecha_hasta-error" class="error" for="autoridades_apellido" style="display:none">Este campo es requerido.</label>
                    </div>  
                    <div class="form-group">
                        <label for="autoridades_fecha_indeterminada">Fecha Indeterminada: </label>
                        <input type="checkbox" name="autoridades-indeterminada"  class="form-control indeterminada">
                    </div>                      
                    <div class="form-group">
                        <button class="btn btn-success"             @click="updateAutoridad"    v-if="detalle.autoridad_id != null">Actualizar</button>
                        <button class="btn btn-success btn-crear"   @click="storeAutoridad"     v-if="detalle.autoridad_id == null">Agregar Autoridad</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('js')
<script src='{{ asset("/admin_style/assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("/admin_style/assets/dropzone/dist/dropzone.js") }}'></script>
<script src="{{ asset('/admin_style/assets/vue/vue') }}"></script>
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src="{{ asset('/admin_style/assets/moment/moment-with-locales.min.js')}}"></script>
<script src='{{ asset("/admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script src='{{ asset("/admin_style/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}'></script>
<script src='{{ asset("/admin_style/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js") }}'></script>
<script src="{{ asset('/admin_style/assets/jquery-mask/dist/jquery.mask.js')}}"></script>
<script>
    let App = Vue.createApp({
        data() {
            return {
                url: '{{ url("api/v1/acreditaciones/contacto") }}',
                data: [],
                contactos: [],
                archivos: [],
                detalle: {
                    autoridad_tipo: '',
                    dni: '',
                    nombre: '',
                    apellido: '',
                    fecha_desde: '',
                    fecha_hasta: '',
                    indeterminada: ''
                },
                archivo: {},
                movimientos: {},
                archivo_tipo: {!!$archivo_tipo !!},
                aceptar_post: {
                    descripcion:'',
                    if:'',
                    re:'',
                    providencia:'',
                    fecha_vencimiento_autoridades: ''
                },
                rechazar_post: {},
                consulta_post: {},
                consultas: {},
                observacion_post: {},
                observaciones: {},
                select_abogado_tecnico: null,
                estado: {{ $d->entidadEstado->estado_id }},
                autoridades: []
            }
        },
        methods: {
            init: function() {
                let self = this
                moment.locale('es');
                $('.cuit').mask('00-00000000-00');
                $('#entidad_estado').select2({
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                        data: function(params) {
                            var query = {
                                search: params.term,
                                tipo: 'entidad_estado'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                }).on('change', function(e) {

                    if( self.estado == this.value){
                        return true;
                    }
                    swal({
                        title: "Estado",
                        text: '¿Está seguro de cambiar el estado?',
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result) {
                            self.updateState(this);
                            self.ajax();    
                        }
                    }).catch((resutl) => {
                        $("#entidad_estado").val( {{ $d->entidadEstado->estado_id }} ).trigger('change');
                    });
                });
                Dropzone.autoDiscover = false;
                let csrf = $('input[name="_token"]').val();
                $(".dropzone").dropzone({
                    url: "{{ url('api/v1/acreditaciones/file/upload') }}",
                    dictDefaultMessage: "",
                    maxFilesize: 10, // MB
                    acceptedFiles: " .doc, .docx, .xls, .xlsx, .pdf, .txt, .ppt, .pptx, .png, .jpg",
                    success: function(file, response) {
                        this.removeFile(file);
                        toastr.success('Archivo subido correctamente');
                        self.ajax();
                    },
                    sending: function(file, xhr, formData) {
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("id", '{{ $d->entidad_id }}');
                    },
                    error: function(file, message) {
                        console.log(message);
                    }
                });
                this.myTimeout = setTimeout(function() {
                    this.ajax()
                }.bind(this), 100);
            },
            Download: function(ad) {
                if (ad.adjunto) {
                    window.open('{{ url("download" )}}/' + ad.adjunto, '_blank');
                }
            },
            DateFormat: function(element, format) {
                return moment(element).format(format);
            },
            updateState: function(element) {
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id", "{{ $d->entidad_id }}")
                formData.append("acreditacion_estado_id", element.value);
                fetch("{{ url('api/v1/acreditaciones/estado') }}", {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 400) {
                            // console.log(data);
                        } else {
                            this.select_abogado_tecnico = element.value;
                            this.estado = element.value;
                            if(element.value == 2){
                                this.select_abogado_tecnico = element.value;
                                $('#modal-abogado').modal('show');
                                setTimeout(function() {
                                    $('#abogado').select2({
                                        dropdownParent: $("#modal-abogado"),
                                        ajax: {
                                            url: '{{ url("api/v1/autocomplete") }}',
                                            data: function(params) {
                                                var query = {
                                                    search: params.term,
                                                    tipo: 'abogado'
                                                }
                                                return query;
                                            },
                                            dataType: 'json',
                                        },
                                        minimumInputLength: 0,
                                    });
                                }, 100);
                            }
                            if(element.value == 3){
                                $('#modal-tecnico').modal('show');
                                setTimeout(function() {
                                    $('#tecnico').select2({
                                        dropdownParent: $("#modal-tecnico"),
                                        ajax: {
                                            url: '{{ url("api/v1/autocomplete") }}',
                                            data: function(params) {
                                                var query = {
                                                    search: params.term,
                                                    tipo: 'tecnico'
                                                }
                                                return query;
                                            },
                                            dataType: 'json',
                                        },
                                        minimumInputLength: 0,
                                    });
                                }, 100);
                            }
                            toastr.success('Cambio de Estado Guardado Satisfactoriamente');
                            // location.reload();
                        }
                    })
                    .then(function(texto) {
                        // console.warn(texto);
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
            },
            updateTecnicoAbogado: function(){
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id", "{{ $d->entidad_id }}")
                if(this.select_abogado_tecnico == 2){
                    formData.append("abogado_id", $("#abogado").val() )
                }
                if(this.select_abogado_tecnico == 3){
                    formData.append("tecnico_id", $("#tecnico").val() );
                }                
                formData.append("tecnico_abogado", this.select_abogado_tecnico);
                fetch("{{ url('api/v1/acreditaciones/updateAbogadoTecnico') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 400) {
                        console.log(data);
                    } else {
                        if(this.select_abogado_tecnico == 2){
                            var data = $('#abogado').select2('data')
                            $('#modal-abogado').modal('hide');
                            $('.abogado-asignado').text( data[0].text == 'Seleccione' ? '-' : data[0].text );
                        }
                        if(this.select_abogado_tecnico == 3){
                            var data = $('#tecnico').select2('data')
                            $('.tecnico-asignado').text( data[0].text == 'Seleccione' ? '-' : data[0].text);
                            $('#modal-tecnico').modal('hide');
                        }
                    }
                })
                .catch(function(err) {
                    console.log(err);
                });
            },
            goTo: function(page) {
                this.page = page;
                this.ajax();
            },
            show: function(tipo) {
                document.getElementById(tipo).classList.add('btn-autoridad--active');
                if (tipo == 'autoridades') {
                    document.getElementById('tecnicos').classList.remove('btn-autoridad--active');
                    document.getElementById('show-tecnicos').style.display = 'none';
                    document.getElementById('add-autoridad').style.display = 'block';
                    document.getElementById('add-tecnico').style.display = 'none';
                }
                if (tipo == 'tecnicos') {
                    document.getElementById('autoridades').classList.remove('btn-autoridad--active');
                    document.getElementById('show-autoridades').style.display = 'none';
                    document.getElementById('add-autoridad').style.display = 'none';
                    document.getElementById('add-tecnico').style.display = 'block';
                }
                document.getElementById('show-' + tipo).style.display = '';
            },
            editContacto: function(obj) {
                this.cleanError();
                this.detalle = obj;
                $('#modal-contacto').modal('show');
                setTimeout(function() {
                    $('#autoridades_tipo_select2').select2({
                        dropdownParent: $("#modal-contacto"),
                        ajax: {
                            url: '{{ url("api/v1/autocomplete") }}',
                            data: function(params) {
                                var query = {
                                    search: params.term,
                                    tipo: 'autoridades_tipo'
                                }
                                return query;
                            },
                            dataType: 'json',
                        },
                        minimumInputLength: 0,
                    });
                }, 100);
            },
            createContacto: function() {
                this.cleanError();
                this.detalle = {};
                $('#modal-contacto').modal('show');
                $('#autoridades_tipo_select2').select2({
                    dropdownParent: $("#modal-contacto"),
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                        data: function(params) {
                            var query = {
                                search: params.term,
                                tipo: 'autoridades_tipo'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                });
            },
            createAutoridad: function(obj){
                this.cleanError();
                this.detalle = {};
                $('.indeterminada').attr('checked', false);
                self = this;
                $('#modal-autoridad').modal('show');
                $('.fecha_desde_text').val('');
                $('.fecha_desde_text').datepicker({
                    format: 'dd-mm-yyyy',
		        	autoclose: true,
                    setDate: null
		    	}).on('changeDate', function(ev) {
                    self.detalle.fecha_desde =  moment( new Date(ev.date) ).format('Y-MM-DD');
				});
                $('.fecha_hasta_text').val('');
                $(".fecha_hasta_text").datepicker({
		        	format: 'dd-mm-yyyy',
		        	autoclose: true,
                    setDate: null
		    	}).on('changeDate', function(ev) {
                    self.detalle.fecha_hasta =  moment( new Date(ev.date) ).format('Y-MM-DD');
				});
                $('#autoridad-autoridades_tipo_select2').val(null).trigger('change');
                $('.indeterminada').click(function(){
                    let el = $('.wrapper_fecha_desde, .wrapper_fecha_hasta');
                    if($(this).is(':checked')){
                        el.hide();
                    }
                    if(!$(this).is(':checked')){
                        el.show();
                    }
                });
                $('#autoridad-autoridades_tipo_select2').select2({
                    dropdownParent: $("#modal-autoridad"),
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                        data: function(params) {
                            var query = {
                                search: params.term,
                                tipo: 'autoridades_tipo'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                });
            },
            storeAutoridad: function(){
                this.cleanError();
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("entidad_id", "{{ $d->entidad_id }}")
                for (var key in this.detalle) {
                    formData.append(key, this.detalle[key]);
                }
                formData.append("autoridad_tipo", $('#autoridad-autoridades_tipo_select2').val());
                formData.append("indeterminada", $('.indeterminada').is(':checked') ? 'si' : 'no' );

                fetch('{{ url("api/v1/acreditaciones/autoridad") }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 400) {
                            for (i in data.error) {
                                document.getElementById('autoridades-' + i + '-error').style.display = 'block';
                                document.getElementById('autoridades-' + i + '-error').textContent = data.error[i][0];
                            }
                        } else {
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
            editAutoridad: function(obj){
                self = this;
                this.cleanError();
                this.detalle = obj;
                if(obj.fecha_desde){
                    $('.fecha_desde_text').val(moment( obj.fecha_desde ).format('DD-MM-Y') );
                    $('.fecha_desde').val( moment( obj.fecha_desde ).format('Y-MM-DD') );
                }else{
                    $('.fecha_desde_text').val( null );
                    $('.fecha_desde').val( null );
                }
                if(obj.fecha_hasta){
                    $('.fecha_hasta_text').val( moment(obj.fecha_hasta ).format('DD-MM-Y') );
                    $('.fecha_hasta').val(  moment( obj.fecha_hasta ).format('Y-MM-DD'));
                }else{
                    $('.fecha_hasta_text').val( null );
                    $('.fecha_hasta').val( null );
                }

                if(!obj.fecha_hasta && !obj.fecha_desde){
                    $('.indeterminada').attr('checked', true);
                    let el = $('.wrapper_fecha_desde, .wrapper_fecha_hasta').hide();
                }else{
                    $('.indeterminada').attr('checked', false);
                    let el = $('.wrapper_fecha_desde, .wrapper_fecha_hasta').show();
                }

                $('#modal-autoridad').modal('show');
                $('.fecha_desde_text').datepicker({
		        	format: 'dd-mm-yyyy',
		        	autoclose: true
		    	}).on('changeDate', function(ev) {
                    self.detalle.fecha_desde =  moment( new Date(ev.date) ).format('Y-MM-DD');
				});
                $(".fecha_hasta_text").datepicker({
		        	format: 'dd-mm-yyyy',
		        	autoclose: true
		    	}).on('changeDate', function(ev) {
                    self.detalle.fecha_hasta =  moment( new Date(ev.date) ).format('Y-MM-DD');
				});
                
                $('#autoridad-autoridades_tipo_select2').select2({
                    dropdownParent: $("#modal-autoridad"),
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                        data: function(params) {
                            var query = {
                                search: params.term,
                                tipo: 'autoridades_tipo'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                });
                $("#autoridad-autoridades_tipo_select2").empty().append('<option value="'+obj.autoridad_tipo.autoridad_tipo_id+'">'+obj.autoridad_tipo.nombre+'</option>').val(+obj.autoridad_tipo.autoridad_tipo_id).trigger('change');
            },  
            updateAutoridad: function(){
                this.cleanError();
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("entidad_id", "{{ $d->entidad_id }}")
                formData.append("_method", "PUT");
                for (var key in this.detalle) {
                    formData.append(key, this.detalle[key]);
                }
                formData.append("autoridad_tipo", $('#autoridad-autoridades_tipo_select2').val());
                fetch('{{ url("api/v1/acreditaciones/autoridad") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 400) {
                        for (i in data.error) {
                            document.getElementById('autoridades-' + i + '-error').style.display = 'block';
                            document.getElementById('autoridades-' + i + '-error').textContent = data.error[i][0];
                        }
                    } else {
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
            deleteArchivo: function(obj){
                self = this;
                swal({
                    title: "Eliminar Archivo",
                    text: '¿Está seguro de eliminar esta Archivo?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result) {
                        let self = this;
                        var formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("_method", "DELETE");
                        formData.append("id", obj.file_id)
                        fetch('{{ url("api/v1/acreditaciones/archivo") }}', 
                        {
                                method: 'POST',
                                body: formData
                            })
                            .then(function(response) {
                                if (response.ok) {
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
            deleteAutoridad: function(id){
                self = this;
                swal({
                    title: "Eliminar Autoridad",
                    text: '¿Está seguro de eliminar esta Autoridad?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result) {
                        let self = this;
                        var formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("_method", "DELETE");
                        formData.append("id", id)
                        fetch('{{ url("api/v1/acreditaciones/autoridad") }}', {
                                method: 'POST',
                                body: formData
                            })
                            .then(function(response) {
                                if (response.ok) {
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
            cleanError: function() {
                let error = document.querySelectorAll('.error');
                for (let i = 0; i < error.length; i++) {
                    error[i].style.display = 'none';
                }
            },
            storeContacto: function() {
                this.cleanError();
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("entidad_id", "{{ $d->entidad_id }}")
                for (var key in this.detalle) {
                    formData.append(key, this.detalle[key]);
                }
                formData.append("autoridad_tipo", $('#autoridades_tipo_select2').val());
                fetch(this.url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 400) {
                            for (i in data.error) {
                                document.getElementById('contacto-' + i + '-error').style.display = 'block';
                                document.getElementById('contacto-' + i + '-error').textContent = data.error[i][0];
                            }
                        } else {
                            self.ajax();
                            $('#modal-contacto').modal('hide');
                        }
                    })
                    .then(function(texto) {
                        console.warn(texto);
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
            },
            updateContacto: function() {
                this.cleanError();
                let self = this;
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("_method", "PUT");
                for (var key in this.detalle) {
                    formData.append(key, this.detalle[key]);
                }
                formData.append("autoridad_tipo", $('#autoridades_tipo_select2').val());
                fetch(this.url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 400) {
 
                            for (i in data.error) {
                                document.getElementById('contactos-' + i + '-error').style.display = 'block';
                                document.getElementById('contactos-' + i + '-error').textContent = data.error[i][0];
                            }
                        } else {
                            self.ajax();
                            $('#modal-contacto').modal('hide');
                        }
                    })
                    .then(function(texto) {
                        console.log(texto);
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
            },
            deleteContacto: function(id) {
                self = this;
                swal({
                    title: "Eliminar contacto",
                    text: '¿Está seguro de eliminar este contacto?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result) {
                        let self = this;
                        var formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("_method", "DELETE");
                        formData.append("id", id)
                        fetch(this.url, {
                                method: 'POST',
                                body: formData
                            })
                            .then(function(response) {
                                if (response.ok) {
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
            Comentario: function(obj) {
                this.archivo = obj;
                $('#archivo_tipo').select2({
                    dropdownParent: $("#modal-comentario")
                }).val(obj.archivo_tipo_id).trigger("change");
                $('#modal-comentario').modal('show');
            },
            updateComentario: function() {
                let self = this;
                var formData = new FormData();
                this.archivo.archivo_tipo_id = $('#archivo_tipo').val();
                formData.append("_token", "{{ csrf_token() }}");
                for (var key in this.archivo) {
                    formData.append(key, this.archivo[key]);
                }
                fetch("{{ url('api/v1/acreditaciones/file/comment') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 400) {
                        console.log(data)
                    } else {
                        self.ajax();
                        $('#modal-comentario').modal('hide');
                    }
                })
                .then(function(texto) {
                    console.warn(texto);
                })
                .catch(function(err) {
                    console.log(err);
                });
            },
            Aceptar: function() {
                let self = this;
                $('.fecha_vencimiento_autoridades').datepicker({
                    format: 'dd-mm-yyyy',
		        	autoclose: true,
                    setDate: null
		    	}).on('changeDate', function(ev) {
                    self.aceptar_post.fecha_vencimiento_autoridades =  moment( new Date(ev.date) ).format('Y-MM-DD');
				});
                $('#modal-aceptar').modal('show');
            },
            postAceptar: function() {
                let self = this;
                let providencia = false;
                if({{Auth::user()->funcion }} == 3) {
                    for (let index = 0; index < this.archivos.length; index++) {
                        if (this.archivos[index].archivo_tipo_id == 4) {
                            providencia = true;
                        }
                    }
                }
                if({{ Auth::user()->funcion }} != 3) {
                    providencia = true;
                }
                if(!providencia) {
                    swal({
                        title: "Acreditación",
                        text: 'Para aceptar la acreditación es necesario subir un archivo de tipo providencia',
                        showCloseButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result) {
                            swal.close();
                            $('#modal-aceptar').modal('hide');
                        }
                    });
                }
                if (providencia) {
                    data = new FormData();
                    data.append("_token", "{{ csrf_token() }}");
                    data.append('id', {{ $d->entidad_id }});
                    data.append('descripcion', this.aceptar_post.detalle);
                    data.append('if', this.aceptar_post.if);
                    data.append('re', this.aceptar_post.re);
                    data.append('providencia', this.aceptar_post.providencia);
                    data.append('fecha_vencimiento_autoridades', this.aceptar_post.fecha_vencimiento_autoridades);
                    if ($('#aceptar_file')[0].files[0]) {
                        data.append('file', $('#aceptar_file')[0].files[0]);
                    }
                    fetch('{{ url("api/v1/acreditaciones/file/aceptar") }}', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 400) {
                            for (i in data.error) {
                                document.getElementById('aceptar-' + i + '-error').style.display = 'block';
                                document.getElementById('aceptar-' + i + '-error').textContent = data.error[i][0];
                            }
                        } else {
                            self.ajax();
                            toastr.success('acción guardada satisfactoriamente');
                            $('#modal-aceptar').modal('hide');
                            location.reload();
                        }
                    })
                    .then(function(texto) {
                        console.warn(texto);
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
                }
            },
            Rechazar: function() {
                $('#modal-rechazar').modal('show');
            },
            postRechazar: function() {
                let self = this;
                data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                data.append('id', {{ $d->entidad_id }});
                data.append('descripcion', this.rechazar_post.detalle);
                if ($('#rechazar_file')[0].files[0]) {
                    data.append('file', $('#rechazar_file')[0].files[0]);
                }
                fetch('{{ url("api/v1/acreditaciones/rechazar") }}', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 400) {
                            console.log(data)
                        } else {
                            self.ajax();
                            toastr.success('acción guardada satisfactoriamente');
                            $('#modal-rechazar').modal('hide');
                            location.reload();
                        }
                    })
                    .then(function(texto) {
                        console.warn(texto);
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
            },
            consulta: function(obj = {}) {
                this.consulta_post = obj;
                $('#modal-consulta').modal('show');
            },
            Respuesta: function(obj) {
                this.consulta_post = obj;
                $('#modal-consulta').modal('show');
            },
            postConsulta: function() {
                self = this;
                data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                data.append('id', {{ $d->entidad_id }} );
                data.append('detalle', this.consulta_post.detalle);
                data.append('codigo', this.consulta_post.codigo);
                data.append('respuesta', this.consulta_post.respuesta);
                data.append('consulta_id', this.consulta_post.consulta_id);
                $.ajax({
                    url: '{{ url("api/v1/acreditaciones/consulta") }}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        console.log(data);
                        $('#modal-consulta').modal('hide');
                        self.ajax();
                        toastr.success('acción guardada satisfactoriamente');
                    }
                });
            },
            deleteConsulta: function(obj) {
                self = this;
                data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                data.append('consulta_id', obj.consulta_id);
                $.ajax({
                    url: '{{ url("api/v1/acreditaciones/consulta/delete") }}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        console.log(data);
                        $('#modal-consulta').modal('hide');
                        toastr.success('acción guardada satisfactoriamente');
                        self.ajax();
                    }
                });
            },
            observacion: function(obj = {}) {
                this.observacion_post = obj;
                $('#modal-observacion').modal('show');
            },
            postObservacion() {
                self = this;
                data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                data.append('id', {{ $d->entidad_id }});
                data.append('descripcion', this.observacion_post.descripcion);
                data.append('observacion_id', this.observacion_post.observacion_id);
                $.ajax({
                    url: '{{ url("api/v1/acreditaciones/observacion") }}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        console.log(data);
                        $('#modal-observacion').modal('hide');
                        self.ajax();
                        toastr.success('acción guardada satisfactoriamente');
                    }
                });
            },
            deleteObservacion: function(obj) {
                self = this;
                data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                data.append('observacion_id', obj.observacion_id);
                $.ajax({
                    url: '{{ url("api/v1/acreditaciones/observacion/delete") }}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        console.log(data);
                        $('#modal-observacion').modal('hide');
                        toastr.success('acción guardada satisfactoriamente');
                        self.ajax();
                    }
                });
            },
            async ajax() {
                let parameters = '?';
                parameters += 'id=' + {{ $d-> entidad_id }};
                const res = await fetch(this.url + parameters, {
                    method: 'GET'
                });
                const data = await res.json();
                this.data = data;
                this.contactos = data.contactos;
                this.archivos = data.archivos;
                this.movimientos = data.movimiento;
                this.consultas = data.consultas;
                this.observaciones = data.observaciones;
                this.autoridades = data.autoridades;
            },
        },
        mounted() {
            this.init();
        }
    });
    App.mount('#app');
</script>
@endsection