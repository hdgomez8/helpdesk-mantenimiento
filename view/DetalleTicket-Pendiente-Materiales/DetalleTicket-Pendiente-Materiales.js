function init() {}

$(document).ready(function () {
  var tick_id = getUrlParameter("ID");

  listardetalle(tick_id);

  /* TODO: Inicializamos summernotejs */
  $("#tickd_descrip").summernote({
    height: 100,
    lang: "es-ES",
    callbacks: {
      onImageUpload: function (image) {
        console.log("Image detect...");
        myimagetreat(image[0]);
      },
      onPaste: function (e) {
        console.log("Text detect...");
      },
    },
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    autoResize: true,
  });

  /* TODO: Inicializamos summernotejs */
  $("#tickd_descripusu").summernote({
    height: 100,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    autoResize: true,
  });

  /* TODO: Inicializamos summernotejs */
  $("#tickd_descrip_diag_mant").summernote({
    height: 100,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    autoResize: true,
  });

  /* TODO: Inicializamos summernotejs */
  $("#tickd_descrip_act_rep_efec").summernote({
    height: 100,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    autoResize: true,
  });

  $("#tickd_descripusu").summernote("disable");
  $("#tickd_descrip_diag_mant").summernote("disable");
  $("#reasignar_ticket").hide();
  $("#enviar_compras").hide();

  /* TODO: Listamos documentos en caso hubieran */
  tabla = $("#documentos_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      searching: true,
      lengthChange: false,
      colReorder: true,
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
      ajax: {
        url: "../../controller/documento.php?op=listar",
        type: "post",
        data: { tick_id: tick_id },
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10,
      autoWidth: false,
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
    .DataTable();


});

var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
    sURLVariables = sPageURL.split("&"),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split("=");

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : sParameterName[1];
    }
  }
};

$(document).on("click", "#btnreasignarticket", function () {
  /* TODO: Preguntamos antes de cerrar el ticket */
  swal(
    {
      title: "HelpDesk",
      text: "Esta seguro de Reasignar el Ticket?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-warning",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        var tick_id = getUrlParameter("ID");
        var campoRequisicion =  $("#campoRequisicion").val();

        /* TODO: Actualizamos el ticket  */
        $.post(
          "../../controller/ticket.php?op=update_x_jefe_reasignar_con_materiales",
          {
            tick_id: tick_id,
            campoRequisicion:campoRequisicion,
          },
          function (data) {}
        );

        /* TODO:Llamamos a funcion listardetalle */
        listardetalle(tick_id);

        /* TODO: Alerta de confirmacion */
        swal({
          title: "Ticket Reasignado!",
          text: "Ticket Reasignado correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        },
        function (result) {
          console.log(result); // Imprimir el resultado en la consola
          if (result) {
            var dir_proyecto = document.getElementById("dir_proyecto").value;
            window.location.href =
            dir_proyecto + "view/ConsultarTicketPendientesCompras/";
          }
        });
      }
    }
  );
});

$(document).on("click", "#btnenviarcompras", function () {
  /* TODO: Preguntamos antes de cerrar el ticket */
  swal(
    {
      title: "HelpDesk",
      text: "Esta seguro de solicitar los materiales a compras?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-warning",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        var tick_id = getUrlParameter("ID");
        var campoOrdenCompra =  $("#campoOrdenCompra").val();

        /* TODO: Actualizamos el ticket  */
        $.post(
          "../../controller/ticket.php?op=update_x_jefe_envio_a_compras",
          {
            tick_id: tick_id,
            campoOrdenCompra:campoOrdenCompra,
          },
          function (data) {}
        );

        /* TODO:Llamamos a funcion listardetalle */
        listardetalle(tick_id);

        /* TODO: Alerta de confirmacion */
        swal({
          title: "Ticket Reasignado!",
          text: "Ticket Reasignado correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        },
        function (result) {
          console.log(result); // Imprimir el resultado en la consola
          if (result) {
            var dir_proyecto = document.getElementById("dir_proyecto").value;
            window.location.href =
            dir_proyecto + "view/ConsultarTicketPendientesCompras/";
          }
        });
      }
    }
  );
});

function listardetalle(tick_id) {
  /* TODO: Mostramos informacion del ticket en inputs */
  $.post(
    "../../controller/ticket.php?op=mostrarpendientes",
    { tick_id: tick_id },
    function (data) {
      data = JSON.parse(data);
      $("#lblnomidticket").html("Detalle Ticket - " + data.tick_id);
      $("#lblestado").html(data.tick_estado);
      $("#tick_titulo").val(data.tick_titulo);
      $("#tick_tipo_mantenimiento").val(data.tip_man_nom);
      $("#tick_sistemas").val(data.sis_nom);
      $("#tick_prioridad").val(data.prio_nom);
      $('#usuario').val(data.usu_correo);
      $('#empresa').val(data.emp_nom);
      $('#area').val(data.areas_nom);
      $('#ubicacion').val(data.ubicacion_nom);
      $("#tickd_descripusu").summernote("code", data.tick_descrip);
      $("#tickd_descrip_diag_mant").summernote("code", data.tick_diag_mant);
      $('#orden_compra').val(data.tick_num_ord_compra);
      $('#tecnico').val(data.nombre_soporte);
    }
  );
}

$(document).ready(function () {
  var tick_id = getUrlParameter("ID");
  // Realiza una solicitud POST para obtener los datos de la consulta
  $.post(
    "../../controller/ticket.php?op=listar_materiales",
    { tick_id: tick_id },
    function (data) {
      data = JSON.parse(data);

      // Verifica si los datos se han recuperado correctamente
      if (data && data.aaData && data.aaData.length > 0) {
        var tablaDatos = $("#tablaDatos-body"); // Obtén el cuerpo de la tabla

        // Itera sobre los datos y agrega filas a la tabla
        data.aaData.forEach(function (dato) {
          var fila = $("<tr></tr>"); // Crea una nueva fila

          // Agrega las celdas con la descripción y la cantidad
          fila.append("<td>" + dato[0] + "</td>");
          fila.append("<td>" + dato[1] + "</td>");
          fila.append("<td>" + dato[2] + "</td>");

          tablaDatos.append(fila); // Agrega la fila al cuerpo de la tabla
        });
      }
    }
  );
});

function mostrarCampoRequisicion() {
  document.getElementById("numero_requisicion").style.display = "block";
  document.getElementById("numero_orden_compra").style.display = "none";
  document.getElementById("reasignar_ticket").style.display = "block";
  document.getElementById("enviar_compras").style.display = "none";
}

function mostrarCampoOrdenCompra() {
  document.getElementById("numero_requisicion").style.display = "none";
  document.getElementById("numero_orden_compra").style.display = "block";
  document.getElementById("reasignar_ticket").style.display = "none";
  document.getElementById("enviar_compras").style.display = "block";
}

init();