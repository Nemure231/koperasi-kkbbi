
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
   $("#mermer").DataTable();
   $('#swal2-content ul li').css("color", "#dc3545");


   $('#tombolTambahMerek').click(function () {
      $('#modalTambahMerek').modal('show');
      

   });

 
   
   $('table').on('click', '.tombolEditMerek' ,function () {
      var id_merek = $(this).data('id_merek');
      var nama_merek = $(this).data('nama_merek');
      $('#modalEditMerek').modal('show');
      $('#edit_nama_merek').val(nama_merek);
      $('#old_nama_merek').val(nama_merek);
      $('#id_merekE').val(id_merek);
      
      
   });

   $('.edit_nama_merek').on('change', function () {
      $('.edit_nama_merek').rules('add', {remote: {
         url: "unikbuku",
         type: "post"
      }});
   });

   $('table').on('click', '.tombolHapusMerek', function () {

      var id_merek = $(this).data("id_merek");
      $('#modalMerekHapus').modal('show');
      $('#id_merekH').val(id_merek);
   
     
   });


});


