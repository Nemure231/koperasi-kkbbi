$(document).ready(function () {

   
    $('#tbhts').click(function () {

        var awal = $('#ts_awal').val();
        var sampai = $('#ts_sampai').val();
        var kodet = $(this).data("kodet");

        if (awal == '') {
            Swal.fire({
                title: 'Gagal',
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__fast'
                },
                text: 'Awal tidak boleh kosong!',
                icon: 'error'
            });
            //$('#btn-submitt').addClass("disabled");
            //$('#btn-submitt').remove()
            //$('#heya').trigger('mouseleave').html("<button type='submit' id='btn-submitt' class='btn btn-primary'>Bayar</button>");
            // $('#heya').html("<a href='#' id='btn-submitt' class='btn text-light btn-primary'>Bayar</a>");


        } else if (sampai == '') {
            Swal.fire({
                title: 'Peringatan',
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__fast'
                },
                text: 'Sampai tidak boleh kosong',
                icon: 'warning'
            });
            //$('#btn-submitt').addClass("disabled");
           // $('#btn-submitt').remove();
            // $('#heya').html("<a href='#' id='btn-submitt' class='btn text-light btn-primary'>Bayar</a>");

        } else if (awal == sampai) {
            Swal.fire({
                title: 'Gagal',
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__fast'
                },
                text: 'Awal dan sampai tidak boleh sama!',
                icon: 'error'
            });
            // $('#btn-submitt').addClass("disabled");
            //$('#btn-submitt').remove();
            // $('#heya').html("<a href='#' id='btn-submitt' class='btn text-light btn-primary'>Bayar</a>");
        }else if (awal > sampai) {
            Swal.fire({
                title: 'Gagal',
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__fast'
                },
                text: 'Awal tidak boleh lebih besar dari sampai!',
                icon: 'error'
            });
            // $('#btn-submitt').addClass("disabled");
            //$('#btn-submitt').remove();
        }else{
            $.ajax({
                data: {
                   ts_awal: awal,
                   ts_sampai: sampai,
                   kode_transaksi: kodet
                },
                url: 'kecohtambahtransaksi',
                headers:{'X-Requested-With': 'XMLHttpRequest'},
                method: "POST",
                //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
                //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
                //bergitulah caranya agar dapat menjaalankan fungsi di controller
                //dataType: 'json',
                success: function (data) {
                Swal.fire('Berhasil', 'Barang berhasil dimasukkan ke keranjang!', 'success');
                $('#purgeall').remove();
                $('#addhtml').html("<div class='col-lg-12 col-md-12 col-sm-12'><div class='card card-primary'><div class='card-header'><h4>Keranjang Kosong</h4></div><div class='card-body'><div class='empty-state' data-height='400'><div class='empty-state-icon bg-danger'><i class='ti-help'></i></div><h2>Anda tidak memiliki produk di keranjang</h2><p class='lead'>Silakan periksa daftar produk yang tersedia</p><a href='produk' class='btn btn-icon icon-left btn-primary mt-4'>Daftar produk</a></div></div></div></div>")
                //$('#ts_sampai').remove();
                }
             });
        }
    });

    if ($("#ts_awal").length) {
        $("#ts_awal").timepicker({
            //defaultTime: 'value',
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
            //defaultTime: 'value',
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