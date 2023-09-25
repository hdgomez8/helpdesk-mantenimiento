var tabla;
var usu_id = $("#user_idx").val();
var rol_id = $("#rol_idx").val();

function init() {
  $("#ticket_form").on("submit", function (e) {
    guardar(e);
  });
}

$(document).ready(function () {
  var datosAdicionales = { "usu_id": usu_id };
  listardatatablehelper("#ticket_data", "op=listar_x_compra_materiales_en_compras",0,"desc",datosAdicionales);
});

/* TODO: Link para poder ver el detalle de ticket en otra ventana */
function ver(tick_id) {
  var dir_proyecto = document.getElementById("dir_proyecto").value;
  window.location.href =(dir_proyecto + "view/DetalleTicket-Pendiente-Materiales/?ID=" + tick_id);
}

init();
