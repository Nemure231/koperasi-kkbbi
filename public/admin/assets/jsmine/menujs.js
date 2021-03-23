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

      $("#meme").DataTable();
      $('#tombolTambahMenu').click(function () {
         $('#modalMenu').modal('show');

      });
  

      $('table').on('click', '.edit-menu', function () {
         var nama_menu = $(this).data('menu');
         var id_menu = $(this).data('id');
         $('#modalEditMenu').modal('show');
         $('#edit_nama_menu').val(nama_menu);
         $('#edit_id_menu').val(id_menu);
      
      });

      var validasi_tambah = $('.validasi_tambah').html();
      var validasi_edit = $('.validasi_edit').html();
      if(validasi_tambah != 0){
         $('#modalMenu').modal('show');
      }
      if(validasi_edit != 0){
         $('#modalEditMenu').modal('show');
      }

      $('table').on('click', '.hapus-menu', function () {
         var id_menu = $(this).data('id');
         $('#modalHapusMenu').modal('show');
         $('#hapus_id_menu').val(id_menu);
      });

      $('#modalEditMenu').on('hidden.bs.modal', function (event) {
         $('.hapus-validasi').remove('invalid-feedback');
         $('.hapus-validasi-border').removeClass('is-invalid');
      });
   });
