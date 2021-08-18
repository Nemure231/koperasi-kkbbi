

// const flashData = $('.flash-data').data('flashdata');

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
	$("#tabel-stok").DataTable();

	// $('#tombol-tambah').click(function () {
	// 	$('#modal-muncul').modal('show');
  
	//  });
  

	$('#cari_awal_minggu').datepicker(
		{
		format: "yyyy-mm-dd"
		// startView: "year",
		// minViewMode: "months"
	}
	);

	$('#cari_akhir_minggu').datepicker(
		{
		format: "yyyy-mm-dd"
		// startView: "year",
		// minViewMode: "years"
	}
	);


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
			@page {
				size: auto;
				margin-bottom: 0;
				margin-top: 0;
			}

			

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


