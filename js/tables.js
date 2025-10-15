$(document).ready(function() {
  $('#tabelamoduli').DataTable( {
      "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Croatian.json"
      },
      "dom": '<"top"lfr>t<"bottom"Bip>',
      "lengthMenu": [ [15, 25, 50, 100], [15, 25, 50, 100] ],
      "scrollX": true,
      "ordering": true,
      "order": [],
      "responsive": {
      "details": {
        "type": 'column',
        "target": 0
      }
    },
       buttons: [
            {
              extend: 'excel',
              exportOptions: {
                  orthogonal: 'export'
              }
            }
        ]
  } );
} );  

$(document).ready(function() {
  $('#tabelausers').DataTable( {
      "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Croatian.json"
      },
      "dom": '<"top"lfr>t<"bottom"Bip>',
      "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
      "ordering": true,
      "order": [],
      "responsive": {
      "details": {
        "type": 'column',
        "target": 0
      }
    },
       buttons: [
            {
              extend: 'excel',
              exportOptions: {
                  orthogonal: 'export'
              }
            }
        ]
  } );
} );  

$(document).ready(function() {
  $('#tabelaregistratori').DataTable( {
      "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Croatian.json"
      },
      "dom": '<"top"lfr>t<"bottom"Bip>',
      "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
      "ordering": true,
      "order": [],
      "responsive": {
      "details": {
        "type": 'column',
        "target": 0
      }
    },
       buttons: [
            {
              extend: 'excel',
              exportOptions: {
                  orthogonal: 'export'
              }
            }
        ]
  } );
} );  

$(document).ready(function() {
  $('#tabelafiles').DataTable( {
      "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Croatian.json"
      },
      "dom": '<"top"t>',
      "lengthMenu": [ [15, 25, 50, 100], [15, 25, 50, 100] ],
      "ordering": false,
      "order": [],
      "responsive": {
      "details": {
        "type": 'column',
        "target": 0
      }
    },
       buttons: [] // Uklanjamo sve dugmad
  } );
} );
