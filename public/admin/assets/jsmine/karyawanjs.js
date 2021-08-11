

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
   const sampul = document.querySelector('#gambarE');
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
   $('#role_id').select2();
   $('#role_idE').select2();

   $("#usus").DataTable();
   $('#swal2-content ul li').css("color", "#dc3545");

   $('#tombolTambahUser').click(function () {
      $('#judulKaryawan').html("Tambah Karyawan");
      $('#modalKaryawan').modal('show');
      $('#role_id').select2({dropdownParent: $('#modalKaryawan')});
      
   });

   //GET UPDATE
   $('table').on('click','.tombolEditUser', function () {
      var id = $(this).data('id_user');
      var nama = $(this).data('nama');
      var email = $(this).data('email');
      var notel = $(this).data('telepon');
      var alamat = $(this).data('alamat')
      var aktif = $(this).data('is_active');
      var role = $(this).data('role_id');
      $('#judulKaryawanE').html("Ubah Karyawan");
      $('#user_id').val(id);
      $('#namaE').val(nama);
      $('#emailE').val(email);
      $('#teleponE').val(notel);
      $('#alamatE').val(alamat);
      $('#role_idE').val(role);
   


      if(aktif == 1){
         $('#is_activeE').prop("checked", true);

      }else if(aktif == 2){
         $('#is_activeE').prop("checked", false);
      }
      $('#modalKaryawanE').modal('show');
      $('#role_idE').select2({dropdownParent: $('#modalKaryawanE')});
   });



});


$('table').on('click', '.tombolHapusUser', function () {

   var user_id = $(this).data("id_user");
   $('#modalUserHapus').modal('show');
   $('#hidden_id_user').val(user_id);

});