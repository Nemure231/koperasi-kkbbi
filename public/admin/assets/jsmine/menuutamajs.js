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




$(document).ready(function () {
   $('#menu_id').select2({ tags: true });

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
      $('#edit_nama_menu_utama').val(nama_menu_utama);
      $('#edit_ikon_menu_utama').val(ikon);
      $('#edit_menu_id').val(menu_id);
      $('#edit_id_menu_utama').val(id);
      $('#edit_menu_id').select2({
         dropdownParent: $('#modalEditMenuUtama'),
         tags: true
      });

   });

   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();
   if (validasi_tambah != 0) {
      $('#modalMenuUtama').modal('show');
   }

   if (validasi_edit != 0) {
      $('#modalEditMenuUtama').modal('show');

         menu_id = $('#old_menu_id').val();
         $('#edit_menu_id').val(menu_id);


         $('#edit_menu_id').select2({
            dropdownParent: $('#modalEditMenuUtama'),
            tags: true
         });
   }

   $('table').on('click', '.hapus-menu-utama', function () {
      var id = $(this).data('id');
      $('#modalHapusMenuUtama').modal('show');
      $('#hapus_id_menu_utama').val(id);
   });

   $('#modalEditMenuUtama').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });
});
