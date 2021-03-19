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

const flashDataEdit = $('.flash-data-edit').data('flashdata');

if (flashDataEdit) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataEdit,
      icon: 'success'
   });

}

const flashDataHapus = $('.flash-data-hapus').data('flashdata');

if (flashDataHapus) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataHapus,
      icon: 'success'
   });

}


const flashDataSalah = $('.menu_error').html();

if (flashDataSalah != 0) {

   Swal.fire({
      title: 'Gagal',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      html: ' ' + flashDataSalah,
      icon: 'error'
   });
}

   $(document).ready(function () {
      $('#swal2-content ul li').css("color", "#dc3545");

      $("#meme").DataTable();
      /*  When user click add user button */
      $('#tombolTambahMenu').click(function () {
         $('#modalMenu').modal('show');

      });
   });
     

   /* When click edit user */

   $('table').on('click', '.edit-menu', function () {
      var nama_menu = $(this).data('menu');
      var id_menu = $(this).data('id');
      $('#modalEditMenu').modal('show');
      $('#menuE').val(nama_menu);
      $('#old_menu').val(nama_menu);
      $('#hidden_menu_id').val(id_menu);
     
   });

   $('table').on('click', '.hapus-menu', function () {
      var id_menu = $(this).data('id');
      $('#modalHapusMenu').modal('show');
      $('#hidden_hapus_menu_id').val(id_menu);

     
      


   });
