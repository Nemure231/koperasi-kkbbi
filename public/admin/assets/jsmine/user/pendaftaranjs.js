$(document).ready(function () {

    $('#tanggal').datepicker(
		{
		format: "yyyy-mm-dd",
        defaultTime: false
		// startView: "year",
		// minViewMode: "months"
	}
	);

    $('#ts_sampai').on("change", function () {

        var awal = $('#ts_awal').val();
        var sampai = $('#ts_sampai').val();

        if (awal == sampai) {
          
            iziToast.error({
                title: 'Gagal!',
                message: 'Awal dan samapi tidak boleh sama!',
                position: 'topRight',
                toastOnce: true
             });
             $('#tombol-pendaftaran').prop('disabled', true);
         
        }else if (awal > sampai) {
      
            iziToast.error({
                title: 'Gagal!',
                message: 'Awal tidak boleh lebih besar dari sampai!',
                position: 'topRight',
                toastOnce: true
             });
             $('#tombol-pendaftaran').prop('disabled', true);
        
        }else{
            $('#tombol-pendaftaran').prop('disabled', false);
        }

    });

   
    
    // $('#tsawal').on("change", function () {

    //     var awal = $('#ts_awal').val();
    //     var sampai = $('#ts_sampai').val();
    //     var nama =  $('#nama').val();
    //     var surel =  $('#surel').val();
    //     var telepon =  $('#telelpon').val();
    //     var ktp =  $('#no_ktp').val();
    //     var pekerjaan =  $('#pekerjaan').val();
    //     var no_rek =  $('#no_rekening').val();
    //     var bank =  $('#bank').val();
    //     var an =  $('#atas_nama').val();
    //     var alamat =  $('#alamat').val();
    //     var tanggal =  $('#tanggal').val();
    //     // var kodet = $(this).data("kodet");

    //     // if (awal == '') {
    //     //     // Swal.fire({
    //     //     //     title: 'Gagal',
    //     //     //     hideClass: {
    //     //     //         popup: 'animate__animated animate__fadeOutUp animate__fast'
    //     //     //     },
    //     //     //     text: 'Awal tidak boleh kosong!',
    //     //     //     icon: 'error'
    //     //     // });
    //     //     iziToast.error({
    //     //         title: 'Gagal!',
    //     //         message: 'Awal tidak boleh kosong!',
    //     //         position: 'topRight',
    //     //         toastOnce: true
    //     //      });
    //     //     //$('#btn-submitt').addClass("disabled");
    //     //     //$('#btn-submitt').remove()
    //     //     //$('#heya').trigger('mouseleave').html("<button type='submit' id='btn-submitt' class='btn btn-primary'>Bayar</button>");
    //     //     // $('#heya').html("<a href='#' id='btn-submitt' class='btn text-light btn-primary'>Bayar</a>");


    //     // } else if (sampai == '') {
    //     //     // Swal.fire({
    //     //     //     title: 'Peringatan',
    //     //     //     hideClass: {
    //     //     //         popup: 'animate__animated animate__fadeOutUp animate__fast'
    //     //     //     },
    //     //     //     text: 'Sampai tidak boleh kosong',
    //     //     //     icon: 'warning'
    //     //     // });
    //     //     iziToast.error({
    //     //         title: 'Gagal!',
    //     //         message: 'Sampai tidak boleh kosong!',
    //     //         position: 'topRight',
    //     //         toastOnce: true
    //     //      });
    //         //$('#btn-submitt').addClass("disabled");
    //        // $('#btn-submitt').remove();
    //         // $('#heya').html("<a href='#' id='btn-submitt' class='btn text-light btn-primary'>Bayar</a>");

    //     if (awal == sampai) {
    //         // Swal.fire({
    //         //     title: 'Gagal',
    //         //     hideClass: {
    //         //         popup: 'animate__animated animate__fadeOutUp animate__fast'
    //         //     },
    //         //     text: 'Awal dan sampai tidak boleh sama!',
    //         //     icon: 'error'
    //         // });
    //         iziToast.error({
    //             title: 'Gagal!',
    //             message: 'Awal dan samapi tidak boleh sama!',
    //             position: 'topRight',
    //             toastOnce: true
    //          });
    //         // $('#btn-submitt').addClass("disabled");
    //         //$('#btn-submitt').remove();
    //         // $('#heya').html("<a href='#' id='btn-submitt' class='btn text-light btn-primary'>Bayar</a>");
    //     }else if (awal > sampai) {
    //         // Swal.fire({
    //         //     title: 'Gagal',
    //         //     hideClass: {
    //         //         popup: 'animate__animated animate__fadeOutUp animate__fast'
    //         //     },
    //         //     text: 'Awal tidak boleh lebih besar dari sampai!',
    //         //     icon: 'error'
    //         // });
    //         iziToast.error({
    //             title: 'Gagal!',
    //             message: 'Awal tidak boleh lebih besar dari sampai!',
    //             position: 'topRight',
    //             toastOnce: true
    //          });
    //         // $('#btn-submitt').addClass("disabled");
    //         //$('#btn-submitt').remove();
    //     }
    //     // else{
    //     //     var csrfName = $('#csrf_pendaftaran').attr('name'); // CSRF Token name
    //     //     var csrfHash = $('#csrf_pendaftaran').val(); // CSRF hash
    //     //     $.ajax({
    //     //         data: {
    //     //             [csrfName]: csrfHash,
    //     //             waktu_awal: awal,
    //     //             waktu_akhir: sampai,
    //     //             nama: nama,
    //     //             surel: surel,
    //     //             telepon: telepon,
    //     //             no_ktp: ktp,
    //     //             pekerjaan: pekerjaan,
    //     //             no_rekening: no_rek,
    //     //             bank: bank,
    //     //             atas_nama: an,
    //     //             alamat: alamat,
    //     //             tanggal: tanggal,
    //     //         },
    //     //         url: 'pendaftaran/tambah',
    //     //         // headers:{'X-Requested-With': 'XMLHttpRequest'},
    //     //         method: "POST",
    //     //         success: function (data) {
    //     //         Swal.fire('Berhasil', 'Barang berhasil dimasukkan ke keranjang!', 'success');
    //     //         // $('#purgeall').remove();
    //     //         // $('#addhtml').html("<div class='col-lg-12 col-md-12 col-sm-12'><div class='card card-primary'><div class='card-header'><h4>Keranjang Kosong</h4></div><div class='card-body'><div class='empty-state' data-height='400'><div class='empty-state-icon bg-danger'><i class='ti-help'></i></div><h2>Anda tidak memiliki produk di keranjang</h2><p class='lead'>Silakan periksa daftar produk yang tersedia</p><a href='produk' class='btn btn-icon icon-left btn-primary mt-4'>Daftar produk</a></div></div></div></div>")
    //     //         //$('#ts_sampai').remove();
    //     //         // location.reload();
    //     //         }
    //     //      });
    //     // }
    // });

    if ($("#ts_awal").length) {
        $("#ts_awal").timepicker({
            defaultTime: false,
            minuteStep: 1,
            showMeridian: false,
            //template: 'dropdown',
            icons: {
                up: 'ti-angle-up',
                down: 'ti-angle-down'
            }
        });
    }


    if ($("#ts_sampai").length) {
        $("#ts_sampai").timepicker({
            defaultTime: false,
            minuteStep: 1,
            showMeridian: false,
            //template: 'dropdown',
            icons: {
                up: 'ti-angle-up',
                down: 'ti-angle-down'
            }
        });
    }

    $('table').on('click', '#tombolhapusk', function () {

        var kode = $(this).data("kode");
        $('#modalhapusk').modal('show');
        $('#btn-hapus-keranjang').attr("action", "kecohhapuskeranjanguser/" + kode);
        //$('#genre_id').val('');
        //$('#formGenre').trigger("reset");
        //$('#judulk').html("");
    });

    $('#tombolhapuskall').click(function () {

        $('#modalhapuskall').modal('show');

    });


});