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


$(document).ready(function () {
   $('#penyuplai_id').select2();
   
   $('#tombolhapusinvoice').click(function () {

      $('#modalhapusinvoice').modal('show');
   
   });

   // $('.vim').on('change keyup blur', '.persen', function () {

   $('#penyuplai_id').change(function () {
      var csrfName = $('#csrf_surel').attr('name'); // CSRF Token name
      var csrfHash = $('#csrf_surel').val(); // CSRF hash
      var penyuplai_id = $(this).val();

      $.ajax({
         url: 'ambil_surel',
         data: {
            [csrfName]: csrfHash,
            penyuplai_id: penyuplai_id,

         },
         headers: {
            'X-Requested-With': 'XMLHttpRequest'
         },
         method: "POST",
         dataType: 'json',
         success: function (res) {

            if (res.data) {
               $('#surel').val(res.data.surel);
               $('#csrf_surel').val(res.csrf_hash);
              
               iziToast.success({
                  title: 'Berhasil!',
                  message: 'Surel berhasil ditemukan!',
                  position: 'topRight',
                  // toastOnce: true

               });
            } else {
               $('#kode_salah').text('Barang dengan kode tersebut tidak ada!');
               $('#csrf_surel').val(res.csrf_hash);
            }

         }
      });
   });

   

});