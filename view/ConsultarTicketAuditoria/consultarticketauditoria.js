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
  
  if(usu_id==553 || usu_id==662){
    listardatatablehelper(
      "#ticket_data",
      "op=listar_auditoria",
      0,
      "desc",
      datosAdicionales
    );
  }

});

/* TODO: Link para poder ver el detalle de ticket en otra ventana */
function ver(tick_id) {
  var dir_proyecto = document.getElementById("dir_proyecto").value;
  window.location.href =
  dir_proyecto + "view/DetalleTicket/?ID=" + tick_id;
}

init();
