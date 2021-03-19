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


const flashDataSalah = $('.menu_utama_error').html();

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
      $('#menu_id').select2({tags: true});
      $('#swal2-content ul li').css("color", "#dc3545");

      $("#table-menu-utama").DataTable();
      /*  When user click add user button */
      $('#tombolTambahMenuUtama').click(function () {
         $('#modalMenuUtama').modal('show');

      });


      $('table').on('click', '.edit-menu-utama', function () {
         var nama_menu_utama = $(this).data('nama-menu-utama');
         var id = $(this).data('id');
         var ikon = $(this).data('ikon-menu-utama');
         var menu_id = $(this).data('menu-id');
         $('#modalEditMenuUtama').modal('show');
         $('#nama_menu_utamaE').val(nama_menu_utama);
         $('#ikon_menu_utamaE').val(ikon);
         $('#menu_idE').val(menu_id);
         $('#old_nama_menu_utama').val(nama_menu_utama);
         $('#hidden_menu_utama_id').val(id);
         $('#menu_idE').select2({
            dropdownParent: $('#modalEditMenuUtama'),
            tags: true
         });
      
      });

      $('table').on('click', '.hapus-menu-utama', function () {
         var id = $(this).data('id');
         $('#modalHapusMenuUtama').modal('show');
         $('#hidden_hapus_menu_utama_id').val(id);

      
         


      });
   });
