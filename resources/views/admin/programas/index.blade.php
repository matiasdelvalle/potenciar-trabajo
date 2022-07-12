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
        <h4 class="panel-title">Listado de Programas</h4>
    </div>
    <a @click="$root.create()" class="btn btn-default btn-add"><i style="margin-right: 5px" class="fa fa-plus"></i>Agregar programa</a>
    <div class="panel-body">
        <div class="row">
			<div class="col-md-12">
				<div class="btn-group pull-left"  v-for="filter in filters">
					<span @click="$root.remove_filters(filter.name)" class="btn_filter" title="Click para quitar este filtro" class="label label-success">
						<i class="fa fa-remove" aria-hidden="true"></i><a>@{{ $root.elegantName( filter.key ) + ': ' + filter.value }}</a>
					</span>
				</div>
			</div>
		</div>
        <div class="table-responsive">
            <table class="table nomargin">
                <thead>
                    <tr>
                        <th>
                        <span class="header-table-text">PROGRAMAS</span>
                            <select name="" id="programa" class="select2" style="width:100%">
                                <option value="">PROGRAMAS</option>
                                <option v-for="p in programas" :value="p.programa_id">@{{ p.nombre }}</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">ACRÓNIMO</span>
                            <select name="" id="acronimo" class="select2" style="width:100%">
                                <option value="">ACRÓNIMO</option>
                                <option v-for="a in programas" :value="a.programa_id">@{{ a.acronimo }}</option>
                            </select>
                        </th>
                        <th>
                        <span class="header-table-text">SECRETARIAS</span>
                            <select name="" id="secretaria" class="select2" style="width:100%">
                                <option value="">SECRETARIAS</option>
                                <option v-for="s in secretarias" :value="s.secretaria_id">@{{ s.nombre }}</option>
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
                    <tr v-for="item in data.data"  @can('editar_programas') @click="$root.show(item.programa_id)" @endcan>
                        <td>@{{ item.nombre }}</td>
                        <td>@{{ item.acronimo }}</td>
                        <td>@{{ item.secretaria ? item.secretaria.nombre : '' }}</td>
                        <td>@{{ item.estado ? item.estado.descripcion : '' }}</td>
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
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script src="{{ asset('/admin_style/assets/vue/vue') }}"></script>
<script>
  	let App = Vue.createApp({
    	data() {
      		return {
      			url:'{{ url("api/v1/programas") }}',
      			page: 1,
      			reload: 1000 * 60 * 2,
        		data:[],
                programas: {!! $programas !!},
                secretarias: {!! $secretarias !!},
                estados: {!! $estados !!},
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
                // self.initEstado();
    			this.myTimeout = setTimeout(function(){
	    			// this.ajax()
                    this.getStorage();
    			}.bind(this), 100);
    		},
            setStorageFilter: function(key, value){
                if (typeof(Storage) !== "undefined") {
                    localStorage.setItem(key, JSON.stringify(value) );
                }
            },
            getStorage: function(){
                if (typeof(Storage) !== "undefined") {
                    var s = JSON.parse( localStorage.getItem( 'acreditaciones-programas-pages' ) );
                    if(s && s.id != ''){
                        this.page = s.value;
                    }
                }
                var s = JSON.parse( localStorage.getItem( 'acreditaciones-programas-programa' ) );
                if(s && s.id != ''){
                    this.filters.push({ key: s.key, v: s.id, value: s.value, name: s.name });
                    this.programa = s.id;
                    this.programa_text = s.value;
                }
                var s = JSON.parse( localStorage.getItem( 'acreditaciones-programas-secretaria' ) );
                if(s && s.id != ''){
                    this.filters.push({ key: s.key, v: s.id, value: s.value, name: s.name });
                    this.secretaria = s.id;
                    this.secretaria_text = s.value;
                }
                var s = JSON.parse( localStorage.getItem( 'acreditaciones-programas-acronimo' ) );
                if(s && s.id != ''){
                    this.filters.push({ key: s.key, v: s.id, value: s.value, name: s.name });
                    this.acronimo = s.id;
                    this.acronimo_text = s.value;
                }                
                var s = JSON.parse( localStorage.getItem( 'acreditaciones-programas-estado' ) );
                if(s && s.id != ''){
                    this.filters.push({ key: s.key, v: s.id, value: s.value, name: s.name });
                    this.estado = s.id;
                    this.estado_text = s.value;
                }                                
                this.update_filters();
            },
            getStorageFilter: function(key){
                if (typeof(Storage) !== "undefined") {
                    return localStorage.getItem(key);
                }else{
                    return '';
                }
            },
            removeStorageFilter: function(key){
                if (typeof(Storage) !== "undefined") {
                    localStorage.removeItem(key);
                }
            },
            filter: function(element){

                this.page = 1;
                this.setStorageFilter('acreditaciones-programas-pages', { key: 'pages', value: 1, id: 1, name: 'pages' } );

                if(element.id == 'programa'){
                    this.programa 		= element.value;
                    this.programa_text 	= $(element).find("option:selected").text();
                    this.setStorageFilter('acreditaciones-programas-programa', { key: 'programa', value: this.programa_text, id: this.programa, name: 'programa' } );
                }
                if(element.id == 'secretaria'){
                    this.secretaria 		= element.value;
                    this.secretaria_text 	= $(element).find("option:selected").text();
                    this.setStorageFilter('acreditaciones-programas-secretaria', { key: 'secretaria', value: this.secretaria_text, id: this.secretaria, name: 'secretaria' } );
                }                
                if(element.id == 'acronimo'){
                    this.acronimo 		= element.value;
                    this.acronimo_text 	= $(element).find("option:selected").text();
                    this.setStorageFilter('acreditaciones-programas-acronimo', { key: 'acronimo', value: this.acronimo_text, id: this.acronimo, name: 'acronimo' } );
                }                                
                if(element.id == 'estado'){
                    this.estado 		= element.value;
					this.estado_text 	= $(element).find("option:selected").text();
                    this.setStorageFilter('acreditaciones-programas-estado', { key: 'estado', value: this.estado_text, id: this.estado, name: 'estado' } );
				}
				this.update_filters();
			},                       
            update_filters: function(){
                this.filters = [];
				if(this.programa  	!= '') this.filters.push({ key: 'programa', 	v: this.programa,   value: this.programa_text, 		name: 'programa'    });
				if(this.acronimo  	!= '') this.filters.push({ key: 'acronimo', 	v: this.acronimo,   value: this.acronimo_text, 		name: 'acronimo'    });
				if(this.secretaria  != '') this.filters.push({ key: 'secretaria', 	v: this.secretaria, value: this.secretaria_text, 	name: 'secretaria'  });
				if(this.estado  	!= '') this.filters.push({ key: 'estado', 		v: this.estado,     value: this.estado_text, 	    name: 'estado'      });
				this.ajax();                
			},
			remove_filters: function(name){
				if(name == 'programa'){     this.programa 	= ''; 	this.programa_text      = ''; this.removeStorageFilter('acreditaciones-programas-programa');    }
				if(name == 'acronimo'){     this.acronimo 	= ''; 	this.acronimo_text      = ''; this.removeStorageFilter('acreditaciones-programas-acronimo');    }
                if(name == 'secretaria'){   this.secretaria = ''; 	this.secretaria_text    = ''; this.removeStorageFilter('acreditaciones-programas-secretaria');  }                
                if(name == 'estado'){       this.estado     = ''; 	this.estado_text        = ''; this.removeStorageFilter('acreditaciones-programas-estado');      }                
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
    		goTo: function(page){
    			this.page = page;
                self.setStorageFilter('acreditaciones-programas-pages', { key: 'pages', value: page,  name: 'pages' } );
    			this.ajax();
    		},  
            create: function(){
				window.location = document.URL+'/create';	
			},                      
            show: function(id, event){
                window.location = document.URL+'/'+id;
            },
            elegantName: function(string){
                var elegantKey = [];
                elegantKey['programa'] 		= 'Programa';
                elegantKey['acronimo'] 		= 'Acronimo';
                elegantKey['secretaria'] 	= 'Secretarias';
                elegantKey['estado'] 		= 'Estado';
                return elegantKey[string];
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
  	});
  	App.mount('#app');
</script>
@endsection