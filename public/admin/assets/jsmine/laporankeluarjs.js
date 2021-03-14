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

	var groupColumn = 0;
    var table = $('#kelming').DataTable({
		"searching": false,
		"paging": false,
		"bInfo": false,
		"ordering": false,
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
		"order": [[ groupColumn, 'asc' ]],
		"footerCallback": function (row, data, start, end, display) {
            var api = this.api(),
               data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
               return typeof i === 'string' ?
                  i.replace(/[\,]/g, '') * 1 :
                  typeof i === 'number' ?
                  i : 0;
            };
            // Total over all pages
            total = api
               .column(4)
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);
   
            // Total over this page
            pageTotal = api
               .column(4, {
                  page: 'current'
               })
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);


               total1 = api
               .column(5)
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);
   
            // Total over this page
            pageTotal1 = api
               .column(5, {
                  page: 'current'
               })
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);

            // Update footer
            $(api.column(4).footer()).html(
               '' + pageTotal + ''
            );

            $(api.column(5).footer()).html(
                '' + pageTotal1 + ''
             );
         },

        // "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group text-right"><td colspan="6"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
	} );



	/////////////////////////

	var groupColumn1 = 0;
    var table = $('#supming').DataTable({
        //"searching": false,
		"paging": false,
		"bInfo": false,
		//"ordering": false,
        "columnDefs": [
            { "visible": false, "targets": groupColumn1 }
        ],
        "order": [[ groupColumn1, 'asc' ]],

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(),
               data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
               return typeof i === 'string' ?
                  i.replace(/[\,]/g, '') * 1 :
                  typeof i === 'number' ?
                  i : 0;
            };
            // Total over all pages
            total = api
               .column(3)
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);
   
            // Total over this page
            pageTotal = api
               .column(3, {
                  page: 'current'
               })
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);


               total1 = api
               .column(4)
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);
   
            // Total over this page
            pageTotal1 = api
               .column(4, {
                  page: 'current'
               })
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);

            // Update footer
            $(api.column(3).footer()).html(
               '' + pageTotal + ''
            );

            $(api.column(4).footer()).html(
                '' + pageTotal1 + ''
             );
         },



        // "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn1, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group text-center"><td colspan="6"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
	
	




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
	});

	// $('#awal_minggu').val('');
	// $('#akhir_minggu').val('');

	// $('#cari-tanggal-mingguan').click(function () {


	// 	var awal_minggu = $('#awal_minggu').val();
	// 	var akhir_minggu = $('#akhir_minggu').val();

	// 	$('.tampil-daftar').html('');
	// 	//$('#tampil-total-daftar').html('');
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
	// 			url: 'ambilbarangkeluarmingguan',
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

	// 					//var total = res.data2.total_harga_pokok;


	// 					$.each(minggu, function (i) {
	// 						var k = i + 1;
	// 						rules = [];
	// 						// rules1 = [];
	// 						var kode = minggu[i].tt_kode_transaksi;
	// 						var kasir = minggu[i].nama;
	// 						var nama_pembeli = minggu[i].tt_nama_penerima;
	// 						var jenis_pembeli = minggu[i].role;
	// 						var nama_barang = minggu[i].nama_barang;
	// 						var qty = minggu[i].t_qty;
	// 						if(minggu[i].tt_role_id == 4){
	// 							var harga_satuan = minggu[i].harga_konsumen;
	// 						}else if(minggu[i].tt_role_id == 5){
	// 							var harga_satuan = minggu[i].harga_konsumen;
	// 						}
	// 						var subtotal = harga_satuan * qty;
	// 						var total_beli = minggu[i].tt_total_harga;
	// 						var jumlah_uang = minggu[i].tt_jumlah_uang;
	// 						var kembalian = minggu[i].tt_kembalian;
	// 						var tanggal_beli = minggu[i].tanggal;
							
	// 						//var total = minggu[i].total_harga_pokok;


	// 						var daf = `<tr>
	// 								<th class="text-center" style="border:1px solid black;" scope="row">` + k++ + `</th>
	// 								<td style="border:1px solid black; border-left: none;">
	// 								` + kode + `</td>
	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + kasir + `</td>
									

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + nama_pembeli + `</td>
									
	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + jenis_pembeli + `</td>

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + nama_barang + `</td>

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + qty + `</td>

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + harga_satuan + `</td>

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + subtotal + `</td>

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + total_beli + `</td>

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + jumlah_uang + `</td>

	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + kembalian + `</td>
									
	// 								<td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
	// 								` + tanggal_beli + `</td>

	// 							</tr>`;
								
	// 							$('.tampil-daftar').append(daf);
	// 							//rules.push(total);

	// 					});

	// 					// var tot = `<tr>
	// 					// 		<th colspan="6" style="border: 1px solid black;">Total</th>
	// 					// 		<th colspan="1" class="text-center" style="border-bottom: 1px solid black; border-right: 1px solid black;">3</th>
	// 					// 		<th colspan="1" style="border-right: none; border-bottom: 1px solid black;">`+total+`</th>
	// 					// 		<th colspan="1" style="border:1px solid black;"></th>
	// 					// 	  </tr>`; 
						
	// 					// $('#tampil-total-daftar').html(tot);
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