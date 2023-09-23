var tabla;
var usu_id = $("#user_idx").val();
var rol_id = $("#rol_idx").val();

function init() {
  $("#ticket_form").on("submit", function (e) {
    guardar(e);
  });
}

$(document).ready(function () {

  var datosAdicionales = { "usu_asig": usu_id };
  listardatatablehelper("#ticket_data", "op=listar_x_responsable",0,"desc",datosAdicionales);
});

/* TODO: Link para poder ver el detalle de ticket en otra ventana */
function ver(tick_id) {
  window.location.href =('http://192.168.1.194:8080/helpdesk/view/DetalleTicket-Pendientes/?ID=' + tick_id);
}

init();
