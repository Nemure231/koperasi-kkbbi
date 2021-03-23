
const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
const flashData = $('.flash-data').data('flashdata');
const flashDataSalah = $('.supplier_error').html();

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


if (flashDataHapus) {

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
   $('#tombolTambahSupplier').click(function () {
      $('#modalTambahSupplier').modal('show');
   });

   
   $('table').on('click', '.tombolEditSupplier' ,function () {
      var id_supplier = $(this).data('id_supplier');
      var nama_supplier = $(this).data('nama_supplier');
      $('#modalEditSupplier').modal('show');
      $('#edit_nama_supplier').val(nama_supplier);
      $('#edit_id_supplier').val(id_supplier);
   });

   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();
   if(validasi_tambah != 0){
      $('#modalTambahSupplier').modal('show');
   }
   if(validasi_edit != 0){
      $('#modalEditSupplier').modal('show');
   }

   $('table').on('click', '.tombolHapusSupplier', function () {

      var id_supplier = $(this).data("id_supplier");

      $('#modalSupplierHapus').modal('show');
      $('#hapus_id_supplier').val(id_supplier);
   });

   $('#modalEditSuppier').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });


});


