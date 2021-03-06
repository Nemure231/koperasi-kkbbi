
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
      var nama_supplier = $(this).data('nama_supplier');
      $('#modalEditSupplier').modal('show');
      $('#edit_nama_supplier').val(nama_supplier);
      $('#old_nama_supplier').val(nama_supplier);
      $('#id_supplierE').val(id_supplier);
      
      
   });

   $('table').on('click', '.tombolHapusSupplier', function () {

      var id_supplier = $(this).data("id_supplier");

      $('#modalSupplierHapus').modal('show');
      $('#id_supplierH').val(id_supplier);
   
     
   });


});


