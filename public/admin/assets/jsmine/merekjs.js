
const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
const flashData = $('.flash-data').data('flashdata');
const flashDataSalah = $('.merek_error').html();

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
   $("#mermer").DataTable();

   $('#tombolTambahMerek').click(function () {
      $('#modalTambahMerek').modal('show');      
   });

   
   $('table').on('click', '.tombolEditMerek' ,function () {
      var id_merek = $(this).data('id_merek');
      var nama_merek = $(this).data('nama_merek');
      $('#modalEditMerek').modal('show');
      $('#edit_nama_merek').val(nama_merek);
      $('#edit_id_merek').val(id_merek);
   });

   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();
   if(validasi_tambah != 0){
      $('#modalTambahMerek').modal('show');
   }
   if(validasi_edit != 0){
      $('#modalEditMerek').modal('show');
   }

   $('table').on('click', '.tombolHapusMerek', function () {

      var id_merek = $(this).data("id_merek");
      $('#modalMerekHapus').modal('show');
      $('#hapus_id_merek').val(id_merek);
   });

   $('#modalEditMerek').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });


});


