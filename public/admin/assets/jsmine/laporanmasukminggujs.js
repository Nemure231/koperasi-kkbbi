$(document).ready(function () {

	var groupColumn = 0;
		var table = $('#masming').DataTable({
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
			  </html>`);
		popupWin.document.close();

		// @page {
		// 	size: auto;
		// 	margin-bottom: 0;
		// 	margin-top: 0;
		// }
	});

	const flashData = $('.flash-data').data('flashdata');

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


	// $('#awal_minggu').val('');
	// $('#akhir_minggu').val('');

	// $('#cari-tanggal-mingguan').click(function () {


	// 	var awal_minggu = $('#awal_minggu').val();
	// 	var akhir_minggu = $('#akhir_minggu').val();

	// 	$('.tampil-daftar').html('');
	// 	$('#tampil-total-daftar').html('');
	// 	if (awal_minggu == '') {
	// 		Swal.fire({
	// 			title: 'Gagal',
	// 			hideClass: {
	// 				popup: 'animate__animated animate__fadeOutUp animate__fast'
	// 			},
	// 			text: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!',
	// 			icon: 'error'
	// 		});


	// 	} else if (akhir_minggu == '') {
	// 		Swal.fire({
	// 			title: 'Gagal',
	// 			hideClass: {
	// 				popup: 'animate__animated animate__fadeOutUp animate__fast'
	// 			},
	// 			text: 'Tanggal akhir tidak boleh kosong!',
	// 			icon: 'error'
	// 		});

	// 	} else if (awal_minggu >= akhir_minggu) {

	// 		Swal.fire({
	// 			title: 'Gagal',
	// 			hideClass: {
	// 				popup: 'animate__animated animate__fadeOutUp animate__fast'
	// 			},
	// 			text: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!',
	// 			icon: 'error'
	// 		});

	// 	} else if (awal_minggu == akhir_minggu) {
	// 		Swal.fire({
	// 			title: 'Gagal',
	// 			hideClass: {
	// 				popup: 'animate__animated animate__fadeOutUp animate__fast'
	// 			},
	// 			text: 'Tanggal awal tidak boleh sama dengan tanggal akhir!',
	// 			icon: 'error'
	// 		});


	// 	} else {

	// 		$.ajax({
	// 			url: 'ambilbarangmasukmingguan',
	// 			//method: "POST",
	// 			//yang sebelah kiri adalah data yang diambil lewat get codeigniter,
	// 			//yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
	// 			//bergitulah caranya agar dapat menjaalankan fungsi di controller
	// 			data: {
	// 				awal_minggu: awal_minggu,
	// 				akhir_minggu: akhir_minggu
	// 			},
	// 			headers: {
	// 				'X-Requested-With': 'XMLHttpRequest'
	// 			},
	// 			type: "post",
	// 			dataType: 'json',
	// 			context: this,
	// 			success: function (res) {
	// 				if (res.response == true) {

	// 					let minggu = res.data;

	// 					var total = res.data2.total_harga_pokok;


	// 					$.each(minggu, function (i) {
	// 						var k = i + 1;
	// 						rules = [];
	// 						// rules1 = [];
	// 						var nama = minggu[i].nama_barang;
	// 						var bulan = minggu[i].bulan;
	// 						var nama_pengirim = minggu[i].nama_pengirim_barang;
	// 						var harga = minggu[i].harga_pokok_pb;
	// 						var jml = minggu[i].jumlah_barang_masuk;
	// 						var subtotal = harga * jml;
	// 						//var total = minggu[i].total_harga_pokok;


	// 						var daf = `<tr>
	// 								<th class="text-center" style="border:1px solid black;" scope="row">` + k++ + `</th>
	// 								<td style="border:1px solid black; border-left: none;">
	// 								` + nama + `</td>
	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + nama_pengirim + `</td>
									

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + harga + `</td>
	// 								<td class="text-center" style="border:1px solid black;">` + jml + `</td>
	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + subtotal + `</td>
									
	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + bulan + `</td>

	// 							</tr>`;
								
	// 							$('.tampil-daftar').append(daf);
	// 							//rules.push(total);

	// 					});

	// 					var tot = `<tr>
	// 							<th colspan="4" style="border: 1px solid black;">Total</th>
	// 							<th colspan="1" class="text-center" style="border-bottom: 1px solid black; border-right: 1px solid black;">3</th>
	// 							<th colspan="1" style="border-right: none; border-bottom: 1px solid black;">`+total+`</th>
	// 							<th colspan="1" style="border:1px solid black;"></th>
	// 						  </tr>`; 
						
	// 					$('#tampil-total-daftar').html(tot);
	// 					$('#awal_minggu').val('');
	// 					$('#akhir_minggu').val('');

	// 						Swal.fire({
	// 							title: 'Berhasil',
	// 							hideClass: {
	// 								popup: 'animate__animated animate__fadeOutUp animate__fast'
	// 							},
	// 							text: 'Transaksi berhasil dicari!',
	// 							icon: 'success'
	// 						});
	// 				} else {
	// 					$('#awal_minggu').val('');
	// 					$('#akhir_minggu').val('');

	// 					Swal.fire({
	// 						title: 'Gagal',
	// 						hideClass: {
	// 							popup: 'animate__animated animate__fadeOutUp animate__fast'
	// 						},
	// 						text: 'Tidak ada transaksi di renggang tanggal tersebut!',
	// 						icon: 'error'
	// 					});

	// 				}



	// 			}
	// 		});
	// 	}

	// });







});