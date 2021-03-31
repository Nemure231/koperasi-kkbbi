


const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
const flashData = $('.flash-data').data('flashdata');
const flashDataSalah = $('.satuan_error').html();

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
   $("#satsat").DataTable();

   $('#tombolTambahSatuan').click(function () {
      $('#modalTambahSatuan').modal('show');
      

   });

   
   $('table').on('click', '.tombolEditSatuan' ,function () {
      var id_satuan = $(this).data('id_satuan');
      var nama_satuan = $(this).data('nama_satuan');
      $('#modalEditSatuan').modal('show');
      $('#edit_nama_satuan').val(nama_satuan);
      $('#edit_id_satuan').val(id_satuan);
      
   });

   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();
   if(validasi_tambah != 0){
      $('#modalTambahSatuan').modal('show');
   }
   if(validasi_edit != 0){
      $('#modalEditSatuan').modal('show');
   }

   $('table').on('click', '.tombolHapusSatuan', function () {

      var id_satuan = $(this).data("id_satuan");
      $('#modalSatuanHapus').modal('show');
      $('#hapus_id_satuan').val(id_satuan);
   });

   $('#modalEditSatuan').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });


});


