@extends('admin.layout.app')

@section('css')

@endsection

@section('content')

<link href="{{ asset('/admin_style/assets/toastr/toastr.min.css') }}" 						type="text/css" 	rel="stylesheet">
<link href="{{ asset('/admin_style/assets/select2/select2.css') }}" 						type="text/css" 	rel="stylesheet">
<link href="{{ asset('/admin_style/assets/bootstrap-datepicker/css/datepicker.css') }}"   	type="text/css"     rel="stylesheet">
<link href="{{ asset('admin_style/assets/jquery-raty/lib/jquery.raty.css') }}" 				type="text/css"     rel="stylesheet">
<link href="{{ asset('admin_style/assets/jquery-raty/lib/jquery.raty.css') }}" 				type="text/css"     rel="stylesheet">
<link href="{{ asset('/admin_style/css/quirk.css') }}" type="text/css"  rel="stylesheet">
<style>
    th>select {
        border: none;
        background: inherit;
        outline: none;
    }
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
<div class="panel" id="app">
    <div class="estadisticas-container">
        <h4 class="panel-title">Estadísticas de entidades cargadas</h4>
        <div class="estados-container">
            <div class="estados-card2" v-for="item in data" :class="'borde-'+item.Classname">
                <div style="text-align:left">
                    <h3>@{{ item.descripcion }}</h3>
                    <div class="underline-estadisticas"></div>
                    <span>@{{ item.entidades_count }}</span>
                </div>
                <div style="text-align:right">
                    <i class="fa-solid" :class="item.icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tabla-estadisticas" class="panel hide">
    <div class="header-tabla-estadisticas">
     <h4 class="panel-title mb-4 p-3">Datos adicionales de Abogados</h4>
     <a @click="$root.export({ url: '{{ url('xls/estadisticas')}}', 'tipo': 'xls' })" class="btn btn-default btn-add">Descargar Excel</i></a>	
    </div>
    <div class="table-responsive">
        <table class="table nomargin">
            <thead>
                <tr>
                    <th>
                    <span class="header-table-text">FECHA CARGA</span>
                        <select name="" id="" class="select2" style="width:100%">
                            <option value="">FECHA CARGA</option>
                            <option v-for="" :value="">20/06/2021</option>
                        </select>
                    </th>
                    <th>
                    <span class="header-table-text">ULT. MODIFICACION</span>
                        <select name="" id="" class="select2" style="width:100%">
                            <option value="">ULT. MODIFICACION</option>
                            <option v-for="" :value="">AYER</option>
                        </select>
                    </th>
                    <th>
                    <span class="header-table-text">ESTADO</span>
                        <select name="" id="" class="select2" style="width:100%">
                            <option value="">ESTADO</option>
                            <option v-for="" :value="">Pendiente</option>
                        </select>
                    </th>
                    <th>
                    <span class="header-table-text">TIPO CONFORMACION</span>
                        <select name="" id="" class="select2" style="width:100%">
                            <option value="">TIPO CONFORMACION</option>
                            <option v-for="" :value="">Conformado</option>
                        </select>
                    </th>
                    <th>
                    <span class="header-table-text">FORMAS JURÍDICAS</span>
                        <select name="" id="" class="select2" style="width:100%">
                            <option value="">FORMAS JURÍDICAS</option>
                            <option v-for="" :value="">Sociedad Civil</option>
                        </select>
                    </th>
                    <th>
                    <span class="header-table-text">PROVINCIA</span>
                        <select name="entidad_estado" id="" class="select2" style="width:100%">
                            <option value="">PROVINCIA</option>
                            <option v-for="" :value="">Buenos Aires</option>
                        </select>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data" @click="$root.show(item.entidad_id)">
                    <td>20/06/2021</td>
                    <td>20/07/2021</td>
                    <td>Pendiente</td>
                    <td>Conformado</td>
                    <td>Sociedad Civil</td>
                    <td>Buenos Aires</td>
                </tr>
            </tbody>
        </table>
    </div>



    
</div>
</div>
@endsection


@section('js')
<script src="{{ asset('/admin_style/assets/moment/moment-with-locales.min.js')}}"></script>
<script src="{{ asset('/admin_style/assets/vue/vue') }}"></script>
<script src="{{ asset('/admin_style/assets/select2/select2.full.js') }}"></script>
<script>
    let App = Vue.createApp({
    	data() {
      		return {
                title: 'Direcciones',
      			url:'{{ url("api/v1/estadisticas") }}',
      			page: 1,
      			reload: 1000 * 60 * 2,
        		data:[]
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
    		DateFormat: function(element, format){
   				return moment(element).format(format);
            },
    		async ajax(){
                self = this;
    			let parameters  = '?';
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