


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

if (flashDataSalah != 0) {

   Swal.fire({
      title: 'Gagal',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      html: ' ' + flashDataSalah,
      icon: 'error'
   });
   
   //$('#modalBuku').modal('show');
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
   $('#swal2-content ul li').css("color", "#dc3545");


   $('#tombolTambahKategori').click(function () {
      $('#modalTambahKategori').modal('show');
   });

   
   $('table').on('click', '.tombolEditKategori' ,function () {
      var id_kategori = $(this).data('id_kategori');
      var nama_kategori = $(this).data('nama_kategori');
      //var kode_kategori = $(this).data('kode_kategori');
      $('#modalEditKategori').modal('show');
      $('#edit_nama_kategori').val(nama_kategori);
      //$('#edit_kode_kategori').val(kode_kategori);
      $('#id_kategoriE').val(id_kategori);
      $('#old_nama_kategori').val(nama_kategori);
      //$('#old_kode_kategori').val(kode_kategori);
      
      
   });

   $('.edit_nama_kategori').on('change', function () {
      $('.edit_nama_kategori').rules('add', {remote: {
         url: "unikbuku",
         type: "post"
      }});
   });

   $('table').on('click', '.tombolHapusKategori', function () {

      var id_kategori = $(this).data("id_kategori");
      
      // $('#btn-simpan-hapus').attr("action", "kecohhapuskategori/" + id_kategori);
      $('#modalKategoriHapus').modal('show');
      $('#id_kategoriH').val(id_kategori);
   
     
   });


});


