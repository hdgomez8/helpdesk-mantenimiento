var tabla;
var usu_id = $("#user_idx").val();
var rol_id = $("#rol_idx").val();

function init() {
  $("#ticket_form").on("submit", function (e) {
    guardar(e);
  });
}

$(document).ready(function () {
  // Realizar funcion
  var datosAdicionales = { usu_id: usu_id };

  if (rol_id == 1) {
  } else if (rol_id == 2) {
    listardatatablehelper(
      "#ticket_data",
      "op=listar_x_usu_est_pend_cierr_cliente_general",
      0,
      "desc",
      datosAdicionales
    );
  } else if (rol_id == 3) {
  } else if (rol_id == 4) {
    listardatatablehelper(
      "#ticket_data",
      "op=listar_x_usu_est_pend_cierr_cliente",
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
    dir_proyecto + "view/DetalleTicket-Cierre-Cliente/?ID=" +
    tick_id;
}

/* TODO: Mostrar datos antes de asignar */
function asignar(tick_id) {
  $.post(
    "../../controller/ticket.php?op=mostrar",
    { tick_id: tick_id },
    function (data) {
      data = JSON.parse(data);
      $("#tick_id").val(data.tick_id);
      $("#mdltitulo").html("Asignar Responsable");
      $("#modalasignar").modal("show");
    }
  );
}

init();
