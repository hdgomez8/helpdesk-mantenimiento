function init() { }

$(document).ready(function () {
  var tick_id = getUrlParameter("ID");

  listardetalle(tick_id);

  $.post("../../controller/material.php?op=combo", function (data) {
    $("#descripcion").html(data);
  });

  $.post("../../controller/unidad.php?op=combo", function (data) {
    $("#unidad").html(data);
  });

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

  $("#table1").DataTable({
    paging: false, // Desactivar paginación
    searching: false, // Desactivar búsqueda
    info: false, // Desactivar información de registros
    ordering: false,
  });
});

var currentTable = "table1"; // Indica la tabla actual en la que se deben agregar las filas

var materiales = [];

$(document).ready(function () {
  // Crear la tabla DataTable
  var table = $("#" + currentTable).DataTable();

  // Función para agregar un material a la tabla
  function agregarMaterial(material) {
    table.row
      .add([material.nombreMaterial, material.nombreUnidad, material.cantidad])
      .draw();
  }

  $("#agregarBtn").on("click", function () {
    var descripcion = $("#descripcion").val();
    var cantidad = parseInt($("#cantidad").val());
    var unidad = $("#unidad").val();

    // Realizar la consulta para obtener el nombre del material por ID
    $.ajax({
      url: "../../controller/material.php?op=nombre_material",
      type: "post",
      data: { descripcion: descripcion },
      dataType: "json",
      success: function (response) {
        var nombreMaterial = response.nombre; // Nombre del material

        // Realizar la consulta para obtener el nombre de la unidad por ID
        $.ajax({
          url: "../../controller/unidad.php?op=nombre_unidad",
          type: "post",
          data: { unidad: unidad }, // Envía el ID de la unidad
          dataType: "json",
          success: function (unidadResponse) {
            var nombreUnidad = unidadResponse.unidad_nombre; // Nombre de la unidad
            // Buscar el material en el arreglo
            var materialExistente = materiales.find(function (material) {
              return (
                material.descripcion === descripcion &&
                material.unidad === unidad
              );
            });

            if (materialExistente) {
              // Si el material existe en el arreglo, suma la cantidad
              materialExistente.cantidad += cantidad;
              // Actualiza la fila en la tabla con el nuevo nombre, cantidad y unidad
              table.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                if (
                  rowData[0] === nombreMaterial &&
                  rowData[1] === nombreUnidad
                ) {
                  rowData[2] = materialExistente.cantidad;
                  this.data(rowData);
                }
              });
            } else {
              // Si el material no existe en el arreglo, agrégalo con el nombre y unidad
              materiales.push({
                descripcion: descripcion,
                nombreMaterial: nombreMaterial,
                unidad: unidad,
                nombreUnidad: nombreUnidad,
                cantidad: cantidad,
              });
              // Agrega el nuevo material a la tabla
              agregarMaterial(materiales[materiales.length - 1]);
            }

            // Cerrar el modal
            $("#agregarModal").modal("hide");

            // Limpiar los campos del formulario
            $("#descripcion").val("Seleccionar");
            $("#unidad").val("0");
            $("#cantidad").val("0");

            console.log("materiales:", materiales);
          },
          error: function (error) {
            console.log("Error en la consulta de unidad:", error);
          },
        });
      },
      error: function (error) {
        console.log("Error en la consulta de material:", error);
      },
    });
  });

  // Aplicar estilos a las filas de la tabla actual
  $("#" + currentTable + " tbody tr").css({
    border: "1px solid black",
    padding: "8px",
  });
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

$(document).on("click", "#btncerrarticket", function () {
  var tickd_descrip_diag_mant = $("#tickd_descrip_diag_mant").val();
  var tickd_descrip_act_rep_efec = $("#tickd_descrip_act_rep_efec").val();
  var opcionMateriales = $("input[name='opcionMateriales']:checked").val();

  if (!tickd_descrip_diag_mant.trim() || !tickd_descrip_act_rep_efec.trim()|| opcionMateriales === "" || opcionMateriales === null || opcionMateriales === undefined) {
    // El campo está vacío, muestra un mensaje de error
    swal("Error", "Por favor, ingrese una descripción del diagnóstico de mantenimiento y una descripcion de actividad antes de Cerrar la solicitud.", "error");
  } else {
    /* TODO: Preguntamos antes de cerrar el ticket */
    swal(
      {
        title: "HelpDesk",
        text: "Esta seguro de Cerrar el Ticket?",
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
          var usu_id = $("#user_idx").val();
          var tickd_descrip_diag_mant = $("#tickd_descrip_diag_mant").val();
          var tickd_descrip_act_rep_efec = $("#tickd_descrip_act_rep_efec").val();

          /* TODO: Actualizamos el ticket  */
          $.post(
            "../../controller/ticket.php?op=update_x_tecnico",
            {
              tick_id: tick_id,
              tickd_descrip_diag_mant: tickd_descrip_diag_mant,
              tickd_descrip_act_rep_efec: tickd_descrip_act_rep_efec,
            },
            function (data) { }
          );

          $.post(
            "../../controller/email.php?op=ticket_cerrado",
            { tick_id: tick_id },
            function (data) {
              // Tu código de éxito aquí
            }
          ).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error al enviar el correo:", textStatus, errorThrown);
          });

          swal(
            {
              title: "Ticket Cerrado!",
              text: "Ticket Cerrado correctamente.",
              type: "success",
              confirmButtonClass: "btn-success",
            },
            function (result) {
              console.log(result); // Imprimir el resultado en la consola
              if (result) {
                var dir_proyecto = document.getElementById("dir_proyecto").value;
                window.location.href =
                  dir_proyecto + "view/ConsultarTicketPendientes/";
              }
            }
          );
        }
      }
    );
  }

});

$(document).on("click", "#btnsolicitarmateriales2", function () {
  var tickd_descrip_diag_mant = $("#tickd_descrip_diag_mant").val();

  swal(
    {
      title: "Solicitar los materiales",
      text: "Esta seguro de solicitar los materiales?",
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

        var formData = new FormData();
        formData.append("tickd_descrip_diag_mant", tickd_descrip_diag_mant);
        formData.append("tick_id", tick_id);
        formData.append("materiales", JSON.stringify(materiales));

        console.log(formData);
        /* TODO: Actualizamos el ticket  */
        $.ajax({
          url: "../../controller/ticket.php?op=update_x_tecnico_materiales",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data) {
            // Ejemplo de uso
            showAlert(tickId);
          },
        });

        /* TODO: Alerta de confirmacion */
        swal(
          {
            title: "Materiales Solicitados",
            text: "Materiales Solicitados Exitosamente.!",
            type: "success",
            confirmButtonClass: "btn-success",
          },
          function (result) {
            console.log(result); // Imprimir el resultado en la consola
            if (result) {
              var dir_proyecto = document.getElementById("dir_proyecto").value;
              window.location.href =
              dir_proyecto + "view/ConsultarTicketPendientes/";
            }
          }
        );
      }
    }
  );
});

$(document).on("click", "#btnsolicitarmateriales", function () {
  var tick_id = getUrlParameter("ID");
  var tickd_descrip_diag_mant = $("#tickd_descrip_diag_mant").val();

  var formData = new FormData();
  formData.append("tick_id", tick_id);
  formData.append("tickd_descrip_diag_mant", tickd_descrip_diag_mant);
  formData.append("materiales", JSON.stringify(materiales));

  // echo "<script>console.log('$resultado');</script>";
  /* TODO:Insertar detalle */
  $.ajax({
    url: "../../controller/ticket.php?op=update_x_tecnico_materiales",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      console.log(data);
      /* TODO: Limpiar inputfile */
      $("#fileElem").val("");

      swal(
        {
          title: "Materiales Solicitados",
          text: "Materiales Solicitados Exitosamente.!",
          type: "success",
          confirmButtonClass: "btn-success",
        },
        function (result) {
          console.log(result); // Imprimir el resultado en la consola
          if (result) {
            var dir_proyecto = document.getElementById("dir_proyecto").value;
            window.location.href =
            dir_proyecto + "view/ConsultarTicketPendientes/";
          }
        }
      );
    },
  });
});

$(document).on("click", "#btnsolicitarproveedor", function () {
  var tickd_descrip_diag_mant = $("#tickd_descrip_diag_mant").val();
  /* TODO: Preguntamos antes de cerrar el ticket */
  if (!tickd_descrip_diag_mant.trim()) {
    // El campo está vacío, muestra un mensaje de error
    swal("Error", "Por favor, ingrese una descripción del diagnóstico de mantenimiento antes de solicitar al proveedor.", "error");
  } else {
    swal(
      {
        title: "Solicitar Proveedor",
        text: "Esta seguro de solicitar el proveedor?",
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
          console.log(tick_id);
          /* TODO: Actualizamos el ticket  */
          $.post(
            "../../controller/ticket.php?op=update_x_tecnico_proveedor",
            {
              tick_id: tick_id,
            },
            function (data) { }
          );
          // listardetalle(tick_id);

          /* TODO: Alerta de confirmacion */
          swal(
            {
              title: "Proveedor Solicitado",
              text: "Proveedor Solicitado Exitosamente.!",
              type: "success",
              confirmButtonClass: "btn-success",
            },
            function (result) {
              console.log(result); // Imprimir el resultado en la consola
              if (result) {
                var dir_proyecto = document.getElementById("dir_proyecto").value;
                window.location.href =
                dir_proyecto + "view/ConsultarTicketPendientes/";
              }
            }
          );
        }
      }
    );
  }

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
      $('#tecnico').val(data.nombre_soporte);
    }
  );
}

function ocultarCamposRequiereMateriales() {
  document.getElementById("descripcion_actividades").style.display = "none";
  document.getElementById("cerrar_ticket").style.display = "none";
  document.getElementById("solicitar_materiales").style.display = "block";
  // Borrar el valor del campo
  document.getElementById("opcionProveedor").value = "";
  // También puedes deseleccionar los radios si es necesario
  document.getElementById("opcionProveedor").checked = false;
  document.getElementById("solicitar_proveedor").style.display = "none";
  document.getElementById("Proveedor").style.display = "none";
}

function mostrarCamposRequiereMateriales() {
  document.getElementById("diagnostico_mantenimiento").style.display = "block";
  document.getElementById("descripcion_actividades").style.display = "block";
  document.getElementById("cerrar_ticket").style.display = "block";
  document.getElementById("solicitar_materiales").style.display = "none";
  document.getElementById("solicitar_proveedor").style.display = "none";
  document.getElementById("Proveedor").style.display = "block";
}

function ocultarCamposRequiereProveedor() {
  document.getElementById("solicitar_proveedor").style.display = "block";
  document.getElementById("cerrar_ticket").style.display = "none";
  document.getElementById("solicitar_materiales").style.display = "none";
  document.getElementById("diagnostico_mantenimiento").style.display = "block";
  document.getElementById("descripcion_actividades").style.display = "none";
  document.getElementById("repuestos_accesorios").style.display = "none";
}

function mostrarCamposRequiereProveedor() {
  document.getElementById("solicitar_proveedor").style.display = "none";
  document.getElementById("cerrar_ticket").style.display = "block";
  document.getElementById("solicitar_materiales").style.display = "none";
  document.getElementById("diagnostico_mantenimiento").style.display = "block";
  document.getElementById("descripcion_actividades").style.display = "block";
  document.getElementById("repuestos_accesorios").style.display = "block";
}

init();
