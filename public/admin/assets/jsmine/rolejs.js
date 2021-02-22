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


const flashDataSalah = $('.errors').html();

if (flashDataSalah) {

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

   $("#roro").DataTable();
         /*  When user click add user button */


   $('#tombolTambahRole').click(function () {
      $('#modalRole').modal('show');

   });

   $('table').on('click', '.edit-role', function () {
      var nama_role = $(this).data('role');
      var id_role = $(this).data('id');
      $('#modalEditRole').modal('show');
      $('#roleE').val(nama_role);
      $('#old_role').val(nama_role);
      $('#role_id').val(id_role);

   });

   $('table').on('click', '.hapus-role', function () {
      var id_role = $(this).data('id');
      $('#modalHapusRole').modal('show');
      $('#btn-simpan-hapus').attr("action", "role/kecohhapusrole/" + id_role);


   });
});