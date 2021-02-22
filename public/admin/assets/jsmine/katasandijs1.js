const flashDataSalah = $('#flash-data-salah').data('flashdatasalah');
const flashDataSama = $('#flash-data-sama').data('flashdatasama');
const flashData = $('.flash-data').data('flashdata');


if (flashDataSalah) {
   Swal.fire({
      title: 'Gagal',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataSalah,
      icon: 'error'
   });

} else if (flashDataSama) {
   Swal.fire({
      title: 'Peringatan',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashDataSama,
      icon: 'warning'
   });
} else if (flashData) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashData,
      icon: 'success'
   });
}
