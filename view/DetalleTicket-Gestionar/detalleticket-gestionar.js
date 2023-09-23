function init() {}

$(document).ready(function () {
  var tick_id = getUrlParameter("ID");

  listardetalle(tick_id);

  /* TODO: Llenar Combo Tipo De Mantenimiento */
  $.post("../../controller/tipomantenimiento.php?op=combo", function (data) {
    $("#tip_man_id").html(data);
  });

  /* TODO:LLenar Combo Sistemas asignar */
  $.post("../../controller/sistemas.php?op=combo", function (data) {
    $("#sis_id").html(data);
  });

  /* TODO:LLenar Combo Prioridades asignar */
  $.post("../../controller/prioridad.php?op=combo", function (data) {
    $("#pri_id").html(data);
  });

  /* TODO:LLenar Combo Tecnicos asignar */
  $.post("../../controller/usuario.php?op=comboTecnicos", function (data) {
    $("#usu_id_tecnico").html(data);
  });

  /* TODO: Inicializamos summernotejs */
  $("#tickd_descrip").summernote({
    height: 400,
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
  });

  /* TODO: Inicializamos summernotejs */
  $("#tickd_descripusu").summernote({
    height: 400,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
  });


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

$(document).on("click", "#btnasignar", function () {
  var tick_id = getUrlParameter("ID");
  var tip_mant_id = $("#tip_man_id").val();
  var sis_id = $("#sis_id").val();
  var pri_id = $("#pri_id").val();
  var usu_id_tecnico = $("#usu_id_tecnico").val();
  var tickd_descripusu = $("#tickd_descripusu").val();

  var camposFaltantes = verificarCampos(
    tip_mant_id,
    sis_id,
    pri_id,
    usu_id_tecnico,
    tickd_descripusu
  );

  // Verificar si hay campos faltantes y mostrar mensaje correspondiente
  if (camposFaltantes.length > 0) {
    var mensaje = "Falta completar los siguientes campos:\n\n";
    mensaje += camposFaltantes.join("\n");

    swal("Advertencia!", mensaje, "warning");
  } else {
    var formData = new FormData();
    formData.append("tick_id", tick_id);
    formData.append("tip_mant_id", tip_mant_id);
    formData.append("sis_id", sis_id);
    formData.append("pri_id", pri_id);
    formData.append("usu_id_tecnico", usu_id_tecnico);
    formData.append("tickd_descripusu", tickd_descripusu);

    // echo "<script>console.log('$resultado');</script>";
    /* TODO:Insertar detalle */
    $.ajax({
      url: "../../controller/ticket.php?op=asignar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        listardetalle(tick_id);

        /* TODO: Envio de alerta Email de ticket Abierto */
        $.post(
          "../../controller/email.php?op=ticket_asignado",
          { tick_id: tick_id },
          function (data) {}
        );

        /* TODO: Limpiar inputfile */
        $("#fileElem").val("");

        swal(
          {
            title: "Correcto!",
            text: "Asignado Exitosamente",
            icon: "success",
          },
          function (result) {
            console.log(result); // Imprimir el resultado en la consola
            if (result) {
              window.location.href =
                "http://192.168.1.194:8080/helpdesk/view/GestionarTicket/";
            }
          }
        );
      },
    });
  }
});

function listardetalle(tick_id) {
  /* TODO: Mostramos informacion del ticket en inputs */
  $.post(
    "../../controller/ticket.php?op=mostrarGestionar",
    { tick_id: tick_id },
    function (data) {
      data = JSON.parse(data);
      $("#lblnomidticket").html("Detalle Ticket - " + data.tick_id);
      $("#lblestado").html(data.tick_estado);
      $("#usuario").val(data.usu_correo);
      $("#empresa").val(data.emp_nom);
      $("#area").val(data.areas_nom);
      $("#ubicacion").val(data.ubicacion_nom);
      $("#tick_titulo").val(data.tick_titulo);
      $("#tickd_descripusu").summernote("code", data.tick_descrip);
    }
  );
}

function verificarCampos(tip_mant_id, sis_id, pri_id, usu_id_tecnico) {
  var camposFaltantes = [];

  if (tip_mant_id === "") {
    camposFaltantes.push("Tipo de Mantenimiento");
  }

  if (sis_id === "") {
    camposFaltantes.push("Sistema");
  }

  if (pri_id === "") {
    camposFaltantes.push("Prioridad");
  }

  if (usu_id_tecnico === "") {
    camposFaltantes.push("Usuario Técnico");
  }

  return camposFaltantes;
}

function mostrarCampoSolicitudCompra() {
  document.getElementById("campoNumeroSolicitudCompra").style.display = "block";
}

function ocultarCampoSolicitudCompra() {
  document.getElementById("campoNumeroSolicitudCompra").style.display = "none";
  document.getElementById("numeroSolicitudCompra").value = "";
}

function mostrarCampoRequisicion() {
  document.getElementById("campoNumeroRequisicion").style.display = "block";
}

function ocultarCampoRequisicion() {
  document.getElementById("campoNumeroRequisicion").style.display = "none";
  document.getElementById("numeroRequisicion").value = "";
}

init();
