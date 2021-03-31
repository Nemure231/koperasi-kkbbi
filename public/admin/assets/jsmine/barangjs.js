$("#buku_id_1").remove();

const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
const flashData = $('.flash-data').data('flashdata');
const flashDataSalah = $('.barang_error').html();

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



   $('#brbr').DataTable({
      responsive: true,
      columnDefs: [{
            responsivePriority: 1,
            targets: 0
         },
         {
            responsivePriority: 2,
            targets: 1
         },
         {
            responsivePriority: 3,
            targets: 2
         },
         {
            responsivePriority: 4,
            targets: 8
         },
         {
            responsivePriority: 5,
            targets: 9
         },
         {
            responsivePriority: 6,
            targets: 10
         },
         {
            responsivePriority: 7,
            targets: 13
         }
      ],
      "footerCallback": function (row, data, start, end, display) {
         var api = this.api(),
            data;
         // Remove the formatting to get integer data for summation
         var intVal = function (i) {
            return typeof i === 'string' ?
               i.replace(/[\,]/g, '') * 1 :
               typeof i === 'number' ?
               i : 0;
         };

         // Total over all pages
         total = api
            .column(10)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotal = api
            .column(10, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);


         total2 = api
            .column(9)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotal2 = api
            .column(9, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);


         total3 = api
            .column(8)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotal3 = api
            .column(8, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         total4 = api
            .column(7)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotal4 = api
            .column(7, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);


         // Update footer
         $(api.column(10).footer()).html(
            '' + pageTotal + ''
         );
         $(api.column(9).footer()).html(
            '' + pageTotal2 + ''
         );
         $(api.column(8).footer()).html(
            '' + pageTotal3 + ''
         );
         $(api.column(7).footer()).html(
            '' + pageTotal4 + ''
         );
      }


   });


   $('#satuan_id').select2({tags: true});
   $('#merek_id').select2({tags: true});
   $('#supplier_id').select2({tags: true});
   $('#kategori_id').select2({tags: true});

   $('#tombolTambahBarang').click(function () {
     
      $('#modalTambahBarang').modal('show');


   });

   //GET UPDATE
   $('table').on('click', '.tombolEditBarang', function () {
      var id_barang = $(this).data('id_barang');
      var nama_barang = $(this).data('nama_barang');
      var gambar_barang = $(this).data('gambar_barang');
      var kategori = $(this).data('kategori_id');
      var satuan = $(this).data('satuan_id');
      var merek = $(this).data('merek_id');
      var pengirim = $(this).data('pengirim_barang_id');
      var deskripsi = $(this).data('deskripsi_barang');
      var harga_konsumen = $(this).data('harga_konsumen');
      var harga_anggota = $(this).data('harga_anggota');
      var harga_pokok = $(this).data('harga_pokok');
      var stok_barang = $(this).data('stok');
      $('#edit_id_barang').val(id_barang);
      $('#edit_nama_barang').val(nama_barang);
      $('#edit_kategori_id').val(kategori);
      $('#edit_merek_id').val(merek);
      $('#edit_supplier_id').val(pengirim);
      $('#edit_satuan_id').val(satuan);
      $('#edit_nama_barang').val(nama_barang);
      $('#edit_harga_konsumen').val(harga_konsumen);
      $('#edit_harga_anggota').val(harga_anggota);
      $('#edit_harga_pokok').val(harga_pokok);
      $('#edit_stok_barang').val(stok_barang);
      $('#edit_merek_id').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
         
      });
      $('#edit_satuan_id').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
      });
      $('#edit_kategori_id').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
      });
      $('#edit_supplier_id').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
      });

      $('#modalEditBarang').modal('show');

   });


   var validasi_tambah = $('.validasi_tambah').html();
   var validasi_edit = $('.validasi_edit').html();
   if(validasi_tambah != 0){
      $('#modalTambahBarang').modal('show');
   }

   if(validasi_edit != 0){
      $('#modalEditBarang').modal('show');

         kategori_id = $('#old_kategori_id').val();
         satuan_id = $('#old_satuan_id').val();
         merek_id = $('#old_merek_id').val();
         supplier_id = $('#old_supplier_id').val();
         $('#edit_kategori_id').val(kategori_id);
         $('#edit_satuan_id').val(satuan_id);
         $('#edit_merek_id').val(merek_id);
         $('#edit_supplier_id').val(supplier_id);
         
   
         $('#edit_merek_id').select2({
            dropdownParent: $('#modalEditBarang'),
            tags: true
            
         });
         $('#edit_satuan_id').select2({
            dropdownParent: $('#modalEditBarang'),
            tags: true
         });
         $('#edit_kategori_id').select2({
            dropdownParent: $('#modalEditBarang'),
            tags: true
         });
         $('#edit_supplier_id').select2({
            dropdownParent: $('#modalEditBarang'),
            tags: true
         });
      
   }


   $('table').on('click', '.tombolHapusBarang', function () {

      var barang_id = $(this).data("id_barang");

      $('#hapus_id_barang').val(barang_id);
      $('#modalBarangHapus').modal('show');
  
   });

   $('#modalEditBarang').on('hidden.bs.modal', function (event) {
      $('.hapus-validasi').remove('invalid-feedback');
      $('.hapus-validasi-border').removeClass('is-invalid');
   });


});