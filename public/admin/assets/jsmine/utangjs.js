const flashDataInvoice = $('.flash-data-invoice-utang-hapus').data('flashdata');
if (flashDataInvoice) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataInvoice,
      icon: 'success'
   });
}

const flashDataInvoiceSimpan = $('.flash-data-invoice-utang-simpan').data('flashdata');
if (flashDataInvoiceSimpan) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataInvoiceSimpan,
      icon: 'success'
   });
}



$(document).ready(function () {
   $("#utut").DataTable();
   //$('#swal2-content ul li').css("color", "#dc3545");


   // $('#tombolTambahKategori').click(function () {
   //    $('#modalTambahKategori').modal('show');
   // });

});


