
$(document).ready(function () {

    $("#tabel-pengajuan").DataTable();

    $('table').on('click', '.tombol-detail-pengajuan', function () {
       var nama = $(this).data('nama_barang');
       var jumlah = $(this).data('jumlah');
       var satuan = $(this).data('nama_satuan');
       var kategori = $(this).data('nama_kategori');
       var merek = $(this).data('nama_merek');
       var harga_pokok = $(this).data('harga_pokok');
       var harga_konsumen = $(this).data('harga_konsumen');
       var harga_anggota = $(this).data('harga_anggota');
       var deskripsi = $(this).data('deskripsi');
 
       
       $('#nama_barang').val(nama);
       $('#jumlah').val(jumlah);
       $('#nama_kategori').val(kategori);
       $('#nama_merek').val(merek);
       $('#nama_satuan').val(satuan);
       $('#harga_pokok').val(harga_pokok);
       $('#harga_konsumen').val(harga_konsumen);
       $('#harga_anggota').val(harga_anggota);
       $('#deskripsi').val(deskripsi);
       $('#modal-detail-pengajuan').modal('show');
 
 
    });

    $('table').on('click', '.tombol-alasan', function () {
        var alasan = $(this).data('alasan');
        
        $('#alasan').val(alasan);
        $('#modal-alasan').modal('show');
  
  
     });

  
   


});


