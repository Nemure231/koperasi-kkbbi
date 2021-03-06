const flashData = $('.flash-data').data('flashdata');
if (flashData) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashData,
      icon: 'success'
   });
}

const flashDataJK = $('.flash-data-jeniskasir').data('flashdata');
if (flashDataJK) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataJK,
      icon: 'success'
   });
   $('#modalPembelian').modal('show');
  
}

const flashDataHKA = $('.flash-data-hapus-keranjang-admin').data('flashdata');
if (flashDataHKA) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataHKA,
      icon: 'success'
   });
}

const flashDataHKALL = $('.flash-data-hapus-all-keranjang-admin').data('flashdata');
if (flashDataHKALL) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataHKALL,
      icon: 'success'
   });
}

const flashDataSalah = $('.errors').html();
if (flashDataSalah) {

   Swal.fire({
      title: 'Gagal',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      html: ' ' + flashDataSalah,
      icon: 'error'
   });
   
   //$('#modalBuku').modal('show');
}

const flashDataTran = $('.flash-data-transaksi').data('flashdata');
if (flashDataTran) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataTran,
      icon: 'success'
   });
}

const flashDataInvoice = $('.flash-data-invoice').data('flashdata');
if (flashDataInvoice) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataInvoice,
      icon: 'success'
   });
}

const flashDataUtang = $('.flash-data-utang').data('flashdata');
if (flashDataUtang) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataUtang,
      icon: 'success',
      footer: '<a href="kasir/utang">Lihat daftar utang.</a>'
   });
}


$(document).ready(function () {


   $('.heh').on('mouseenter', '.btn-ngutang', function () {

      var telepon = $('.nomor_telepon_hutang').val();
      var nama = $('.nama_penghutang').val();

      if(nama == '' || telepon == ''){
       
         $('#btn-simpan').prop('disabled', true);
         $('#err-npht').text('Nama harus diisi');
         $('#err-thph').text('Nomor telepon harus diisi!');
      }else if(nama || telepon){
         $('#btn-simpan').prop('disabled', false);
         $('#err-npht').text('');
         $('#err-thph').text('');
      }
      
      if (telepon <= 0) {
      
         $('#err-thph').text('Nomor telepon tidak boleh minus atau nol!');
         $('#btn-simpan').prop('disabled', true);
        
      }else if (isNaN(telepon)) {
      
         $('#err-thph').text('Nomor telepon harus angka!');
         $('#btn-simpan').prop('disabled', true);
        
      }

   });

   $('.nuk').on('change', '.ngutang', function () {
      if (this.checked) {
        // $('#btn-simpan').prop('disabled', true);
         $('#btn-simpan').addClass('btn-ngutang');
         $('#nomor_telepon_hutang').addClass('nomor_telepon_hutang');
         $('#nama_penghutang').addClass('nama_penghutang');
         $('.btn-ngutang').attr('formnovalidate', '');
         $('#jumlah_uang').prop('readonly', true);
         $('#nomor_telepon_hutang').prop('readonly', false);
         $('#nama_penghutang').prop('readonly', false);
        // $('#kembalian').prop('disabled', true);
         $('#jumlah_uang').val(0);
         $('#kembalian').val(0);
        
        
      } else {
         $('#btn-simpan').removeClass('btn-ngutang');
         $('#nomor_telepon_hutang').removeClass('nomor_telepon_hutang');
         $('#nama_penghutang').removeClass('nama_penghutang');
         $('#nomor_telepon_hutang').val(0);
         $('#nama_penghutang').val('');
         $('#err-thph').text('');
         $('#err-npht').text('');
         $('#btn-simpan').prop('disabled', false);
         //$('#btn-simpan').prop('disabled', false);
         $('#jumlah_uang').prop('readonly', false);
         //$('#kembalian').prop('disabled', false);
         $('.btn-ngutang').removeAttr('formnovalidate');
         $('#nomor_telepon_hutang').prop('readonly', true);
         $('#nama_penghutang').prop('readonly', true);
         $('#jumlah_uang').val('');
         $('#kembalian').val('');
         $('#nomor_telepon_hutang').val('');
        
      }
    });
   
   //  $.validator.addMethod("notEqual", function(value, element, param){
   //     return this.optional(element) || parseInt(value) > 0;
   //  })

   $("#formPembelian").validate({
      rules: {
          jumlah_uang: {
              number: true,
              required: true,
              //notEqual: '0',
              normalizer: function (value) {
                  return $.trim(value);
              },
          },
          kembalian: {
              min: 0,
              number: true,
              required: true,
              normalizer: function (value) {
                  return $.trim(value);
              },
          }
      },
      messages: {
          jumlah_uang: {
              required: "Harus diisi!",
              //notEqual: "Tidak boleh nol atau minus!",
              number: "Harus angka!"
          },
          kembalian: {
              required: "Harus diisi!",
              number: "Harus angka!",
              min: "Kembalian kurang!"
              //minlength: "Terlalu pendek, kata sandi yang anda daftarkan sebelumnya memiliki 6 huruf atau lebih!"
          },
          
      },
  });



   $(function () {
		$('#jumlah_uang').on("input change keyup", function () {
			var total = $('#total2').text();
			var jumuang = $('#jumlah_uang').val();
			var hsl = jumuang.replace(/[^\d]/g, "");
			//$('#jumlah_uang2').val(hsl);
         var kem = $('#kembalian').val(hsl - total);

         var kembalian = $('#kembalian').val();

         if(kembalian < 0){
            $('#notif-kembalian').text('Kembalian kurang ' + (total - hsl) );
         }else{
            $('#notif-kembalian').text('');
         }





         
		})

   });



   $('#swal2-content ul li').css("color", "#dc3545");

   // var role_id_jenis_kasir = $('idjk').data("role_id_jenis_kasir")
   // $('.role_idE').val(role_id_jenis_kasir);


   $('#pempem').DataTable({
      "lengthMenu": [
         [3, 5, 10, 20, -1],
         [3, 5, 10, 20, "All"]
      ],
      // responsive: true,
      // paging: false,
      // "scrollY": 200,
      // "scrollX": 300,
   });


   $('#tombolPembelian').click(function () {
      var role_jenis_kasir = $(this).data("role_id_jenis_kasir");
      $('#modalPembelian').modal('show');
      $('.role_idE').val(role_jenis_kasir);

   });

   $('table').on('click', '.tambah-keranjang', function () {

      var id_barang = $(this).data("id_barang");
      var qty = $('#qty_barang'+ id_barang).val();
      var stok = $(this).data("stok_barang");
      var harga = $(this).data("harga_barang");
      //var role_id = $('#idjk').data("role_id_jenis_kasir");

      // var qty2 = $('#qty_barang' +id_barang).text().replace('-', '');
      // $('#qty_barang' +id_barang).text(qty2);
     

     // var qty = $('#qty_barang'+ id_barang).val();
    if (qty > stok) {
      Swal.fire({
         title: 'Peringatan',
         hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__fast'
         },
         text: 'Jumlah yang dimasukkan melebihi stok!',
         icon: 'warning'
      });
      }else if (qty == '') {
         Swal.fire({
            title: 'Gagal',
            hideClass: {
               popup: 'animate__animated animate__fadeOutUp animate__fast'
            },
            text: 'Kuantitas tidak boleh kosong!',
            icon: 'error'
         });

      } else if (qty == 0) {
         Swal.fire({
            title: 'Gagal',
            hideClass: {
               popup: 'animate__animated animate__fadeOutUp animate__fast'
            },
            text: 'Kuantitas yang dimasukkan tidak boleh nol!',
            icon: 'error'
         });

      } else {
         $.ajax({
            url: 'kasir/tambah_keranjang',
            //method: "POST",
            //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
            //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
            //bergitulah caranya agar dapat menjaalankan fungsi di controller
            data: {
               k_barang_id: id_barang,
               k_qty: qty,
               k_harga: harga
               //k_role_id: role_id

            },
            headers: {
               'X-Requested-With': 'XMLHttpRequest'
            },
            type: "POST",
            dataType: 'json',
            success: function (res) {

               location.reload();



            }
         });
      }
   });

   $('table').on('click', '#tombolhapusk', function () {
      var kode = $(this).data("kode");
      $('#modalhapusk').modal('show');
      $('#kode_hapus_barang').val(kode);
      // $('#btn-hapus-keranjang').attr("action", "kasir/kecohhapuskeranjangadmin/" + kode);
      //$('#genre_id').val('');
      //$('#formGenre').trigger("reset");
      //$('#judulk').html("");
  });
  

  $('#tombolhapuskalladmin').click(function () {

   $('#modalhapuskalladmin').modal('show');

});



});