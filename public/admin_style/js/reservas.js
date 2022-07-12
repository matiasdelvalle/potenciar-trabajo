var ToggleEstadoReservas = function(elem, obj){
	$.ajax({
      url: url + '/../toogle',
      type: "post",
      data: obj,
      success: function(data){
        toastr.success('Reserva Actualizada');
        location.reload();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error('Error en la actualización');
      }
    });
}

var selected = [];
$('.checkbox.selectall').iCheck({ checkboxClass: 'icheckbox_minimal-aero', increaseArea: '10%' });
$('input[type="checkbox"].selectall').on('ifChecked', function(event) {
   $(this).closest("table").find(".printcode").iCheck('check');
}).on('ifUnchecked', function(event) {
  $(this).closest("table").find(".printcode").iCheck('uncheck');
});

function imprimir(){
  var cantidad = 0;
  if (selected.length > 0) cantidad = selected.join().split(",").length;
  if (cantidad>0) {
    swal({   title: "Imprimir solicitud",   text: "Usted está por imprimir la solicitud de "+cantidad+" pasajes",   type: "info",   showCancelButton: true,   confirmButtonColor: "#51b856", confirmButtonText: "Confirmar", cancelButtonText: "Anular",  closeOnConfirm: true }, function(){
      params = "?tickets="+selected.join();
      window.open(url + "/../print" + params,"__historial_popup__",'toolbar=no,directories=no,menubar=no,location=no,scrollbars=yes,status=no,resizable=no,height=600,width=800,');
    });
  }
  else{
    swal({title: "",text: "<h4>Seleccione al menos un pasaje para imprimir</h4>",   html: true, timer: 2500,   showConfirmButton: false });
  }
}

Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

function periodos(periodo){
    window.location.replace(url+periodo);
}
function pedirPasaje(tramo, pasaje_tipo, todos){
  if (todos==1) {
    if (tramo==1) {
      if (pasaje_tipo==1) str = 'tramos Aéreos Nominados';
      if (pasaje_tipo==2) str = 'tramos Aéreos Sin Nominar';
    }
    else {
      str = 'tramos Terrestres';
    }
    swal({   title: "Solicitar todos los "+str,   text: "Se solicitarán todos los "+str+" disponibles para el periodo seleccionado",   type: "info",   showCancelButton: true,   confirmButtonColor: "#51b856", confirmButtonText: "Si, solicitar", cancelButtonText: "No",  closeOnConfirm: true }, function(){
        document.location.href=urlPedirPasajes+'/'+tramo+'/'+pasaje_tipo+'/'+todos+'/'+$('#periodo').find(":selected").val().replace(/[^0-9\.]/g,'');
    });
  }
  else {
    document.location.href=urlPedirPasajes+'/'+tramo+'/'+pasaje_tipo+'/'+todos+'/'+$('#periodo').find(":selected").val().replace(/[^0-9\.]/g,'');
  }
}
var vm = function(){
    self                    = this;
    self.disponibles        = ko.observableArray([]);
    self.reservas_totales   = ko.observableArray([]);
    self.importe            = ko.observableArray([]);
    self.setFilters   = null;
    self.ajax = function(url2){
        $.getJSON(url2).done(function(data){
            selected = [];
            $('#all').iCheck('uncheck');
            Pace.restart()
            vm.disponibles(data.view_disponibles);
            vm.reservas_totales(data.reservas_totales);
            vm.importe(data.importe);
        });
    };
    self.next = function(){
        self.ajax(vm.disponibles().next_page_url + '&' + self.setFilters);
    };
    self.prev = function(){
        self.ajax(vm.disponibles().prev_page_url + '&' + self.setFilters);
    };
    self.ir = function(page){
          self.ajax(disponibles +'?page='+page+'&'+self.setFilters);
        };
    self.filter = function(tipo, valor, elem){
        $('.filterButton i').removeClass('lightblue');
        $(elem).find('i').addClass('lightblue');
        self.setFilters = tipo+'='+valor
        self.ajax( disponibles +'?'+ self.setFilters);
    }
    self.CancelarReserva = function(tramo, tipo, periodo){
      $.getJSON(remove+'/'+tramo+'/'+tipo+'/'+periodo).done(function(){
        toastr.success('Anulado');
        self.ajax( disponibles +'?'+ self.setFilters);
        document.location.href=document.location.href;
      })
    }
    self.export = function(obj){
      var url = obj.url + '?format=' + obj.tipo + '&'+self.setFilters;
      window.location.href = url;
    };
    self.solicitarInnominado = function(pasaje_id, user_id, element){
      $.ajax({
        url: urlSolicitarInnominado,
          method: "POST",
          data: {
            pasaje_id: pasaje_id,
            user_id: user_id
          },
          datatype: 'JSON'
      }).done(function(d){
        toastr.success('Pedido realizado');
        self.ajax( disponibles +'?'+ self.setFilters);
      }).fail(function(data){
        var errors = data.responseJSON;
        toastr.error(errors);
      });
    }
    self.solicitarRecategorizacion = function(pasaje_id, user_id, element){
      $.ajax({
        url: urlSolicitarRecategorizacion,
          method: "POST",
          data: {
            pasaje_id: pasaje_id,
            user_id: user_id
          },
          datatype: 'JSON'
      }).done(function(d){
        toastr.success('Pedido realizado');
        self.ajax( disponibles +'?'+ self.setFilters);
      }).fail(function(data){
        var errors = data.responseJSON;
        console.log(errors);
        toastr.error(errors);
      });
    }
};

ko.bindingHandlers.RadioButton = {
    init: function (element, valueAccessor) {
        $(element).iCheck({
            checkboxClass: 'icheckbox_minimal-aero',
            increaseArea: '10%'
        });
        $(element).on('ifChecked', function(event) {
          selected.push( valueAccessor() );
        }).on('ifUnchecked', function(event) {
          selected.remove( valueAccessor() );
        });
    },
};
$('#all').on('ifChanged',function(){
    $('#all').on('ifChecked', function(event) {
    }).on('ifUnchecked', function(event) {
      selected = [];
    });
});
$('#canje').click(function(){
  $.getJSON(canjesanteriores + '?periodo='+$('#periodo').find(":selected").val().replace(/[^0-9\.]/g,'')).done(function(d){
    valor_canje = $('#valor_canje').text();
    if(valor_canje != ''){

        var text  = "<h4>Usted está por solicitar el canje de pasajes por el valor de</h4>";
            text += "<h2><b>"+valor_canje+"</b></h2>";

            if(d.length > 0){
              text += "<p>Ud. tiene pasajes anteriores que puede canjear</p>";
              text += '<div style="height:100px;overflow-y:scroll">';
              text += '<table class="table">';
              text += '<thead>';
              text += '<tr><th class="text-center" style="padding:0px">Periodo</th><th class="text-center" style="padding:0px">Importe</th></tr>';
              for(var i = 0, len = d.length; i<len;i++){
                text += '<tr><td style="padding:0px">'+d[i].año + ' ' + d[i].mes_nombre + '</td><td style="padding:0px">$ ' + d[i].importe + '</td></tr>';
              }
              text += '</table>';
              text += '</div>';
            }

            text += '<hr>';
            text += "<span style='color:red; font-weight: bold;'>Una vez realizado el pedido no podrá disponer de los pasajes canjeados por dinero</span>";

          swal({   title: "Solicitar canje de pasajes",  html: true, text: text,  showCancelButton: true,   confirmButtonColor: "#51b856", confirmButtonText: "Confirmar canje", cancelButtonText: "Cancelar",  showLoaderOnConfirm: true, closeOnConfirm: false }, function(){
            swal({   title: "",   text: "<h3 style='color:red'>Procesando la solicitud de Canje de Pasajes<br><br>Espere un momento...</h3>",   html: true, showConfirmButton: false, closeOnCancel: false, allowOutsideClick: false });
            $.ajax({
              url: url + '/../canjear',
              type: "get",
              data: {
                periodo: $('#periodo').find(":selected").val().replace(/[^0-9\.]/g,'')
              },
              success: function(data){
                toastr.success('Canje de pasajes solicitados');
                setTimeout(
                  function() {
                    swal({   title: "",   text: "<h3 style='color:green'>Solicitud de Canje de Pasajes<br><br>ENVIADA</h3>",   html: true, timer: 3000, showConfirmButton: false });
                    setTimeout(function() { location.reload(); }, 3000);
                  }
                , 200);
              },
              error: function (xhr, ajaxOptions, thrownError) {
                toastr.error('Error en el canje de pasajes');
                swal.close();
              }
             });
        });
    }
  });
});

$(function(){
  vm = new vm();
  if ($('#periodo').find(":selected").val() != null)
  {
    vm.ajax(disponibles + '?periodo='+$('#periodo').find(":selected").val().replace(/[^0-9\.]/g,'') );
  }
  else
    vm.ajax(disponibles + '?periodo=');
  {

  }
  ko.applyBindings(vm, document.getElementById("tab_confirmadas"));

  if(!detectmob()){
	  // toggleMenu(-220,0);
  }

})


function number_format(number, decimals, decPoint, thousandsSep){
  decimals = decimals || 0;
  number = parseFloat(number);

  if(!decPoint || !thousandsSep){
    decPoint = '.';
    thousandsSep = ',';
  }

  var roundedNumber = Math.round( Math.abs( number ) * ('1e' + decimals) ) + '';
  var numbersString = decimals ? roundedNumber.slice(0, decimals * -1) : roundedNumber;
  var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
  var formattedNumber = "";

  while(numbersString.length > 3){
    formattedNumber += thousandsSep + numbersString.slice(-3)
    numbersString = numbersString.slice(0,-3);
  }

  return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
}

//english format
// number_format( 1234.50, 2, '.', ',' ); // ~> "1,234.50"
