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
  if (rol_id == 1) {

  } else if (rol_id == 2) {
    listardatatablehelper(
      "#ticket_data",
      "op=listar_x_responsable_pendiente_tecnicos",
      0,
      "desc",
      datosAdicionales = { "usu_asig": usu_id }
    );
  } else if (rol_id == 3) {
    listardatatablehelper(
      "#ticket_data",
      "op=listar_x_responsable",
      0,
      "desc",
      datosAdicionales = { "usu_asig": usu_id }
    );
  }

});

/* TODO: Link para poder ver el detalle de ticket en otra ventana */
function ver(tick_id) {
  var dir_proyecto = document.getElementById("dir_proyecto").value;
  window.location.href = (dir_proyecto + "view/DetalleTicket-Pendientes/?ID=" + tick_id);
}

init();
