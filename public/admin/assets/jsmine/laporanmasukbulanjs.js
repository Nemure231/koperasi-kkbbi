
// $(document).ready(function () {

	// const flashData = $('.flash-data').data('flashdata');

	// if (flashData) {
	//    Swal.fire({
	// 	  title: 'Berhasil',
	// 	  hideClass: {
	// 		 popup: 'animate__animated animate__fadeOutUp animate__fast'
	// 	  },
	// 	  text: ' ' + flashData,
	// 	  icon: 'success'
	//    });
	
	// }
	

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

});



$(document).ready(function () {

	var groupColumn = 0;
		var table = $('#masbul').DataTable({
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

    $('#cari_bulan').datepicker({
		format: "mm",
		startView: "year",
		minViewMode: "months"
	});

	$('#cari_tahun').datepicker({
		format: "yyyy",
		startView: "year",
		minViewMode: "years"
	});

   

});


