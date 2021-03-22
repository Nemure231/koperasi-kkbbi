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

   $("#roro").DataTable();
         /*  When user click add user button */


   $('#tombolTambahRole').click(function () {
      $('#modalRole').modal('show');

   });

   $('table').on('click', '.edit-role', function () {
      var nama_role = $(this).data('role');
      var id_role = $(this).data('id');
      $('#modalEditRole').modal('show');
      $('#edit_nama_role').val(nama_role);
      $('#edit_id_role').val(id_role);

   });

   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();
   if(validasi_tambah != 0){
      $('#modalRole').modal('show');
   }
   if(validasi_edit != 0){
      $('#modalEditRole').modal('show');
   }

   $('table').on('click', '.hapus-role', function () {
      var id_role = $(this).data('id');
      $('#modalHapusRole').modal('show');
      $('#hapus_id_role').val(id_role);
   });

   $('#modalEditRole').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });
});