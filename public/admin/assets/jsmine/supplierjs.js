
const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
const flashData = $('.flash-data').data('flashdata');
const flashDataSalah = $('.errors').html();

if (flashData) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashData,
      icon: 'success'
   });

} else if (flashDataSalah) {

   Swal.fire({
      title: 'Gagal',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      html: ' ' + flashDataSalah,
      icon: 'error'
   });
   
   //$('#modalBuku').modal('show');
} else if (flashDataHapus) {

   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      html: ' ' + flashDataHapus,
      icon: 'success'
   });
}


$(document).ready(function () {
   $("#supsup").DataTable();
   $('#swal2-content ul li').css("color", "#dc3545");


   $('#tombolTambahSupplier').click(function () {
      $('#modalTambahSupplier').modal('show');
      

   });

   
   $('table').on('click', '.tombolEditSupplier' ,function () {
      var id_supplier = $(this).data('id_supplier');
      var id_user = $(this).data('id_user');
      var nama_supplier = $(this).data('nama_supplier');
      var telepon = $(this).data('telepon');
      var surel = $(this).data('surel');
      var pekerjaan = $(this).data('pekerjaan');
      var ktp = $(this).data('no_ktp');
      var bank = $(this).data('bank');
      var atas_nama = $(this).data('atas_nama');
      var rekening = $(this).data('no_rekening');
      var status = $(this).data('status');
      var alamat = $(this).data('alamat');
      $('#old_nama_supplier').val(nama_supplier);
      $('#id_supplierE').val(id_supplier);
      $('#edit_nama').val(nama_supplier);
      $('#edit_telepon').val(telepon);
      $('#edit_surel').val(surel);
      $('#edit_pekerjaan').val(pekerjaan);
      $('#edit_no_ktp').val(ktp);
      $('#edit_bank').val(bank);
      $('#edit_atas_nama').val(atas_nama);
      $('#edit_alamat').val(alamat);
      $('#edit_no_rekening').val(rekening);
      $('#edit_id_user').val(id_user);
      $('#modalEditSupplier').modal('show');

      if(status == 1){
         $('#edit_status').prop("checked", true);
         // $('#is_activeE').removeAttr("nuk");
         // $('#is_activeE').attr('name', 'is_activeE');
         // $('#is_activeE1').removeAttr('name');
      }
      if(status == 2){
         $('#edit_status').prop("checked", false);
         // $('#is_activeE').removeAttr("checked");
         // $('#is_activeE1').attr('name', 'is_activeE');
         // $('#is_activeE').removeAttr('name');
      }
      
      
   });

   $('table').on('click', '.tombolHapusSupplier', function () {

      var id_supplier = $(this).data("id_supplier");

      $('#modalSupplierHapus').modal('show');
      $('#id_supplierH').val(id_supplier);
   
     
   });


});


