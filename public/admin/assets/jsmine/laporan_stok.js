

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

	$('table').on('click', '.tombol-lihat-riwayat-masuk', function () {
		var tables = $("#tabel-riwayat-masuk").DataTable();	
 		tables.clear()
		$('#modal-lihat-riwayat-masuk').modal('show');
		$('#tampil-riwayat-masuk').html('');
		var csrfName = $('#csrf_riwayat_masuk').attr('name');
		var csrfHash = $('#csrf_riwayat_masuk').val();
		var id_barang = $(this).data('id_barang');

		$.ajax({
			url: 'stok/stok_masuk',
			data: {
				[csrfName]: csrfHash,
				id_barang: id_barang

			},
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			method: "POST",
			dataType: 'json',
			success: function (res) {
				var table;
				table = $("#tabel-riwayat-masuk").DataTable();	

				if (res.data) {
					$('#csrf_riwayat_masuk').val(res.csrf_hash);
					$('#csrf_riwayat_keluar').val(res.csrf_hash);

					var stok = res.data;
					// console.log(res.data);
					var im = 1;
					$.each(stok, function (i) {
						

						var stok_masuk = res.data[i].stok_masuk;
						var tanggal_masuk = res.data[i].tanggal_masuk;
			
						// var rus = ` <tr>
						// 	<th scope="row">`+im+`</th>
						// 	<td>`+stok_masuk+`</td>
						// 	<td>`+tanggal_masuk+`</td>
					  	// </tr>`;

						// $('#tampil-riwayat-masuk').append(rus);
						// $('#tampil-riwayat-keluar').append(rus);
						table.row.add([ im,stok_masuk, tanggal_masuk]);
						im++;
						
					  });
					  $("#tabel-riwayat-masuk").DataTable();
					

				} else {				
					$('#csrf_riwayat_masuk').val(res.csrf_hash);	
					$('#csrf_riwayat_keluar').val(res.csrf_hash);				
					$("#tabel-riwayat-masuk").DataTable();
				}
				table.draw();

			}
		});

	});

	$('table').on('click', '.tombol-lihat-riwayat-keluar', function () {
		var tables = $("#tabel-riwayat-keluar").DataTable();	
 		tables.clear();
		$('#modal-lihat-riwayat-keluar').modal('show');
		$('#tampil-riwayat-keluar').html('');
		var csrfName = $('#csrf_riwayat_keluar').attr('name');
		var csrfHash = $('#csrf_riwayat_keluar').val();
		var id_barang = $(this).data('id_barang');

		$.ajax({
			url: 'stok/stok_keluar',
			data: {
				[csrfName]: csrfHash,
				id_barang: id_barang

			},
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			method: "POST",
			dataType: 'json',
			success: function (res) {
				var table;
				table = $("#tabel-riwayat-keluar").DataTable();	

				if (res.data) {
					$('#csrf_riwayat_keluar').val(res.csrf_hash);
					$('#csrf_riwayat_masuk').val(res.csrf_hash);	

					var stok = res.data;
					// console.log(res.data);
					var im = 1;
					$.each(stok, function (i) {
							$("#tabel-riwayat-keluar").DataTable();	

						var stok_keluar = res.data[i].stok_keluar;
						var tanggal_keluar = res.data[i].tanggal_keluar;
			
	
						table.row.add([ im,stok_keluar, tanggal_keluar]);
						im++;
						
					  });
					  
						// $("#tabel-riwayat-keluar").DataTable();	
					

				} else {				
					$('#csrf_riwayat_keluar').val(res.csrf_hash);	
					$('#csrf_riwayat_masuk').val(res.csrf_hash);
					// $("#tabel-riwayat-keluar").DataTable();						

				}
				table.draw();

			}
		});
		

	});


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


