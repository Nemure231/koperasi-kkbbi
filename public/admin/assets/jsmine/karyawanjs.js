

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


   $('.rum').on('click', function () {

      //$('#is_active').attr('name', 'is_active');
      if(this.checked){
         //$('#is_active').val('1');
         $('#is_active').attr('name', 'is_active');
         $('#is_active1').attr('name', '');
      }else{
         //$('#is_active1').val('2');
         $('#is_active1').attr('name', 'is_active');
         $('#is_active').attr('name', '');
      }
	});

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
      var foto = $(this).data('gambar');
      var alamat = $(this).data('alamat');
      var aktif = $(this).data('is_active');
      var role = $(this).data('role_id');
      $('#judulKaryawanE').html("Ubah Karyawan");
      $('#formEditKaryawan').attr("action", "toko/editkaryawan/" + id);
      $('#imgE').attr("src", "admin/assets/profile/" + foto);
      $('#img-labelE').text(foto);
      $('#user_id').val(id);
      $('#namaE').val(nama);
      $('#emailE').val(email);
      $('#teleponE').val(notel);
      $('#alamatE').val(alamat);
      $('#role_idE').val(role);
      $('#gambarE_lama').val(foto);
      //var bud = $('#is_activeE').val(aktif);

      if(aktif == 1){
         $('#is_activeE').attr("checked", "");
         $('#is_activeE').removeAttr("nuk");
         $('#is_activeE').attr('name', 'is_activeE');
         $('#is_activeE1').removeAttr('name');
      }else if(aktif == 2){
         $('#is_activeE').attr("nuk", "");
         $('#is_activeE').removeAttr("checked");
         $('#is_activeE1').attr('name', 'is_activeE');
         $('#is_activeE').removeAttr('name');
      }
      $('#modalKaryawanE').modal('show');
      $('#role_idE').select2({dropdownParent: $('#modalKaryawanE')});
   });

   $('.cekE').on('click', function () {

      //$('#is_active').attr('name', 'is_active');
      if(this.checked){
         $('#is_activeE').attr('name', 'is_activeE');
         $('#is_activeE1').attr('name', '');
      }else{
         //$('#is_active1').val('2');
         $('#is_activeE1').attr('name', 'is_activeE');
         $('#is_activeE').attr('name', '');
      }
   });
  

});


$('table').on('click', '#tombolHapusUser', function () {

   var user_id = $(this).data("id_user");

   $('#btn-simpan-hapus').attr("action", "toko/kecohhapuskaryawan/" + user_id);
   $('#judulUserHapus').html("");
   $('#modalUserHapus').modal('show');

});