@extends('admin.layout.app')
@section('css')
<link href="{{ asset('/admin_style/assets/bootstrap-datepicker/css/datepicker.css') }}"   	type="text/css"     rel="stylesheet">

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
td.col_1 {
    text-align: left;
}
th{
    vertical-align:middle!important;
    padding:0px!important;
    text-align:center;
}
.table > thead > tr > td, .table > thead > tr > th{
	width: 300px !important;
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
		<h4 class="panel-title">Listado Usuarios</h4>
	</div>

    <a @click="$root.create()" class="btn btn-default btn-add"><i style="margin-right: 5px" class="fa fa-plus"></i>Agregar Usuario</a>

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
						<span class="header-table-text">USUARIOS</span>
                            <select name="" id="usuarios" class="select2" style="width:100%">
                                <option value="">USUARIOS</option>
                                <option v-for="u in usuarios" :value="u.id">@{{ u.name  }}</option>
                            </select>
                        </th>
                        <th>
						<span class="header-table-text">E-MAIL</span>
							<select name="" id="mail" class="select2" style="width:100%">
                                <option value="">E-MAIL</option>
								<option v-for="u in usuarios" :value="u.id">@{{ u.email  }}</option>
                            </select>
                        </th>                        
						<th>
						<span class="header-table-text">FUNCION</span>
							<select name="" id="funcion" class="select2" style="width:100%">
								<option value="">FUNCION</option>
								<option v-for="u in funciones" :value="u.funcion_id">@{{ u.nombre  }}</option>
							</select>
						</th>
                        <th>
						<span class="header-table-text">PERFIL</span>
							<select name="" id="perfil" class="select2" style="width:100%">
                                <option value="">PERFIL</option>
								<option v-for="u in perfiles" :value="u.id">@{{ u.name  }}</option>
                            </select>
                        </th>						
                        <th>
						<span class="header-table-text">ESTADO</span>
                            <select name="" id="estado" class="select2" style="width:100%">
                                <option value="">ESTADO</option>
                                <option v-for="e in estados" :value="e.estado_registro_id">@{{ e.descripcion }}</option>
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data.data" @click="$root.show(item.id)">
                        <td class="text-left" >@{{ item.name }}</td>
                        <td class="text-left" >@{{ item.email }}</td>
                        <td class="text-left" >@{{ item.funcion ? item.funcion.nombre : '-' }}</td>
                        <td class="text-left" >
							<ul v-for="r in item.roles">
								<li class="label label-primary">@{{ r.name }}</li>
							</ul>
						</td>
                        <td class="text-left" @click="$root.show(item.secretaria_id)">@{{ item.estado ? item.estado.descripcion : '' }}</td>
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

<script src='{{ asset("/admin_style/assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("/admin_style/assets/sweetalert/sweet-alert.min.js") }}'></script>
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src="{{ asset('/admin_style/assets/moment/moment-with-locales.min.js')}}"></script>
<script src="{{ asset('/admin_style/assets/vue/vue') }}"></script>
<script>
	let App = Vue.createApp({
    	data() {
      		return {
      			url:'{{ url("api/v1/usuarios") }}',
      			page: 1,
      			reload: 1000 * 60 * 2,
        		data:[],
                usuarios: {!! $usuarios !!},
                perfiles: [],
                estados: [],
				funciones: [],
                filters:[],
                usuario: '',
                usuario_text: '',
                mail: '',
                mail_text: '',				
                funcion: '',
                funcion_text: '',				
                perfil: '',
                perfil_text: '',
                estado: '',
                estado_text: ''                
      		}
    	},
    	methods: {
    		init: function(){
                let self = this
				moment.locale('es');
                $('.select2').select2().on('change', function (e) {
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
				if(element.id == 'usuarios'){
					this.usuario 		= element.value;
					this.usuario_text 	= $(element).find("option:selected").text();
				}
				if(element.id == 'mail'){
					this.mail 		= element.value;
					this.mail_text 	= $(element).find("option:selected").text();
				}				
				if(element.id == 'estado'){
					this.estado 		= element.value;
					this.estado_text 	= $(element).find("option:selected").text();
				}	
				if(element.id == 'funcion'){
					this.funcion 		= element.value;
					this.funcion_text 	= $(element).find("option:selected").text();
				}				
				if(element.id == 'perfil'){
					this.perfil 		= element.value;
					this.perfil_text 	= $(element).find("option:selected").text();
				}								
				this.update_filters();
				this.ajax();
			},
            update_filters: function(){
				this.filters = [];
				if(this.usuario  	!= '') this.filters.push({ key: 'usuario', 		v: this.usuario, 	value: this.usuario_text, 		name: 'usuario'    	});
				if(this.mail  		!= '') this.filters.push({ key: 'mail', 		v: this.mail, 		value: this.mail_text, 			name: 'mail'    	});
				if(this.perfil  	!= '') this.filters.push({ key: 'perfil', 		v: this.perfil, 	value: this.perfil_text, 		name: 'perfil'    	});
				if(this.funcion  	!= '') this.filters.push({ key: 'funcion', 		v: this.funcion, 	value: this.funcion_text, 		name: 'funcion'    	});
				if(this.estado  	!= '') this.filters.push({ key: 'estado', 		v: this.estado, 	value: this.estado_text, 	    name: 'estado'      });
			},
			remove_filters: function(name){
				if(name == 'usuario'){      this.usuario 	= ''; 	this.usuario_text = '';     }
				if(name == 'mail'){      	this.mail 		= ''; 	this.mail_text = '';     	}
                if(name == 'estado'){       this.estado     = ''; 	this.estado_text = '';      }                
				if(name == 'perfil'){     	this.perfil 	= ''; 	this.perfil_text = '';    	}
				if(name == 'funcion'){     	this.funcion 	= ''; 	this.funcion_text = '';    	}
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
                window.location = document.URL+'/'+id+'/edit';
            },
    		DateFormat: function(element, format){
   				return moment(element).format(format);
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
  	})
    .mount('#app');
</script>

@endsection

