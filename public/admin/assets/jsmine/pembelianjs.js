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

// const flashDataSalah = $('.errors').html();
// if (flashDataSalah) {

//    Swal.fire({
//       title: 'Gagal',
//       hideClass: {
//          popup: 'animate__animated animate__fadeOutUp animate__fast'
//       },
//       html: ' ' + flashDataSalah,
//       icon: 'error'
//    });

//    //$('#modalBuku').modal('show');
// }

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


$(document).ready(function () {





   $('#qty_barang').on("input change blur", function () {
      var qty = $(this).val();
      var stok = $('#qty3').val();
      var tampilan_stok = $('#qty2').text();
      var harga = $('#k_harga_barang').val();
      $('#harga_barang').val(harga * qty);
      $('#qty2').text(stok - qty);


      if(Number(qty) > Number(stok)){
         $('#tambah-keranjang').prop('disabled', true);
         iziToast.error({
            title: 'Gagal!',
            message: 'Jumlah barang melebihi stok!',
            position: 'topRight',
            toastOnce: true
         });
      }else{
         $('#tambah-keranjang').prop('disabled', false);
      }
   });


   $('#tambah-keranjang').click(function () {
      var qty = $('#qty_barang').val();
      var stok = $('#qty3').val();
      if(Number(qty) > Number(stok)){
         iziToast.error({
            title: 'Gagal!',
            message: 'Jumlah barang melebihi stok!',
            position: 'topRight',
            toastOnce: true
         });
         $(this).prop('disabled', true);
      }else{
         $('#tambah-keranjang').prop('disabled', false);
      }
     
   });

   $('#jumlah_uang').on("input change keyup", function () {
      
      var total = $('#total2').val();
      var jumuang = $('#jumlah_uang').val();
      var hsl = jumuang.replace(/[^\d]/g, "");
      //$('#jumlah_uang2').val(hsl);
      $('#kembalian').val(hsl - total);

      var kembalian = $('#kembalian').val();

      if (kembalian < 0) {
         $('#notif-kembalian').text('Kembalian kurang ' + (total - hsl));
      } else {
         $('#notif-kembalian').text('');
      }
   });




   $('#swal2-content ul li').css("color", "#dc3545");
   $('#pempem').DataTable({
      "lengthMenu": [
         [3, 5, 10, 20, -1],
         [3, 5, 10, 20, "All"]
      ],
   });

   

   $('#tombolPembelian').click(function () {

      var role_jenis_kasir = $(this).data("role_id_jenis_kasir");

      $('#modalPembelian').modal('show');
      $('.role_idE').val(role_jenis_kasir);

      // $.ajax({
      //    url: 'kasir/reset_csrf',
      //    method: "GET",
      //    data: '',
      //    headers: {
      //       'X-Requested-With': 'XMLHttpRequest'
      //    },
      //    dataType: 'json',
      //    success: function (res) {
      //       $('#csrf_jenis_kasir').val(res.csrf_hash);
      //       $('#csrf_kasir').val(res.csrf_hash);
      //       $('#csrf_detail_barang').val(res.csrf_hash);
      //       $('#csrf_detail_qr').val(res.csrf_hash);
      //       $('#csrf_keranjang').val(res.csrf_hash);
      //       $('#csrf_hapus_barang').val(res.csrf_hash);
      //       $('#csrf_hapus_keranjang').val(res.csrf_hash);

      //    }
      // });

   });

   function ajax_qr_barang(kode_barang) {
      var csrfName = $('#csrf_detail_qr').attr('name'); // CSRF Token name
      var csrfHash = $('#csrf_detail_qr').val(); // CSRF hash
      var jenkas = $('#jen_kas').val();

      $.ajax({
         url: 'kasir/tambah_keranjang_qr',
         data: {
            [csrfName]: csrfHash,
            qode_barang: kode_barang,
            jen_kas: jenkas,
         },
         headers: {
            'X-Requested-With': 'XMLHttpRequest'
         },
         method: "POST",
         dataType: 'json',
         success: function (res) {
            window.location.reload(true);
            // location.reload();

         }
      });
   }

   let scanner = new Instascan.Scanner({
      video: document.getElementById('preview')
   });
   scanner.addListener('scan', function (content) {
      $('#qode_barang').val(content);

      if ($('#qode_barang').val() == '') {
         iziToast.error({
            title: 'Gagal!',
            message: 'Kode barang tidak boleh kosong!',
            position: 'topRight'
         });

      } else {
         ajax_qr_barang(content);
         location.reload();
      }

   });

   Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {

         $('#kamera-nyala').click(function () {
            scanner.start(cameras[0]);
         });

         $('#kamera-mati').click(function () {
            scanner.stop();
         });

      } else {
         console.error('No cameras found.');
      }
   }).catch(function (e) {
      console.error(e);
   });

   $('.qode_barang').on("input", function () {
      if ($('#qode_barang').val() == '') {

         iziToast.error({
            title: 'Gagal!',
            message: 'Kode barang tidak boleh kosong!',
            position: 'topRight'
         });
      } else {
         var valkod = $('#qode_barang').val();
         ajax_kode_barang(valkod);
         

      }

   });

   


   function ajax_kode_barang(kode_barang) {
      var csrfName = $('#csrf_detail_barang').attr('name'); // CSRF Token name
      var csrfHash = $('#csrf_detail_barang').val(); // CSRF hash
      var jenkas = $('#jen_kas').val();

      $.ajax({
         url: 'kasir/ambil_barang',
         data: {
            [csrfName]: csrfHash,
            qode_barang: kode_barang,
            jen_kas: jenkas,

         },
         headers: {
            'X-Requested-With': 'XMLHttpRequest'
         },
         method: "POST",
         dataType: 'json',
         success: function (res) {

            if (res.data) {
               $('#id_barang').val(res.data.id_barang);
               $('#nama_barang').val(res.data.nama_barang);
               $('#nama_satuan').val(res.data.nama_satuan);
               $('#nama_merek').val(res.data.nama_merek);
               $('#harga_barang').val(res.data.harga);
               $('#k_harga_barang').val(res.data.harga);
               $('#qty2').text(res.data.stok_barang);
               $('#qty3').val(res.data.stok_barang);
               $('#qty_barang').attr('max', res.data.stok_barang);
               $('#csrf_detail_barang').val(res.csrf_hash);
               $('#csrf_jenis_kasir').val(res.csrf_hash);
               $('#csrf_hapus_barang').val(res.csrf_hash);
               $('#csrf_hapus_keranjang').val(res.csrf_hash);
               $('#csrf_keranjang').val(res.csrf_hash);
               $('#csrf_detail_qr').val(res.csrf_hash);
               $('#csrf_kasir').val(res.csrf_hash);
               $('#kode_salah').text('');
               iziToast.success({
                  title: 'Berhasil!',
                  message: 'Barang berhasil ditemukan!',
                  position: 'topRight',
                  // toastOnce: true
                  
               });
            } else {
               $('#kode_salah').text('Barang dengan kode tersebut tidak ada!');
               $('#csrf_jenis_kasir').val(res.csrf_hash);
               $('#csrf_kasir').val(res.csrf_hash);
               $('#csrf_detail_barang').val(res.csrf_hash);
               $('#csrf_detail_qr').val(res.csrf_hash);
               $('#csrf_keranjang').val(res.csrf_hash);
               $('#csrf_hapus_barang').val(res.csrf_hash);
               $('#csrf_hapus_keranjang').val(res.csrf_hash);
            }

         }
      });
   }

  

   $('table').on('click', '#tombolhapusk', function () {
      var kode = $(this).data("kode");
      $('#modalhapusk').modal('show');
      $('#kode_hapus_barang').val(kode);
     
   });


   $('#tombolhapuskalladmin').click(function () {

      $('#modalhapuskalladmin').modal('show');

   });



});