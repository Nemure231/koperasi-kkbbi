


const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
const flashData = $('.flash-data').data('flashdata');
const flashDataSalah = $('.kategori_error').html();

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
   $("#katkat").DataTable();

   $('#tombolTambahKategori').click(function () {
      $('#modalTambahKategori').modal('show');
   });

   
   $('table').on('click', '.tombolEditKategori' ,function () {
      var id_kategori = $(this).data('id_kategori');
      var nama_kategori = $(this).data('nama_kategori');
      $('#modalEditKategori').modal('show');
      $('#edit_nama_kategori').val(nama_kategori);
      $('#edit_id_kategori').val(id_kategori);
   });

   var validasi_tambah = $('.validasi_tambah').html();
      var validasi_edit = $('.validasi_edit').html();
      if(validasi_tambah != 0){
         $('#modalTambahKategori').modal('show');
      }
      if(validasi_edit != 0){
         $('#modalEditKategori').modal('show');
      }

   $('table').on('click', '.tombolHapusKategori', function () {

      var id_kategori = $(this).data("id_kategori");
      $('#modalKategoriHapus').modal('show');
      $('#hapus_id_kategori').val(id_kategori);
   });

   $('#modalEditKategori').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });


});


