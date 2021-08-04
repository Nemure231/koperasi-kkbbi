const sukses = $('#pengajuan-sukses').data('flashdata');
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

   $('table').on('click', '.tombol-detail', function () {
      var nama_barang = $(this).data('nama_barang');
      var nama_kategori = $(this).data('nama_kategori');
      var nama_satuan = $(this).data('nama_satuan');
      var nama_merek = $(this).data('nama_merek');
      var jumlah = $(this).data('jumlah');
      var harga_pokok = $(this).data('harga_pokok');
      var harga_anggota = $(this).data('harga_anggota');
      var harga_konsumen = $(this).data('harga_konsumen');
      var deskripsi = $(this).data('deskripsi');
      // var getUrl = window.location;
      // var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
      // var nama_gambar = $(this).data('nama_gambar');

      $('#nama_barang').val(nama_barang);
      $('#nama_kategori').val(nama_kategori);
      $('#nama_satuan').val(nama_satuan);
      $('#nama_merek').val(nama_merek);
      $('#jumlah').val(jumlah);
      $('#harga_pokok').val(harga_pokok);
      $('#harga_anggota').val(harga_anggota);
      $('#harga_konsumen').val(harga_konsumen);
      $('#deskripsi').val(deskripsi);
      // $('#gambar').attr("src", baseUrl + "/public/admin/assets/barang/" + nama_gambar);
      // $('#gambar-href').attr("href", baseUrl + "/public/admin/assets/barang/" + nama_gambar);
      $('#modal-detail').modal('show');


   });

   $('table').on('click', '.tombol-tolak', function () {
      var id_pengajuan = $(this).data('id_pengajuan');
      var id_penyuplai = $(this).data('id_penyuplai');
      var alasan = $(this).data('alasan');
      var kode = $(this).data('kode_pengajuan');
      var id_barang = $(this).data('id_barang');
      var id_barang_masuk= $(this).data('id_barang_masuk');
      $('#kode_pengajuan_tolak').val(kode);
      $('#id_pengajuan_tolak').val(id_pengajuan);
      $('#id_penyuplai_tolak').val(id_penyuplai);
      $('#alasan').attr('placeholder', alasan);
      $('#id_barang_tolak').val(id_barang);
      $('#modal-tolak').modal('show');

   });


   $('table').on('click', '.tombol-terima', function () {
      var id_pengajuan = $(this).data('id_pengajuan');
      var id_penyuplai = $(this).data('id_penyuplai');
      var kode = $(this).data('kode_pengajuan');
     
      
      
      $('#id_pengajuan').val(id_pengajuan);
      $('#kode_pengajuan_terima').val(kode);
      $('#id_penyuplai_terima').val(id_penyuplai);
      $('#modal-terima').modal('show');


   });

   $('table').on('click', '.tombol-konfirm', function () {
      var id_barang = $(this).data('id_barang');
      var id_barang_masuk= $(this).data('id_barang_masuk');
      var stok= $(this).data('stok');
      var id_penyuplai = $(this).data('id_penyuplai');
      var id_pengajuan = $(this).data('id_pengajuan');
      var kode = $(this).data('kode_pengajuan');
      
      $('#id_barang').val(id_barang);
      $('#kode_pengajuan_konfirm').val(kode);
      $('#id_barang_masuk').val(id_barang_masuk);
      $('#id_penyuplai_konfirm').val(id_penyuplai);
      $('#id_pengajuan_konfirm').val(id_pengajuan);
      $('#stok').val(stok);
      $('#modal-konfirm').modal('show');

   });

});


