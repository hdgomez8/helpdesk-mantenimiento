function init() {
  $("#ticket_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

$(document).ready(function () {
  /* TODO: Inicializar SummerNote */
  $("#tick_descrip").summernote({
    height: 150,
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

  /* TODO: Llenar Combo categoria */
  $.post("../../controller/categoria.php?op=combo", function (data, status) {
    $("#cat_id").html(data);
  });

  /* TODO: Llenar Combo empresa */
  $.post("../../controller/empresa.php?op=combo", function (data, status) {
    $("#emp_id").html(data);
  });

  $("#emp_id").change(function () {
    emp_id = $(this).val();
    /* TODO: llenar Combo subcategoria segun cat_id */
    $.post(
      "../../controller/areas.php?op=combo",
      { emp_id: emp_id },
      function (data, status) {
        console.log(data);
        $("#areas_id").html(data);
      }
    );
  });

  $("#areas_id").change(function () {
    areas_id = $(this).val();
    /* TODO: llenar Combo subcategoria segun cat_id */
    $.post(
      "../../controller/ubicacion.php?op=combo",
      { areas_id: areas_id },
      function (data, status) {
        console.log(data);
        $("#ubicacion_id").html(data);
      }
    );
  });
});

const customAlert = document.querySelector(".custom-alert");
const customAlertMessage = document.querySelector("#custom-alert-message");
const customAlertClose = document.querySelector("#custom-alert-close");

// Función para mostrar la alerta
function showAlert(message) {
  customAlertMessage.textContent = message;
  customAlert.style.display = "block";
}

// Función para cerrar la alerta
function closeAlert() {
  var dir_proyecto = document.getElementById("dir_proyecto").value;
  customAlert.style.display = "none";
  window.location.href = dir_proyecto + "view/Home/";
}

// Escuchar el evento click en el botón de cerrar
customAlertClose.addEventListener("click", closeAlert);

function guardaryeditar(e) {
  e.preventDefault();
  var tick_id = getUrlParameter("ID");
  /* TODO: Array del form ticket */
  console.log(tick_id);
  var formData = new FormData($("#ticket_form")[0]);
  /* TODO: validamos si los campos tienen informacion antes de guardar */
  if (
    $("#tick_descrip").summernote("isEmpty") ||
    $("#tick_titulo").val() == "" ||
    $("#emp_id").val() == 0
  ) {
    swal("Advertencia!", "Campos Vacios", "warning");
  } else {
    var totalfiles = $("#fileElem").val().length;
    for (var i = 0; i < totalfiles; i++) {
      formData.append("files[]", $("#fileElem")[0].files[i]);
    }

    /* TODO: Guardar Ticket */
    $.ajax({
      url: "../../controller/ticket.php?op=insert",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        data = JSON.parse(data);
        var tickId = data[0].tick_id;
        console.log(data[0].tick_id);
        console.log(tickId);
        /* TODO: Envio de alerta Email de ticket Abierto */
        $.post(
          "../../controller/email.php?op=ticket_abierto",
          { tick_id: tickId },
          function (data) {}
        );

        /* TODO: Limpiar campos */
        $("#tick_titulo").val("");
        $("#emp_id").val("");
        $("#areas_id").val("");
        $("#ubicacion_id").val("");
        $("#tick_descrip").summernote("reset");

        // Ejemplo de uso
        showAlert(tickId);
      },
    });
  }
}

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

init();
