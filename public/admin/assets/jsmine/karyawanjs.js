

function previewImg() {
   const sampul = document.querySelector('#gambar');
   const sampulLabel = document.querySelector('.cass');
   const imgPrev = document.querySelector('.img-prev');

   sampulLabel.textContent = sampul.files[0].name;

   const fileSampul = new FileReader();

   fileSampul.readAsDataURL(sampul.files[0]);

   fileSampul.onload = function (e) {
      imgPrev.src = e.target.result;
   }
}

function previewImg1() {
   const sampul = document.querySelector('#edit_gambar');
   const sampulLabel = document.querySelector('.cuss');
   const imgPrev = document.querySelector('.img-prev1');

   sampulLabel.textContent = sampul.files[0].name;

   const fileSampul = new FileReader();

   fileSampul.readAsDataURL(sampul.files[0]);

   fileSampul.onload = function (e) {
      imgPrev.src = e.target.result;
   }
}


const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
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
   $('#role_id').select2();
   $('#edit_role_id').select2();

   $("#usus").DataTable();


   $('#status').click(function () {
      var cek = this.checked;
      if(cek == true){
         $(this).val(1);
      }
      if(cek == false){
         $(this).val('');
      }
   });

   $('#tombolTambahUser').click(function () {
      $('#modalKaryawan').modal('show');
      $('#role_id').select2({dropdownParent: $('#modalKaryawan')});
      

   });

   $('table').on('click','.tombolEditUser', function () {
      var id = $(this).data('id_user');
      var nama = $(this).data('nama');
      var email = $(this).data('email');
      var notel = $(this).data('telepon');
      var foto = $(this).data('gambar');
      var alamat = $(this).data('alamat');
      var status = $(this).data('is_active');
      var role = $(this).data('role_id');
      var getUrl = window.location;
      var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
      $('#imgE').attr("src", baseUrl + "/public/admin/assets/profile/" + foto);
      $('#img-labelE').text(foto);
      $('#edit_id_karyawan').val(id);
      $('#edit_name').val(nama);
      $('#edit_email').val(email);
      $('#edit_telepon').val(notel);
      $('#edit_alamat').val(alamat);
      $('#edit_role_id').val(role);
      $('#edit_gambar_lama').val(foto);

      if(status == 1){
         $('#edit_status').prop('checked', true).val(1);
      }

      if(status == 2){
         $('#edit_status').prop('checked', false).val('');
      }
      $('#modalKaryawanE').modal('show');
      $('#edit_role_id').select2({dropdownParent: $('#modalKaryawanE')});
   });

   $('#edit_status').click(function () {
      var cek = this.checked;

      if(cek == true){
         $(this).val(1);
      }

      if(cek == false){
         $(this).val('');
      }

   });

   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();
   if (validasi_tambah != 0) {
      $('#modalKaryawan').modal('show');
   }

   if (validasi_edit != 0) {
      $('#modalKaryawanE').modal('show');

      role_id = $('#old_role_id').val();
      gambar = $('#old_gambar').val();
      $('#edit_role_id').val(role_id);
      var getUrl = window.location;
      var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
      $('#imgE').attr("src", baseUrl + "/public/admin/assets/profile/" + gambar);
      $('#img-labelE').text(gambar);

      $('#edit_role_id').select2({
         dropdownParent: $('#modalKaryawanE'),
         tags: true
      });
   }


   $('table').on('click', '.tombolHapusUser', function () {

      var user_id = $(this).data("id_user");
      var gambar = $(this).data("gambar");
      $('#modalUserHapus').modal('show');
      $('#hapus_id_karyawan').val(user_id);
      $('#hapus_gambar').val(gambar);
   
   });
   $('#modalKaryawanE').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });

  
});
