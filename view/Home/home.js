function init() {}

$(document).ready(function () {
  var usu_id = $("#user_idx").val();

  /* TODO: Llenar graficos segun rol  */
  if ($("#rol_idx").val() == 1) {
    $.post("../../controller/ticket.php?op=totalxgestionar", function (data) {
      data = JSON.parse(data);
      $("#lbltotalxgestionar").html(data.TOTAL);
    });

    $.post("../../controller/ticket.php?op=totalxrealizar", function (data) {
      data = JSON.parse(data);
      $("#lbltotalxrealizar").html(data.TOTAL);
    });

    $.post("../../controller/ticket.php?op=totalxmateriales", function (data) {
      data = JSON.parse(data);
      $("#lbltotalxmateriales").html(data.TOTAL);
    });

    $.post(
      "../../controller/ticket.php?op=totalconmateriales",
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalconmateriales").html(data.TOTAL);
      }
    );

    $.post("../../controller/ticket.php?op=totalxvistobueno", function (data) {
      data = JSON.parse(data);
      $("#lbltotalxvistobueno").html(data.TOTAL);
    });

    $.post("../../controller/ticket.php?op=totalxcerrar", function (data) {
      data = JSON.parse(data);
      $("#lbltotaltotalxcerrar").html(data.TOTAL);
    });

    $.post(
      "../../controller/usuario.php?op=totalcerrado",
      { usu_id: usu_id },
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalcerrado").html(data.TOTAL);
      }
    );
  } else if ($("#rol_idx").val() == 2) {
    $.post("../../controller/ticket.php?op=totalxgestionar", function (data) {
      data = JSON.parse(data);
      $("#lbltotalxgestionar").html(data.TOTAL);
    });

    $.post("../../controller/ticket.php?op=totalxRealizarTecnicoJefe",{ usu_id: usu_id }, function (data) {
      data = JSON.parse(data);
      $("#lbltotalxrealizartecnicos").html(data.TOTAL);
    });

    $.post("../../controller/ticket.php?op=totalxrealizarproveedores",{ usu_id: usu_id }, function (data) {
      data = JSON.parse(data);
      $("#lbltotalxrealizarproveedores").html(data.TOTAL);
    });

    $.post("../../controller/ticket.php?op=totalxmateriales", function (data) {
      data = JSON.parse(data);
      $("#lbltotalxmateriales").html(data.TOTAL);
    });

    $.post(
      "../../controller/ticket.php?op=totalencompras",
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalencompras").html(data.TOTAL);
      }
    );

    $.post(
      "../../controller/ticket.php?op=totalconmateriales",
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalconmateriales").html(data.TOTAL);
      }
    );

    $.post("../../controller/ticket.php?op=totalxvistobueno", function (data) {
      data = JSON.parse(data);
      $("#lbltotalxvistobueno").html(data.TOTAL);
    });

    $.post("../../controller/ticket.php?op=totalxcerrar", function (data) {
      data = JSON.parse(data);
      $("#lbltotaltotalxcerrar").html(data.TOTAL);
    });

    $.post(
      "../../controller/ticket.php?op=totalcerrado",
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalcerrados").html(data.TOTAL);
      }
    );
  } else if ($("#rol_idx").val() == 3) {
    $.post(
      "../../controller/ticket.php?op=totalxRealizarTecnico",
      { usu_id: usu_id },
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalxRealizarTecnico").html(data.TOTAL);
      }
    );

    $.post(
      "../../controller/ticket.php?op=totalconmaterialesTecnico",
      { usu_id: usu_id },
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalconmaterialestecnico").html(data.TOTAL);
      }
    );
  } else {
    $.post(
      "../../controller/usuario.php?op=totalabierto",
      { usu_id: usu_id },
      function (data) {
        data = JSON.parse(data);
        $("#lbltotalabierto").html(data.TOTAL);
      }
    );

    $.post("../../controller/usuario.php?op=total_x_visto_bueno",{ usu_id: usu_id }, function (data) {
      data = JSON.parse(data);
      $("#lbltotalxvistobueno").html(data.TOTAL);
    });

    $.post("../../controller/usuario.php?op=totalcerrado",{ usu_id: usu_id }, function (data) {
      data = JSON.parse(data);
      $("#lbltotalcerrado").html(data.TOTAL);
    });
  }
});

init();
