// Call the dataTables jQuery plugin
$(document).ready( function() {
    $('.datatable').dataTable( {
      dom: 'Bfrtip',
      buttons: [
          {
            text: '<i class="fas fa-print fa-sm"></i> Imprimir Listado',
            extend: 'print',
            className: 'btn btn-primary'
          }
      ],
      "language": {
        "url": "/js/demo/es_es.json"
      },
      "order": [[ 0, "pre" ]],
      "stateSave": true,
      initComplete: function (settings, json) {
        $(".buttons-print").removeClass("dt-button");
      }
    } );
  } );

    