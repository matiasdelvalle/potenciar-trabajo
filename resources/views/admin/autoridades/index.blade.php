@extends('admin.layout.app')

@section('css')
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
        width: 80px;
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
        <h4 class="panel-title">Listado de Autoridades</h4>
    </div>

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
                            <span class="header-table-text">Entidad</span>
                            <select name="" id="acreditacion" class="select2" style="width:100%">
                                <option value="">Acreditaciones</option>
                            </select>
                        </th>
                        <th>
                            <span class="header-table-text">TIPO AUTORIDAD</span>
                            <select name="" id="autoridades_tipo" class="select2" style="width:100%">
                                <option value="">Autoridades</option>
                            </select>
                        </th>                   
                        <th>
                            <span class="header-table-text">DNI</span>
                            <select name="" id="autoridades_dni" class="select2" style="width:100%">
                                <option value="">DNI</option>
                            </select>
                        </th>
                        <th>AUTORIDAD</th>
                        <th>FECHA DESDE</th>
                        <th>FECHA HASTA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data.data" @click="$root.show(item.secretaria_id)">
                        <td class="text-left">@{{ item.entidad.razon_social }}</td>
                        <td class="text-left">@{{ item.autoridad_tipo ? item.autoridad_tipo.nombre : '-' }}</td>
                        <td class="text-right dni">@{{ item.dni }}</td>
                        <td class="text-left">@{{ item.nombre }} @{{ item.apellido }}</td>
                        <td class="text-right">@{{ $root.DateFormat(item.fecha_desde,'DD-MM-YYYY') }}</td>
                        <td class="text-right">@{{ $root.DateFormat(item.fecha_hasta,'DD-MM-YYYY') }}</td>
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
      			url:'{{ url("api/v1/autoridades") }}',
      			page: 1,
      			reload: 1000 * 60 * 2,
        		data:[],
                filters:[],
                acreditacion: '',
                acreditacion_text: '',
                autoridades_tipo: '',
                autoridades_tipo_text: '',
                autoridades_dni: '',
                autoridades_dni_text: '',
      		}
    	},
    	methods: {
    		init: function(){
                let self = this
				moment.locale('es');
                $('.dni').mask('000.000.000', {reverse: true});
                $('#acreditacion').select2({
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                            data: function (params) {
                            var query = {
                                search: params.term,
                                tipo: 'acreditaciones'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                }).on('change', function (e) {
                    self.filter(this);
                });
                $('#autoridades_tipo').select2({
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                            data: function (params) {
                            var query = {
                                search: params.term,
                                tipo: 'autoridades_tipo'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                }).on('change', function (e) {
                    self.filter(this);
                });
                $('#autoridades_dni').select2({
                    ajax: {
                        url: '{{ url("api/v1/autocomplete") }}',
                            data: function (params) {
                            var query = {
                                search: params.term,
                                tipo: 'autoridades_dni'
                            }
                            return query;
                        },
                        dataType: 'json',
                    },
                    minimumInputLength: 0,
                }).on('change', function (e) {
                    self.filter(this);
                });                
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
				if(element.id == 'acreditacion'){       this.acreditacion 	    = element.value; this.acreditacion_text 	    = $(element).find("option:selected").text(); }
				if(element.id == 'autoridades_tipo'){   this.autoridades_tipo 	= element.value; this.autoridades_tipo_text 	= $(element).find("option:selected").text(); }
				if(element.id == 'autoridades_dni'){    this.autoridades_dni 	= element.value; this.autoridades_dni_text 	    = $(element).find("option:selected").text(); }
				this.update_filters();
				this.ajax();
			},
            update_filters: function(){
				this.filters = [];
				if(this.acreditacion  	    != '') this.filters.push({ key: 'acreditacion', 	    value: this.acreditacion_text, 		    name: 'acreditacion'        });
				if(this.autoridades_tipo  	!= '') this.filters.push({ key: 'autoridades_tipo', 	value: this.autoridades_tipo_text, 		name: 'autoridades_tipo'    });
				if(this.autoridades_dni  	!= '') this.filters.push({ key: 'autoridades_dni', 	    value: this.autoridades_dni_text, 		name: 'autoridades_dni'    });
			},
			remove_filters: function(name){
				if(name == 'acreditacion'){         this.acreditacion 	    = ''; 	this.acreditacion_text      = '';    }
				if(name == 'autoridades_tipo'){     this.autoridades_tipo 	= ''; 	this.autoridades_tipo_text  = '';    }
				if(name == 'autoridades_dni'){     this.autoridades_dni 	= ''; 	this.autoridades_dni_text   = '';    }
				$('#'+name).val("").trigger("change");
				this.update_filters();
				this.ajax();
			},
    		DateFormat: function(element, format){
                if(moment(element).isValid()){
                    return moment(element).format(format);
                }else{
                    return 'Indeterminado'
                }
            },
    		async ajax(){
                self = this;
    			let parameters  = '?';
    				parameters += 'page='+this.page;
    				parameters += '&acreditacion='+this.acreditacion;
    				parameters += '&autoridades_tipo='+this.autoridades_tipo;
    				parameters += '&autoridades_dni='+this.autoridades_dni;
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
  	})
    .mount('#app');
</script>
@endsection