var tabla;
var usu_id = $("#user_idx").val();
var rol_id = $("#rol_idx").val();

function init() {
  $("#ticket_form").on("submit", function (e) {
    guardar(e);
  });
}

$(document).ready(function () {

  /* TODO: rol si es 2 entonces es Admin */
  var datosAdicionales = { "usu_id": usu_id };
  listardatatablehelper("#ticket_data", "op=listar_filtro",0,"desc",datosAdicionales);
});

/* TODO: Link para poder ver el detalle de ticket en otra ventana */
function ver(tick_id) {
  var dir_proyecto = document.getElementById("dir_proyecto").value;
  window.location.href = dir_proyecto + "view/DetalleTicket-Gestionar/?ID=" + tick_id ;
  // window.open('http://192.168.1.194:8080/helpdesk/view/DetalleTicket-Gestionar/?ID' + tick_id);
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
      var tick_id = $("#tick_id").val();
      /* TODO: enviar Email de alerta de asignacion */
      $.post(
        "../../controller/email.php?op=ticket_asignado",
        { tick_id: tick_id },
        function (data) {}
      );

      /* TODO: enviar Whaspp de alerta de asignacion */
      $.post(
        "../../controller/whatsapp.php?op=w_ticket_asignado",
        { tick_id: tick_id },
        function (data) {}
      );

      /* TODO: Alerta de confirmacion */
      swal("Asignado Exitosamente", "", "success");

      /* TODO: Ocultar Modal */
      $("#modalasignar").modal("hide");
      /* TODO:Recargar Datatable JS */
      $("#ticket_data").DataTable().ajax.reload();
    },
  });
}

/* TODO:Reabrir ticket */
function CambiarEstado(tick_id) {
  swal(
    {
      title: "HelpDesk",
      text: "Esta seguro de Reabrir el Ticket?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-warning",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        /* TODO: Enviar actualizacion de estado */
        $.post(
          "../../controller/ticket.php?op=reabrir",
          { tick_id: tick_id, usu_id: usu_id },
          function (data) {}
        );

        /* TODO:Recargar datatable js */
        $("#ticket_data").DataTable().ajax.reload();

        /* TODO: Mensaje de Confirmacion */
        swal({
          title: "HelpDesk!",
          text: "Ticket Abierto.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    }
  );
}

/* TODO:Filtro avanzado */
$(document).on("click", "#btnfiltrar", function () {
  limpiar();

  var tick_titulo = $("#tick_titulo").val();
  var prio_id = $("#prio_id").val();

  listardatatable(tick_titulo, prio_id);
});

/* TODO: Restaurar Datatable js y limpiar */
$(document).on("click", "#btntodo", function () {
  limpiar();

  $("#tick_titulo").val("");
  $("#prio_id").val("").trigger("change");

  listardatatable("", "", "");
});

/* TODO: Listar datatable con filtro avanzado */// function listardatatable(){
function listardatatable(tick_titulo) {
  tabla = $("#ticket_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      searching: true,
      lengthChange: false,
      colReorder: true,
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
      ajax: {
        url: "../../controller/ticket.php?op=listar_filtro",
        type: "post",
        dataType: "json",
        data: { tick_titulo: tick_titulo},
        error: function (e) {
          console.log(this.data);
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10,
      autoWidth: false,
      order: [[0, "desc"]],
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      },
    })
    .DataTable()
    .ajax.reload();
}


init();
