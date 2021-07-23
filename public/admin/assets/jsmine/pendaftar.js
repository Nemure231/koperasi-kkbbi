const flashDataInvoice = $('.flash-data-invoice-utang-hapus').data('flashdata');
if (flashDataInvoice) {
   // Swal.fire({
   //    title: 'Berhasil',
   //    hideClass: {
   //       popup: 'animate__animated animate__fadeOutUp animate__fast'
   //    },
   //    text: ' ' + flashDataInvoice,
   //    icon: 'success'
   // });

   iziToast.success({
      title: 'Berhasil!',
      message: '' + flashDataInvoice,
      position: 'topRight',
      toastOnce: true
   });
}

const flashDataInvoiceSimpan = $('.flash-data-invoice-utang-simpan').data('flashdata');
if (flashDataInvoiceSimpan) {
   // Swal.fire({
   //    title: 'Berhasil',
   //    hideClass: {
   //       popup: 'animate__animated animate__fadeOutUp animate__fast'
   //    },
   //    text: ' ' + flashDataInvoiceSimpan,
   //    icon: 'success'
   // });

   iziToast.success({
      title: 'Berhasil!',
      message: '' + flashDataInvoiceSimpan,
      position: 'topRight',
      toastOnce: true
   });
}



$(document).ready(function () {
   $("#utut").DataTable();
   $('table').on('click', '.tombol-pendaftar', function () {
   var nama = $(this).data('nama');
   var telepon = $(this).data('telepon');
   var no_ktp = $(this).data('no_ktp');
   var surel = $(this).data('surel');
   var pekerjaan = $(this).data('pekerjaan');
   var no_rekening = $(this).data('no_rekening');
   var bank = $(this).data('bank');
   var atas_nama = $(this).data('atas_nama');
   var alamat = $(this).data('alamat');

   
   $('#nama').val(nama);
   $('#telepon').val(telepon);
   $('#no_ktp').val(no_ktp);
   $('#surel').val(surel);
   $('#pekerjaan').val(pekerjaan);
   $('#no_rekening').val(no_rekening);
   $('#bank').val(bank);
   $('#atas_nama').val(atas_nama);
   $('#alamat').val(alamat);
   $('#modal-pendaftar').modal('show');


   });

});


