// ejemplo listardatatable("#ticket_data","op=listar_x_est_pend_cierr_jefe_mant");
function listardatatablehelper(nombreTabla, opcionController, numeroColumnaOrden,orden, datosAdicionales = null ) {
  var ajaxConfig = {
    url: "../../controller/ticket.php?" + opcionController,
    type: "post",
    dataType: "json",
    error: function (e) {
      console.log(this.data);
      console.log(e.responseText);
    },
  };

  if (datosAdicionales !== null) {
    ajaxConfig.data = datosAdicionales;
  }
  
  tabla = $(nombreTabla)
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      searching: true,
      lengthChange: false,
      colReorder: true,
      buttons: [
        {
          extend: "excelHtml5",
          text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
          className: "btn-success",
        },
        {
          extend: "copyHtml5",
          text: '<i class="fa fa-copy" aria-hidden="true"></i> Copiar',
          className: "buttons-copy",
        },
        {
          extend: "pdfHtml5",
          text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
          className: "btn-danger",
        },
      ],
      ajax: ajaxConfig,
      ordering: true,
      order: [[numeroColumnaOrden, orden]],
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
}
