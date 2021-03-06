


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
   
   //$('#modalBuku').modal('show');
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
   $("#satsat").DataTable();
   $('#swal2-content ul li').css("color", "#dc3545");

   // if ($("#formEditSatuan").length > 0) {
   //    $("#formEditSatuan").validate({

   //       rules: {
   //          edit_nama_satuan: {
   //             remote: {
   //                url: "uniksatuan",
   //                type: "post"
   //             }
   //          }
   //       },
   //       messages: {
   //          edit_nama_satuan: {
   //             remote: "Nama satuan sudah ada!",
   //          },
   //       },
   //    });
   // }

   $('#tombolTambahSatuan').click(function () {
      $('#modalTambahSatuan').modal('show');
      

   });

   
   $('table').on('click', '.tombolEditSatuan' ,function () {
      var id_satuan = $(this).data('id_satuan');
      var nama_satuan = $(this).data('nama_satuan');
      $('#modalEditSatuan').modal('show');
      $('#edit_nama_satuan').val(nama_satuan);
      $('#old_nama_satuan').val(nama_satuan);
      $('#id_satuanE').val(id_satuan);
      
   });

   // $('.edit_nama_satuan').on('change', function () {
   //    $('.edit_nama_satuan').rules('add', {remote: {
   //       url: "unikbuku",
   //       type: "post"
   //    }});
   // });

   $('table').on('click', '.tombolHapusSatuan', function () {

      var id_satuan = $(this).data("id_satuan");
      $('#modalSatuanHapus').modal('show');
      $('#id_satuanH').val(id_satuan);
      // $('#btn-simpan-hapus').attr("action", "kecohhapussatuan/" + id_satuan);
   
     
   });


});


