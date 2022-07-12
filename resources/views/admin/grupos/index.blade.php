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
        padding:10px!important;
        /* text-align:center; */
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
        <h4 class="panel-title">Listado de Grupos</h4>
    </div>

    <a @click="$root.create()" class="btn btn-default btn-add"><i style="margin-right: 5px" class="fa fa-plus"></i>Agregar Grupo</a>

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
            <table class="table table-hover table-striped nomargin">
                <thead>
                    <tr>
                        <th>GRUPOS</th>
                        <th>PERMISOS</th>                        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data.data" @click="$root.show(item.id)">
                        <td class="text-left">@{{ item.name }}</td>
                        <td class="text-left">
                            <span v-for="p in item.permissions" class="label label-primary">@{{ p.label }}</span>
                        </td>
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
<script src="{{ asset('/admin_style/assets/vue/vue') }}"></script>
<script>

  	let App = Vue.createApp({
    	data() {
      		return {
      			url:'{{ url("api/v1/roles") }}',
      			page: 1,
      			reload: 1000 * 60 * 2,
        		data:[],
                programas: [],
                secretarias: [],
                subsecretarias: [],
                estados: [],
                filters:[],
                programa: '',
                programa_text: '',
                acronimo: '',
                acronimo_text: '',
                secretaria: '',
                secretaria_text: '',
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
				if(element.id == 'cuit'){
					this.cuit 		= element.value;
					this.cuit_text 	= $(element).find("option:selected").text();
				}
				if(element.id == 'expediente_gde'){
					this.expediente 		= element.value;
					this.expediente_text 	= $(element).find("option:selected").text();
				}
				if(element.id == 'razon_social'){
					this.razon_social 		= element.value;
					this.razon_social_text 	= $(element).find("option:selected").text();
				}
				if(element.id == 'programa'){
					this.programa 		= element.value;
					this.programa_text 	= $(element).find("option:selected").text();
				}
				if(element.id == 'estado'){
					this.estado 		= element.value;
					this.estado_text 	= $(element).find("option:selected").text();
				}                
				this.update_filters();
				this.ajax();
			},          
            update_filters: function(){
				this.filters = [];
				if(this.programa  	!= '') this.filters.push({ key: 'programa', 	v: this.programa, 	value: this.programa_text, 		name: 'programa'    });
				if(this.acronimo  	!= '') this.filters.push({ key: 'acronimo', 	v: this.acronimo, 	value: this.acronimo_text, 		name: 'acronimo'    });
				if(this.secretaria  != '') this.filters.push({ key: 'secretaria', 	v: this.secretaria, value: this.secretaria_text, 	name: 'secretaria'  });
				if(this.estado  	!= '') this.filters.push({ key: 'estado', 		v: this.estado, 	value: this.estado_text, 	    name: 'estado'      });
			},
			remove_filters: function(name){
				if(name == 'programa'){     this.programa 	= ''; 	this.programa_text = '';    }
				if(name == 'acronimo'){     this.acronimo 	= ''; 	this.acronimo_text = '';    }
                if(name == 'secretaria'){   this.secretaria = ''; 	this.secretaria_text = '';  }                
                if(name == 'estado'){       this.estado     = ''; 	this.estado_text = '';      }                
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
            delete: function(id, event){
                self = this;
                swal({
                    title: "{{ env('APP_NAME') }}",
                    text: '¿Está seguro de eliminar este Programa?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText:  'Cancelar',
                }).then((result) => {
                    if (result) {
                        const data = new FormData( document.getElementById('eliminar+'+id) );
                        fetch("{{ url('programas') }}"+"/"+id, {
                            method: 'POST',
                            body: data
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
    		DateFormat: function(element, format){
   				return moment(element).format(format);
            },
    		async ajax(){
                self = this;
    			let parameters  = '?';
    				parameters += 'page='+this.page;
    				parameters += '&programa='+this.programa;
    				parameters += '&acronimo='+this.acronimo;
    				parameters += '&secretaria='+this.secretaria;
    				parameters += '&estado='+this.estado;

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