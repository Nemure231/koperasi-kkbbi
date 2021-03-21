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


// const flashDataSalah = $('.submenu_error').html();

// if (flashDataSalah != 0) {

//    Swal.fire({
//       title: 'Gagal',
//       hideClass: {
//          popup: 'animate__animated animate__fadeOutUp animate__fast'
//       },
//       html: ' ' + flashDataSalah,
//       icon: 'error'
//    });
// }

$(document).ready(function () {

   $('#menu_id').select2({tags: true});

   $('#menu_utama_id').select2({tags: true});

   $('#swal2-content ul li').css("color", "#dc3545");

   $("#table-1").DataTable();

   $('#tombolTambahSubMenu').click(function () {
      $('#modalSubMenu').modal('show');

   });

   $('table').on('click', '.edit-submenu', function () {
      var submenu_id = $(this).data("id");
      var judul = $(this).data("judul");
      var url = $(this).data("url");
      var menu_id = $(this).data("menu_id");
      var menu_utama_id = $(this).data("menu_utama_id");
      var icon = $(this).data("icon");
      var is_active = $(this).data("is_active");
      $('#modalEditSubMenu').modal('show');
      $('#submenu_id').val(submenu_id);
      $('#judul_old').val(judul);
      $('#url_old').val(url);
      $('#judulE').val(judul);
      $('#menu_idE').val(menu_id);
      $('#menu_utama_idE').val(menu_utama_id);
      $('#urlE').val(url);
      $('#iconE').val(icon);
      $('#is_activeE').val(is_active);
      $('#is_activeE').prop('checked', false);
      $('#menu_idE').select2({
         dropdownParent: $('#modalEditSubMenu'),
         tags: true
      });
      $('#menu_utama_idE').select2({
         dropdownParent: $('#modalEditSubMenu'),
         tags: true
      });

      if(is_active == 1){
         $('#is_activeE').prop('checked', true);
      }
   });

   $('.is_activeE').click(function () {
      var cek = this.checked;
      
      if(cek == true){
         $('#is_activeE').val(1);
      }

      if(cek == false){
         $('#is_activeE').val(2);
      }

   });


   $('table').on('click', '.hapus-submenu', function () {
      var id_submenu = $(this).data('id');
      $('#modalHapusSubMenu').modal('show');
      $('#hidden_hapus_id_submenu').val(id_submenu);
      // $('#btn-simpan-hapus').attr("action", "kecohhapussubmenu/" + id_submenu);

   });


   var validasi = $('.submenu_error').html();

   if(validasi != 0){
      $('#modalSubMenu').modal('show');
   }

});
