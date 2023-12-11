var tabla;
var usu_id = $("#user_idx").val();
var rol_id = $("#rol_idx").val();

function init() {
  $("#ticket_form").on("submit", function (e) {
    guardar(e);
  });
}

$(document).ready(function () {

  /* TODO:LLenar Combo usuario asignar */
  $.post("../../controller/usuario.php?op=combo", function (data) {
    $('#usu_asig').html(data);
  });

  var datosAdicionales = { "usu_id": usu_id };


  if (rol_id == 1) {

  } else if (rol_id == 2) {
    listardatatablehelper(
      "#ticket_data",
      "op=listar",
      0,
      "desc",
      datosAdicionales
    );
  } else if (rol_id == 3) {
    listardatatablehelper(
      "#ticket_data",
      "op=listar_x_responsable_tecnico_consultar",
      0,
      "desc",
      datosAdicionales = { "usu_asig": usu_id }
    );
  } else if (rol_id == 4) {
    listardatatablehelper(
      "#ticket_data",
      "op=listar_x_usu",
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

/* TODO: Mostrar datos antes de asignar */
function asignar(tick_id) {
  $.post("../../controller/ticket.php?op=mostrar", { tick_id: tick_id }, function (data) {
    if (typeof data === 'string' && data.trim() !== '') {
      data = JSON.parse(data);
      $('#tick_id').val(data.tick_id);

      $('#mdltitulo').html('Asignar Agente');
      $("#modalasignar").modal('show');
    } else {
      console.error('La respuesta del servidor no es válida.');
    }
  })
    .fail(function (xhr, status, error) {
      console.error('Error en la solicitud AJAX:', error);
    });
}

/* TODO: Guardar asignacion de usuario de soporte */
function guardar(e) {
  e.preventDefault();
  var formData = new FormData($("#ticket_form")[0]);
  $.ajax({
    url: "../../controller/ticket.php?op=asignar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      var tick_id = $('#tick_id').val();
      /* TODO: enviar Email de alerta de asignacion */
      $.post("../../controller/email.php?op=ticket_asignado", { tick_id: tick_id }, function (data) {
      });

      swal(
        {
          title: "Correcto!",
          text: "Asignado Exitosamente",
          icon: "success",
        },
        function (result) {
          console.log(result); // Imprimir el resultado en la consola
          if (result) {
            $("#modalasignar").modal('hide');
            var dir_proyecto = document.getElementById("dir_proyecto").value;
            window.location.href =
              dir_proyecto + "view/ConsultarTicket/";
          }
        }
      );

    }
  });
}

init();
