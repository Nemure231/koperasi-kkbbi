
//const flashData = $('.flash-data').data('flashdata');

// if (flashData) {
//    Swal.fire({
//       title: 'Berhasil',
//       hideClass: {
//          popup: 'animate__animated animate__fadeOutUp animate__fast'
//       },
//       text: ' ' + flashData,
//       icon: 'success'
//    });

// }


$(document).ready(function () {

	
	
		var groupColumn = 0;
		var table = $('#mastah').DataTable({
			"searching": false,
			"paging": false,
			"bInfo": false,
			"ordering": false,
			"columnDefs": [
				{ "visible": false, "targets": groupColumn }
			],
			"order": [[ groupColumn, 'asc' ]],
			// "displayLength": 25,
			"drawCallback": function ( settings ) {
				var api = this.api();
				var rows = api.rows( {page:'current'} ).nodes();
				var last=null;
	 
				api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
						$(rows).eq( i ).before(
							'<tr class="group text-left"><td colspan="6"><strong>'+group+'</strong></td></tr>'
						);
	 
						last = group;
					}
				} );
			}
		} );

		 // Order by the grouping
    // $('#mastah tbody').on( 'click', 'tr.group', function () {
    //     var currentOrder = table.order()[0];
    //     if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
    //         table.order( [ groupColumn, 'desc' ] ).draw();
    //     }
    //     else {
    //         table.order( [ groupColumn, 'asc' ] ).draw();
    //     }
    // } );

	$('#cari_tahun').datepicker({
		format: "yyyy",
		startView: "year",
		minViewMode: "years"
	});
   

});

$('#print').click(function () {


	let printContents, popupWin;
        printContents = document.getElementById('area-1').innerHTML;
		popupWin = window.open('', '_blank', 'height=500, width=500');
        popupWin.document.open();
        popupWin.document.write(`
          <html>
            <head>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            </head>
			<style>
			

            </style>
        <body onload="window.print();">${printContents}</body>
          </html>`
        );
        popupWin.document.close();

 
	// var divContents = document.getElementById("area-1").innerHTML; 
	// var a = window.open('', '', 'height=500, width=500'); 
	// a.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"><html>'); 
	// a.document.write('<body >');
	// a.document.write(divContents); 
	// a.document.write('</body></html>'); 
	// a.document.close(); 
	// a.print(); 
});


