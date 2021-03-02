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

const flashDataKR = $('.flash-data-kasir-retur').data('flashdata');
if (flashDataKR) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataKR,
      icon: 'success'
   });
}

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

const flashDataCecc = $('.flash-data-ceklis').data('flashdata');
if (flashDataCecc) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataCecc,
      icon: 'error'
   });
}

const flashDataKLik = $('.flash-data-klik').data('flashdata');
if (flashDataKLik) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataKLik,
      icon: 'error'
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

$(document).ready(function () {
   $('#swal2-content ul li').css("color", "#dc3545");
   


   var op = 0;
   $('.jik').on('click', '.tab-cus', function () {

      var qtyas =   $(this).parents('.par-tab').children('.td_qty_riwayat').find('.qty_riwayat').data("qtyriwayat");

      var valqty = $(this).parents('.par-tab').children('.td_qty_riwayat').find('.qty_riwayat').val();
     
      if (valqty > qtyas) {
         Swal.fire({
            title: 'Peringatan',
            hideClass: {
               popup: 'animate__animated animate__fadeOutUp animate__fast'
            },
            text: 'Jumlah yang dimasukkan melebihi pembelian sebelumnya!',
            icon: 'warning'
         });
         $(this).prop('checked', false);
      }else if(valqty == 0){
         Swal.fire({
            title: 'Peringatan',
            hideClass: {
               popup: 'animate__animated animate__fadeOutUp animate__fast'
            },
            text: 'Tidak boleh nol!',
            icon: 'error'
         });
         $(this).prop('checked', false);
      
   
      }else{

      if (this.checked) {
         $(this).parents('.par-tab').find('.barang_id_riwayat').prop('disabled', false);
         $(this).parents('.par-tab').children('.td_subtotal_riwayat').find('.subtotal_riwayat').prop('disabled', false);
         $(this).parents('.par-tab').children('.td_subtotal_riwayat').find('.subtotal_riwayat').addClass('bg-danger').addClass('text-white');
         $(this).parents('.par-tab').children('.td_qty_riwayat').find('.qty_riwayat').prop('readonly', true);
         //.prop('disabled', false);

         op += $(this).data('subtotal');
        

         $('.tab-total').val(op);
      

         var fake = $('.tab-total-fake').val();

         $('.tab-total-real').val(fake - op);
         $('.tab-kembalian').val(op - fake);
         $('.tab-total-bayar').val(fake - op);

         var nop = op - fake;
         var nepnep = fake - op;

         var com = $('.tab-kembalian').val();

         if(com >= 0){
            $('.jum-ung').prop('readonly', true);
         }


         if(nepnep < 0){
            $('.tab-total-bayar').val(0);

         }
         if(nop < 0 ){
      
            $('.tab-kembalian').val(0);

            $(function () {
               $('.jum-ung').on("input keyup", function () {
                  var total = $('.tab-total-bayar').val();
                  var jumuang = $('.jum-ung').val();
                  var hsl = jumuang.replace(/[^\d]/g, "");
                  

                  if((hsl - total) < 0 ){
                     $('.notif-kembalian').html(`<label class="text-danger not-kem">
                     Kembalian kurang!
                     </label>`);
                     $('.kem-ung').val(hsl - total);
                    
                  }else if ((hsl-total) >= 0 ){
                     $('.kem-ung').val(hsl - total);
                     $('.not-kem').attr('class', 'invisible text-danger');
                  }
                  
               });
         
            });
         }
       
      } else {
         $(this).parents('.par-tab').find('.barang_id_riwayat').prop('disabled', true);
         $(this).parents('.par-tab').children('.td_subtotal_riwayat').find('.subtotal_riwayat').removeClass('bg-danger').removeClass('text-white');
         $(this).parents('.par-tab').children('.td_subtotal_riwayat').find('.subtotal_riwayat').prop('disabled', true);
         $(this).parents('.par-tab').children('.td_qty_riwayat').find('.qty_riwayat').prop('readonly', false);
         
         var com = $('.tab-kembalian').val();

         if(com >= 0){
            $('.jum-ung').prop('readonly', false);
         }
      
         op -= $(this).data('subtotal');
      
         $('.tab-total').val(op);
         var fake =  $('.tab-total-fake').val();
         $('.tab-total-real').val(fake - op);
         $('.tab-kembalian').val(op - fake);

         // $('.tab-total-real').val(fake - op);
         // $('.tab-kembalian').val(op - fake);
         $('.tab-total-bayar').val(fake - op);

         var top  = fake - op; 
         if(top < 0){
            $('.tab-total-bayar').val(0);

         }

         var top1  = op - fake;
         if(top1 < 0){
            $('.tab-kembalian').val(0);

         }

         var kel =  $('.tab-total-bayar').val();
         if (kel >= 0){
            $('.jum-ung').prop('readonly', false);

         }
         


      
      }

      }



   });

   // $('table').on('mouseenter', '.td_qty_riwayat', function () {
   //    $(this).find('.qty_riwayat').prop('disabled', false);
   
   // });

   // $('table').on('blur', '.td_qty_riwayat', function () {
   //    $(this).find('.qty_riwayat').prop('disabled', true);
   
   // });

  //var apm = 0;
   $('table').on('input keyup', '.qty_riwayat', function () {
      var qty = $(this).val();
      var harga = $(this).parents('.par-tab').children('.td_harga_riwayat').find('.harga_riwayat').data('hargariwayat');
      $(this).parents('.par-tab').children('.tab-checkhar').children('.tabcom').find('.tab-mass').data('subtotal', qty * harga);
      $(this).parents('.par-tab').children('.td_subtotal_riwayat').find('.subtotal_riwayat').val(qty * harga);

     

   });

  

  

   $('#tombolTambahBarang').click(function () {
   
      $('#modalPembelian').modal('show');
      

   });

   $('#tombolTambahBarangSupplier').click(function () {
   
      $('#modalSupplier').modal('show');
      

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
            url: 'form/tambahkeranjangretur',
            //method: "POST",
            //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
            //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
            //bergitulah caranya agar dapat menjaalankan fungsi di controller
            data: {
               kr_barang_id: id_barang,
               kr_qty: qty,
               kr_harga: harga
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
      $('#btn-hapus-keranjang').attr("action", "form/kecohhapuskeranjangretur/" + kode);
      //$('#genre_id').val('');
      //$('#formGenre').trigger("reset");
      //$('#judulk').html("");
  });

  $('#tombolhapuskalladmin').click(function () {

   $('#modalhapuskalladmin').modal('show');

});





   $('#rere').DataTable({
      "lengthMenu": [
         [3, 5, 10, 20, -1],
         [3, 5, 10, 20, "All"]
      ],
   });

   $('#rere2').DataTable({
      "lengthMenu": [
         [3, 5, 10, 20, -1],
         [3, 5, 10, 20, "All"]
      ],
   });


   // $('#cari_transaksi').click(function () {

   //    var kode_transaksi = $('#kode_transaksi').val();

   //    $('#tampil_transaksi').html('');
   //    $('#tampil_total_transaksi').html('');
   //    $.ajax({
   //       url: 'form/ambilkodetransaksi',
   //       //method: "POST",
   //       //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
   //       //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
   //       //bergitulah caranya agar dapat menjaalankan fungsi di controller
   //       data: {
   //          kode_transaksi: kode_transaksi
   //       },
   //       headers: {
   //          'X-Requested-With': 'XMLHttpRequest'
   //       },
   //       type: "post",
   //       dataType: 'json',
   //       context: this,
   //       success: function (res) {
   //          if (res.response == true) {

   //             let kode = res.data;

   //             $.each(kode, function (i) {
   //                var k = i + 1;
   //                rules = [];
   //                rules1 = [];
   //                var nama = kode[i].nama_barang;
   //                var subtotal = kode[i].t_harga;
   //                var qty = kode[i].t_qty;
   //                var total = kode[i].tt_total_harga;
   //                var total_qty = kode[i].tt_total_qty;
   //                var id_barang = kode[i].t_barang_id;

   //                if(kode[i].tt_role_id == 4){
   //                   var harga =kode[i].harga_konsumen;

   //                }else if (kode[i].tt_role_id == 5){
   //                   var harga =kode[i].harga_anggota;

   //                }

   //                var tampil =
   //                   `<tr id="par-tab">
                     
   //                   <td>` + nama + `</td>
   //                   <td>` + harga + `</td>
   //                   <td>` + qty + `</td>
   //                   <td class="tab-subtotal">`+ subtotal+`</td>
   //                   <td>
   //                      <div class="custom-control custom-checkbox">
   //                         <input data-subtotal="`+subtotal+`" class="custom-control-input tab-cus" type="checkbox" id="customCheck`+id_barang+`">
   //                         <label class="custom-control-label" for="customCheck`+id_barang+`"><div class="invisible">l</div>
   //                         </label>
   //                       </div>
   //                   </td>
                     
   //                </tr>`;
   //                $('#tampil_transaksi').append(tampil);
   //                rules.push(total);
   //                rules1.push(total_qty);
   //             });

   //             var tampil2 = `<tr>
   //                <th colspan="2">Total</th>
   //                <th colspan="1" class="td-qty"></th>
   //                <th colspan="2"><input type="text" class="form-control tab-total" readonly></th>
   //                <th colspan="1"><th>
                 
   //              </tr>`;
   //             $('#tampil_total_transaksi').append(tampil2);

   //             $('#cari_transaksi').val('');
   //          } else {

   //             alert('errrrrrrr');

   //          }



   //       }
   //    });
   // });



});

