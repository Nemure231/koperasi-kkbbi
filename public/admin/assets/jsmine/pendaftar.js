const flashDataInvoice = $('.flash-data-invoice-utang-hapus').data('flashdata');
if (flashDataInvoice) {
   

   iziToast.success({
      title: 'Berhasil!',
      message: '' + flashDataInvoice,
      position: 'topRight',
      toastOnce: true
   });
}

const sukses = $('#pendaftaran-sukses').data('flashdata');
if (sukses) {

   iziToast.success({
      title: 'Berhasil!',
      message: '' + sukses,
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

   $('table').on('click', '.tombol-konfirm', function () {
      var id_user = $(this).data('id_user');
      var id_penyuplai = $(this).data('id_penyuplai');

      
      $('#id_user').val(id_user);
      $('#id_penyuplai').val(id_penyuplai);
      $('#modal-konfirm').modal('show');


   });


   $('table').on('click', '.tombol-beritahu', function () {
      var id_user = $(this).data('id_user');
      var id_penyuplai = $(this).data('id_penyuplai');

      
      $('#id_user_beritahu').val(id_user);
      $('#id_penyuplai_beritahu').val(id_penyuplai);
      $('#modal-beritahu').modal('show');


   });

});


