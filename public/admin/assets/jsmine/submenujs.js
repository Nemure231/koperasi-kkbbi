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

   $('#menu_id').select2({tags: true});

   $('#menu_utama_id').select2({tags: true});

   $("#table-1").DataTable();

   $('#tombolTambahSubMenu').click(function () {
      $('#modalSubMenu').modal('show');

      $('#status_submenu').click(function () {
         var cek = this.checked;
         if(cek == true){
            $(this).val(1);
         }
         if(cek == false){
            $(this).val('');
         }
   
      });

   });

   $('table').on('click', '.edit-submenu', function () {
      var submenu_id = $(this).data("id");
      var nama = $(this).data("judul");
      var url = $(this).data("url");
      var menu_id = $(this).data("menu_id");
      var menu_utama_id = $(this).data("menu_utama_id");
      var ikon = $(this).data("icon");
      var status = $(this).data("is_active");
      $('#modalEditSubMenu').modal('show');
      $('#edit_id_submenu').val(submenu_id);
      $('#edit_nama_submenu').val(nama);
      $('#edit_menu_id').val(menu_id);
      $('#edit_menu_utama_id').val(menu_utama_id);
      $('#edit_url_submenu').val(url);
      $('#edit_ikon_submenu').val(ikon);
      $('#edit_status_submenu').val(status);
      $('#edit_menu_id').select2({
         dropdownParent: $('#modalEditSubMenu'),
         tags: true
      });
      $('#edit_menu_utama_id').select2({
         dropdownParent: $('#modalEditSubMenu'),
         tags: true
      });

      if(status == 1){
         $('#edit_status_submenu').prop('checked', true);
      }
   });


   $('#edit_status_submenu').click(function () {
      var cek = this.checked;
      
      if(cek == true){
         $(this).val(1);
      }

      if(cek == false){
         $(this).val('');
      }

   });


   $('table').on('click', '.hapus-submenu', function () {
      var id_submenu = $(this).data('id');
      $('#modalHapusSubMenu').modal('show');
      $('#hapus_id_submenu').val(id_submenu);
   });

   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();

   if(validasi_tambah != 0){
      $('#modalSubMenu').modal('show');
   }

   if(validasi_edit != 0){
      $('#modalEditSubMenu').modal('show');

         menu_utama_id = $('#old_menu_utama_id').val();
         menu_id = $('#old_menu_id').val();
         status_submenu = $('#old_status_submenu').val();
         $('#edit_menu_id').val(menu_id);
         $('#edit_menu_utama_id').val(menu_utama_id);
         $('#edit_status_submenu').val(status_submenu);

         if(status_submenu == 1){
            $('#edit_status_submenu').prop('checked', true).val(1);
         }

         if(status_submenu == 2){
            $('#edit_status_submenu').prop('checked', false).val('');
         }
   
         $('#edit_menu_id').select2({
            dropdownParent: $('#modalEditSubMenu'),
            tags: true
         });
         $('#edit_menu_utama_id').select2({
            dropdownParent: $('#modalEditSubMenu'),
            tags: true
         });
   }


   $('#modalEditSubMenu').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
      $('#edit_status_submenu').prop('checked', false);
   });

});
