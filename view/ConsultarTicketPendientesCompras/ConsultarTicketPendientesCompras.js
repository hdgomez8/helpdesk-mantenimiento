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
  listardatatablehelper("#ticket_data", "op=listar_x_compra_materiales", 0, "desc", datosAdicionales);
  // Llamar directamente a cambiarColorFilas sin esperar
  // Espera a que se complete la carga de la tabla antes de llamar a cambiarColorFilas
  $('#ticket_data').on('draw.dt', function () {
    cambiarColorFilas();
  });

});

/* TODO: Link para poder ver el detalle de ticket en otra ventana */
function ver(tick_id) {
  var dir_proyecto = document.getElementById("dir_proyecto").value;
  window.location.href = (dir_proyecto + "view/DetalleTicket-Pendiente-Materiales/?ID=" + tick_id);
}

function cambiarColorFilas() {
  // Obtener la instancia de la tabla
  tabla = $("#ticket_data").DataTable();

  // Cambiar el color de las filas según el valor de la columna "tick_estado"
  tabla.rows().every(function () {
    var data = this.data();
    var row = this.node();
    var color;

    switch (data[3]) {
      case 'No Cumple Compras':
        color = '#ffcc50'; // Naranja
        break;
      case 'Gestionado - Compras':
        color = '#d8f8e1'; // Naranja
        break;
      default:
        color = ''; // Puedes establecer un color predeterminado o dejarlo en blanco
    }
    $(row).css('background-color', color);
  });
}


init();
