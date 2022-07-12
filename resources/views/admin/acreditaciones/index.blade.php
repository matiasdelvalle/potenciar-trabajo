@extends('admin.layout.app')

@section('css')
<link href="{{ asset('/admin_style/assets/toastr/toastr.min.css') }}" 						type="text/css" 	rel="stylesheet">
<link href="{{ asset('/admin_style/assets/select2/select2.css') }}" 						type="text/css" 	rel="stylesheet">
<link href="{{ asset('/admin_style/assets/bootstrap-datepicker/css/datepicker.css') }}"   	type="text/css"     rel="stylesheet">
<link href="{{ asset('/admin_style/css/quirk.css') }}" type="text/css"  rel="stylesheet">
<style>
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #fff transparent transparent transparent;
    }
    .select2-container--default .select2-selection--single {
    border-radius: 0px;
    background-color: #37bbed !important;
    border-color: #ffffff;
    border-width: 0px;
    }
    .select2-container .select2-selection--single {
        height: 28px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2;
        color:#37bbed!important;
    }
    th{
        vertical-align:middle!important;
        padding:0px!important;
        text-align:center;
        width: 120px;
    }
    td{
        display: table-cell!important;
        vertical-align: middle!important;
    }
    tr{
        cursor:pointer;
    }
</style>
@endsection

@section('content')
<div class="panel" id="app">
    <div class="panel-heading">
        <h4 class="panel-title">Listado de Acreditaciones</h4>
    </div>
    @can('crear_acreditaciones')
    <a @click="$root.create()" class="btn btn-default btn-add"><i style="margin-right: 5px" class="fa fa-plus"></i>Agregar Acreditaciones</a>
    @endcan
    
    <a @click="$root.export({ url: '{{ url('xls/acreditaciones')}}', 'tipo': 'xls' })" class="btn btn-default btn-add">Descargar Excel</i></a>	

    <div class="panel-body">
        <div class="row">
			<div class="col-md-12">
				<div class="btn-group pull-left"  v-for="filter in filters">
					<span @click="$root.remove_filters(filter.name)" class="btn_filter" title="Click para quitar este filtro" class="label label-success">
						<i class="fa fa-remove" aria-hidden="true"></i><a>@{{ filter.value }}</a>
					</span>
				</div>
			</div>
		</div>
        <div class="table-responsive">
            <table class="table nomargin">
                <thead>
                    <tr>
                        <th>
                        <span class="header-table-text">CUIT</span>
                            <select name="" id="cuit" class="select2" style="width:100%">
                                <option value="">CUIT</option>
                                <option v-for="a in acreditaciones" :value="a.cuit">@{{ a.cuit }}</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">EXPEDIENTE GDE</span>
                            <select name="" id="expediente_gde" class="select2" style="width:100%">
                                <option value="">EXPEDIENTE GDE</option>
                                <option v-for="a in acreditaciones" :value="a.expediente">@{{ a.expediente }}</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">RAZON SOCIAL</span>
                            <select name="" id="razon_social" class="select2" style="width:100%">
                                <option value="">RAZON SOCIAL</option>
                                <option v-for="a in acreditaciones" :value="a.razon_social">@{{ a.razon_social }}</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">PROGRAMA</span>
                            <select name="" id="programa" class="select2" style="width:100%">
                                <option value="">PROGRAMA</option>
                                <option v-for="p in programas" :value="p.programa_id">@{{ p.acronimo }}</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">ESTADO</span>
                            <select name="entidad_estado" id="entidad_estado" class="select2" style="width:100%">
                                <option value="">ESTADO</option>
                                <option v-for="e in entidad_estados" :value="e.estado_id">@{{ e.descripcion }}</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">ABOGADO</span>
                            <select name="" id="abogado" class="select2" style="width:100%">
                                <option value="">ABOGADO</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">TECNICO</span>
                            <select name="" id="tecnico" class="select2" style="width:100%">
                                <option value="">TECNICO</option>
                            </select>
                        </th>                        
                        <th>
                        <span class="header-table-text">REGISTRO</span>
                            <select name="" id="estado" class="select2" style="width:100%">
                                <option value="">REGISTRO</option>
                                <option v-for="e in estados" :value="e.estado_registro_id">@{{ e.descripcion }}</option>
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data.data" @click="$root.show(item.entidad_id)" >
                        <td maxlength="13" class="cuil">@{{ item.cuit }}</td>
                        <td>@{{ item.expediente }}</td>
                        <td>@{{ item.razon_social }}</td>
                        <td>@{{ item.programa ? item.programa.acronimo : '' }}</td>
                        <td :class="'bg-'+item.entidad_estado.classname" class="bg-table">@{{ item.entidad_estado ? item.entidad_estado.descripcion : '' }}</td>
                        <td>@{{ item.abogado ? item.abogado.name : '' }}</td>
                        <td>@{{ item.tecnico ? item.tecnico.name : '' }}</td>
                        <td>@{{ item.estado.descripcion }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p>Mostrando del <span>@{{ data.from }}</span> al <span>@{{ data.to }}</span> de <span>@{{ data.total }}</span> registros</p>
        <ul class="pagination">
            <li v-bind:class="data.prev_page_url == null ? 'disabled' : ''"><a @click="goTo(1)">« Primera</a></li> 
            <li v-if="data.current_page - 100 > 0"   @click="goTo(data.current_page - 100)"><span>@{{ data.current_page-100 }}</span></li>
            <li v-if="data.current_page - 50  > 0"   @click="goTo(data.current_page - 50)"><span>@{{ data.current_page-50 }}</span></li>
            <li v-if="data.current_page - 10  > 0"   @click="goTo(data.current_page - 10)"><span>@{{ data.current_page-10 }}</span></li>
            <li v-if="data.current_page - 5   > 0"   @click="goTo(data.current_page - 5)"><span>@{{ data.current_page-5 }}</span></li>
            <li v-if="data.current_page - 2   > 0"   @click="goTo(data.current_page - 2)"><span>@{{ data.current_page-2 }}</span></li>
            <li v-if="data.current_page - 1   > 0"   @click="goTo(data.current_page - 1)"><span>@{{ data.current_page-1 }}</span></li>
            <li class="active"><span>@{{ data.current_page }}</span></li>
            <li v-if="data.current_page + 1   <= data.last_page"   @click="goTo(data.current_page + 1)"><span>@{{ data.current_page + 1 }}</span></li>
            <li v-if="data.current_page + 2   <= data.last_page"   @click="goTo(data.current_page + 2)"><span>@{{ data.current_page + 2 }}</span></li>
            <li v-if="data.current_page + 5   <= data.last_page"   @click="goTo(data.current_page + 5)"><span>@{{ data.current_page + 5 }}</span></li>
            <li v-if="data.current_page + 10  <= data.last_page"   @click="goTo(data.current_page + 10)"><span>@{{ data.current_page + 10 }}</span></li>
            <li v-if="data.current_page + 50  <= data.last_page"   @click="goTo(data.current_page + 50)"><span>@{{ data.current_page + 50 }}</span></li>
            <li v-if="data.current_page + 100 <= data.last_page"   @click="goTo(data.current_page + 100)"><span>@{{ data.current_page + 100 }}</span></li>			
            <li v-bind:class="data.last_page == null || data.current_page <= data.last_page ? 'disabled' : ''"><a @click="goTo(data.last_page)">Última »</a></li> 
        </ul>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/admin_style/assets/moment/moment-with-locales.min.js')}}"></script>
<script src='{{ asset("/admin_style/assets/sweetalert2/sweetalert2.min.js") }}'></script>
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src="{{ asset('/admin_style/assets/jquery-mask/dist/jquery.mask.js')}}"></script>
<script src="{{ asset('/admin_style/assets/vue/vue') }}"></script>
<script>
  	let App = Vue.createApp({
    	data() {
      		return {
      			url:'{{ url("api/v1/acreditaciones") }}',
      			page: 1,
      			reload: 1000 * 60 * 2,
        		data:[],
                programas: {!! $programas !!},
                acreditaciones: {!! $acreditaciones !!},
                estados: {!! $estados !!},
                entidad_estados: {!! $entidad_estados !!},
                filters:[],
                cuit: '',
                cuit_text: '',
                expediente: '',
                expediente_text: '',                
                razon_social: '',
                razon_social_text: '',
                programa: '',
                programa_text: '',
                entidad_estado: '',
                entidad_estado_text: '',
                estado: '',
                estado_text: '',
                abogado: '',
                abogado_text: '',
                tecnico: '',
                tecnico_text: ''

      		}
    	},
    	methods: {
    		init: function(){
                let self = this
				moment.locale('es');
                $('.cuil').mask('00-00000000-00');
                $('.select2').select2().on('change', function (e) {
					self.filter(this);
                });
                $('#abogado').select2({
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                            data: function (params) {
                            var query = {
                                search: params.term,
                                tipo: 'abogado'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                }).on('change', function (e) {
                    self.filter(this);
                });
                $('#tecnico').select2({
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                            data: function (params) {
                            var query = {
                                search: params.term,
                                tipo: 'tecnico'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                }).on('change', function (e) {
                    self.filter(this);
                });

                self.initEstado();
    			this.myTimeout = setTimeout(function(){
	    			this.ajax()
    			}.bind(this), 100);
    		},
    		goTo: function(page){
    			this.page = page;
    			this.ajax();
    		},
            filter: function(element){
				this.page = 1;
				if(element.id == 'cuit'){           this.cuit 		    = element.value; this.cuit_text 	        = $(element).find("option:selected").text(); }
				if(element.id == 'expediente_gde'){ this.expediente 	= element.value; this.expediente_text 	    = $(element).find("option:selected").text(); }
				if(element.id == 'razon_social'){   this.razon_social 	= element.value; this.razon_social_text     = $(element).find("option:selected").text(); }
				if(element.id == 'programa'){       this.programa 		= element.value; this.programa_text 	    = $(element).find("option:selected").text(); }
				if(element.id == 'estado'){         this.estado 		= element.value; this.estado_text 	        = $(element).find("option:selected").text(); }                
				if(element.id == 'entidad_estado'){ this.entidad_estado = element.value; this.entidad_estado_text 	= $(element).find("option:selected").text(); }                
				if(element.id == 'abogado'){        this.abogado        = element.value; this.abogado_text 	        = $(element).find("option:selected").text(); }                
				if(element.id == 'tecnico'){        this.tecnico        = element.value; this.tecnico_text 	        = $(element).find("option:selected").text(); }                
				this.update_filters();
				this.ajax();
			},                      
            update_filters: function(){
				this.filters = [];
				if(this.cuit            != '') this.filters.push({ key: 'cuit', 	        v: this.cuit,           value: this.cuit_text, 	        name: 'cuit'            });
				if(this.expediente      != '') this.filters.push({ key: 'expediente', 	    v: this.expediente,     value: this.expediente_text, 	name: 'expediente'      });
				if(this.razon_social    != '') this.filters.push({ key: 'razon_social', 	v: this.razon_social,   value: this.razon_social_text, 	name: 'razon_social'    });
				if(this.programa  	    != '') this.filters.push({ key: 'programa', 	    v: this.programa,       value: this.programa_text, 		name: 'programa'        });
				if(this.estado  	    != '') this.filters.push({ key: 'estado', 		    v: this.estado,         value: this.estado_text, 	    name: 'estado'          });
				if(this.entidad_estado  != '') this.filters.push({ key: 'entidad_estado', 	v: this.entidad_estado, value: this.entidad_estado_text,name: 'entidad_estado'  });
				if(this.abogado         != '') this.filters.push({ key: 'abogado', 	        v: this.abogado,        value: this.abogado_text,       name: 'abogado'         });
				if(this.tecnico         != '') this.filters.push({ key: 'tecnico', 	        v: this.tecnico,        value: this.tecnico_text,       name: 'tecnico'         });
			},
			remove_filters: function(name){
				if(name == 'cuit'){             this.cuit 	        = ''; 	this.cuit_text              = '';  }
				if(name == 'expediente'){       this.expediente     = ''; 	this.expediente_text        = '';  }
				if(name == 'razon_social'){     this.razon_social   = ''; 	this.razon_social_text      = '';  }
				if(name == 'programa'){         this.programa 	    = ''; 	this.programa_text          = '';  }
                if(name == 'estado'){           this.estado         = ''; 	this.estado_text            = '';  }                
                if(name == 'entidad_estado'){   this.entidad_estado = ''; 	this.entidad_estado_text    = '';  }                
                if(name == 'abogado'){          this.abogado = ''; 	        this.abogado_text           = '';  }
                if(name == 'tecnico'){          this.tecnico = ''; 	        this.tecnico_text           = '';  }
				$('#'+name).val("").trigger("change");
				this.update_filters();
				this.ajax();
			},
            initEstado: function(){
                this.page 			= 1;
	    		this.estado 		= 1;
	    		this.estado_text 	= 'ACTIVO';
	    		this.update_filters();
            },
            create: function(){
				window.location = document.URL+'/create';	
			},
            show: function(id, event){
                window.location = "{{ url('acreditaciones') }}"+'/'+id;
            },
    		DateFormat: function(element, format){
   				return moment(element).format(format);
            },
            export: function(obj){
                console.log( obj );
    			let url = obj.url;
    			let parameters  = '?';
				for(i in this.filters){
					parameters += '&'+this.filters[i].key+'='+this.filters[i].v;
				}
                // console.log( url + parameters );
    			window.location.href = url + parameters;
    		},
    		async ajax(){
                self = this;
                let parameters  = '?';
					parameters += 'page='+this.page;
				for(i in this.filters){
					parameters += '&'+this.filters[i].key+'='+this.filters[i].v;
				}
                fetch(this.url + parameters)
                .then(function(response){
                    return response.json();
                })
                .then(function(data){
                    self.data = data;
                });
	    		clearInterval(this.myTimeout);
		        this.myTimeout = setTimeout(function(){
		        	this.ajax();
		        }.bind(this), this.reload);
    		},
    	},
    	mounted() {
    		this.init();
    	}
  	});
  	App.mount('#app');

      var input = document.querySelectorAll('.js-date')[0];
var dateInputMask = function dateInputMask(elm) {
  elm.addEventListener('keypress', function(e) {
    if(e.keyCode < 47 || e.keyCode > 57) {
      e.preventDefault();
    }
    
    var len = elm.value.length;
    
    // If we're at a particular place, let the user type the slash
    // i.e., 12/12/1212
    if(len !== 1 || len !== 3) {
      if(e.keyCode == 47) {
        e.preventDefault();
      }
    }
    
    // If they don't add the slash, do it for them...
    if(len === 2) {
      elm.value += '-';
    }

    // If they don't add the slash, do it for them...
    if(len === 11) {
      elm.value += '-';
    }
  });
};
  
dateInputMask(input);
</script>
@endsection