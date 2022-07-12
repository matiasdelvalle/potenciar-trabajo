@extends('admin.layout.app')
@section('title', 'Usuarios Online')
@section('css')
<link href="{{ asset('admin_style/assets/toastr/toastr.min.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('admin_style/assets/select2/select2.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('admin_style/assets/bootstrap-datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
<div class="panel" id="ko">
	<div class="panel-heading">
		<h4 class="panel-title text-success">Usuarios Online</h4>
	</div>
	<div class="panel-body nopadding">
		<div class="col-md-12 table-responsive">
			<table class="table table-hover table-striped nomargin">
				<thead>
					<tr>
						<th class="col_1">USUARIO</th>
						<th class="col_1">E-MAIL</th>
						<th class="col_1">URL</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: data()">
					<tr>
						<td class="col_1 text-left">
							<a href="javascript:void(0)" data-bind="text: self.setNames(name), click:function(){ $root.link($data) }"></a>
						</td>
						<td class="col_1 text-left" data-bind="text: email"></td>
						<td class="col_1 text-left" <a href="" data-bind="text:url, attr:{href:url}"></a>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">
							Usuarios Online <span data-bind="text: data().length"></span>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="col-md-12 table-responsive" style="height:400px;overflow-y:scroll;margin-top:50px">
			<h3>Auditoria</h3>
			<table class="table table-hover table-striped nomargin">
				<thead>
					<tr>
						<th class="col_1">FECHA</th>
						<th class="col_1">ACCION</th>
						<th class="col_1">TABLA</th>
						<th class="col_1">ID</th>
						<th class="col_1" style="width:200px">registro</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: data3().data">
					<tr>
						<td class="col_1 text-left" data-bind="text: fecha_hora"></td>
						<td class="col_1 text-left" data-bind="text: accion"></td>
						<td class="col_1 text-left" data-bind="text: tabla"></td>
						<td class="col_1 text-left" data-bind="text: tabla_id"></td>
						<td class="col_1 text-left" data-bind="text: registro"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="col-md-12 table-responsive" style="height:400px;overflow:scroll;margin-top:50px">
			<h3>Errors</h3>
			<table class="table table-hover table-striped nomargin">
				<thead>
					<tr>
						<th class="col_1">FECHA</th>
						<th class="col_1">ERROR</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: data2()">
					<tr>
						<td class="col_1 text-left" data-bind="text: fecha"></td>
						<td class="col_1 text-left" data-bind="text: first"></td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>
@endsection

@section('js')
<script src='{{ asset("admin_style/assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("admin_style/assets/sweetalert/sweet-alert.min.js") }}'></script>
<script src="{{ asset('admin_style/assets/select2/select2.full.js') }}"></script>
<script src="{{ asset('admin_style/assets/moment/moment-with-locales.min.js')}}"></script>
<script src="{{ asset('admin_style/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('admin_style/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
<script src='{{asset("/admin_style/assets/knockout/knockout-3.4.0.js") }}'></script>
<script>
	moment.locale('es');
	var time = 10 * 1000;
	var url = "{{ url('api/v1/online/usuarios') }}";
	var url2 = "{{ url('api/v1/online/logs') }}";
	var url3 = "{{ url('api/v1/online/autoditoria') }}";
	var vm = function () {
		self = this;
		self.data = ko.observableArray([]);
		self.data2 = ko.observableArray([]);
		self.data3 = ko.observableArray([]);
		self.usuario = '';
		self.usuario_text = '';
		self.mail = '';
		self.mail_text = '';
		self.perfil = '';
		self.perfil_text = '';
		self.page = '1';
		self.filters = ko.observableArray([]);
		self.init = function () {
			myTimeout = setTimeout("self.ajax()", 1000);
			myTimeout2 = setTimeout("self.ajax2()", 1000);
			myTimeout2 = setTimeout("self.ajax3()", 1000);
			$('.select2').select2();
			$('#datepicker').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true
			}).on('changeDate', function (ev) {
				vm.fechas(null, null, ev.date);
			});
		}
		self.link = function(obj){
			window.location.href = '{{ url('/admin/usuarios') }}' + '/' + obj.id + '/edit';
		}
		self.setNames = function (fname, lname) {
			apellido = '';
			nombre = '';
			if (fname != null) {
				nombre = fname;
			}
			if (lname != null) {
				apellido = lname;
			}
			return apellido + ' ' + nombre;
		}
		self.fechas = function (id, tipo, f) {
			self.page = 1;
			var d = new Date(f);
			self.fecha = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ("0" + d.getDate())
				.slice(-2);;
			self.fecha_text = ("0" + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + d
				.getFullYear();
			self.ajax();
			self.update_filters();
		}
		self.DateFormat = function (element, format) {
			return moment(element).format(format);
		};
		self.filterUsuario = function (element) {
			self.page = 1;
			self.usuario = $(element).val()
			self.usuario_text = $(element).find("option:selected").text();
			self.update_filters();
			self.ajax();
		};
		self.filterMail = function (element) {
			self.page = 1;
			self.mail = $(element).val()
			self.mail_text = $(element).find("option:selected").text();
			self.update_filters();
			self.ajax();
		};
		self.filterPerfil = function (element) {
			self.page = 1;
			self.perfil = $(element).val()
			self.perfil_text = $(element).find("option:selected").text();
			self.update_filters();
			self.ajax();
		};
		self.update_filters = function () {
			self.filters([]);
			if (self.usuario != '') self.filters.push({
				key: 'usuario',
				value: self.usuario_text,
				name: 'usuario'
			});
			if (self.mail != '') self.filters.push({
				key: 'mail',
				value: self.mail_text,
				name: 'mail'
			});
			if (self.perfil != '') self.filters.push({
				key: 'perfil',
				value: self.perfil_text,
				name: 'perfil'
			});
		};
		self.remove_filters = function (name) {
			if (name == 'usuario') {
				self.usuario = '';
				self.usuario_text = '';
			}
			if (name == 'mail') {
				self.mail = '';
				self.mail_text = '';
			}
			$('#' + name).val("").trigger("change");
			self.update_filters();
			self.ajax();
		};
		self.ir = function (page) {
			self.page = page;
			self.ajax();
			$('html, body').animate({
				scrollTop: 0
			}, 'fast');
		};
		self.editar = function (obj) {
			if (obj.id) {
				window.location.href = window.location.href + '/' + obj.id + '/edit';
			} else {
				toastr.error('la Comisión no esta definida');
			}
		}
		self.ajax = function () {
			$.getJSON(url, {
					page: self.page,
					usuario: self.usuario,
					mail: self.mail,
					perfil: self.perfil,
					api_token: '{{ Auth::user()->api_token }}'
				})
				.done(function (data) {
					// Pace.restart()
					vm.data(data);
					$("#data").fadeIn();
					$(".loading").remove();
				})
				.error(function (d) {
					toastr.error('Se encontro un error intente nuevamente');
				})
				.always(function () {
					clearInterval(myTimeout);
					myTimeout = setTimeout("self.ajax()", time);
				});
		};
		self.ajax2 = function () {
			$.getJSON(url2, {
					api_token: '{{ Auth::user()->api_token }}'
				})
				.done(function (data) {
					// Pace.restart()
					vm.data2(data);
				})
				.error(function (d) {
					toastr.error('Se encontro un error intente nuevamente');
				})
				.always(function () {
					clearInterval(myTimeout2);
					myTimeout2 = setTimeout("self.ajax2()", time);
				});
		};
		self.ajax3 = function () {
			$.getJSON(url3, {
					api_token: '{{ Auth::user()->api_token }}'
				})
				.done(function (data) {
					// Pace.restart()
					vm.data3(data);
				})
				.error(function (d) {
					toastr.error('Se encontro un error intente nuevamente');
				})
				.always(function () {
					clearInterval(myTimeout2);
					myTimeout2 = setTimeout("self.ajax3()", time);
				});
		};		
	};
	vm = new vm();
	vm.init();
	ko.applyBindings(vm, document.getElementById("ko"));
</script>
@endsection