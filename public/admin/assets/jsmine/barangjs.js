
function previewImg() {
   const sampul = document.querySelector('#input_gambar');
   const sampulLabel = document.querySelector('.custom-file-label');
   const imgPrev = document.querySelector('.img-prev');

   sampulLabel.textContent = sampul.files[0].name;

   const fileSampul = new FileReader();

   fileSampul.readAsDataURL(sampul.files[0]);

   fileSampul.onload = function (e) {
      imgPrev.src = e.target.result;
   }
}


function previewImgEdit() {
   const sampul = document.querySelector('#input_edit_gambar');
   const sampulLabel = document.querySelector('.edit-label-gambar');
   const imgPrev = document.querySelector('.edit_gambar');

   sampulLabel.textContent = sampul.files[0].name;

   const fileSampul = new FileReader();

   fileSampul.readAsDataURL(sampul.files[0]);

   fileSampul.onload = function (e) {
      imgPrev.src = e.target.result;
   }
}


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
   //$("#brbr").DataTable();

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







   $('#swal2-content ul li').css("color", "#dc3545");

   $('#tombolTambahBarang').click(function () {
      //$('#btn-simpan').val("tambah-menu");
      //var ded = 'dude';
      //$('#judulBuku').html("Tambah Buku");
      $('#modalTambahBarang').modal('show');


   });

   $('table').on('click', '.tombolEditBarang', function () {
     
      var id_barang = $(this).data('id_barang');
      var nama_barang = $(this).data('nama_barang');
      var gambar = $(this).data('gambar');
      var kategori = $(this).data('kategori_id');
      var satuan = $(this).data('satuan_id');
      var merek = $(this).data('merek_id');
      var pengirim = $(this).data('pengirim_barang_id');
      var deskripsi = $(this).data('deskripsi_barang');
      var harga_konsumen = $(this).data('harga_konsumen');
      var harga_anggota = $(this).data('harga_anggota');
      var harga_pokok = $(this).data('harga_pokok');
      var stok_barang = $(this).data('stok');
      var getUrl = window.location;
      var baseUrl = getUrl.protocol + "///" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
      $('.edit_gambar').attr("src", baseUrl + "/public/admin/assets/barang/" + gambar);
      $('.edit-label-gambar').text(gambar);
      $('#id_barangE').val(id_barang);
      $('#nama_barangE').val(nama_barang);
      $('#kategori_idE').val(kategori);
      $('#nama_barang_old').val(nama_barang);
      $('#merek_idE').val(merek);
      $('#supplier_idE').val(pengirim);
      $('#satuan_idE').val(satuan);
      $('#deskripsi_barangE').val(deskripsi);
      $('#nama_barangE').val(nama_barang);
      $('#harga_konsumenE').val(harga_konsumen);
      $('#harga_anggotaE').val(harga_anggota);
      $('#harga_pokokE').val(harga_pokok);
      $('#stok_barangE').val(stok_barang);
      $('#gambar_lama').val(gambar);
      $('#merek_idE').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
         
      });
      $('#satuan_idE').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
      });
      $('#kategori_idE').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
      });
      $('#supplier_idE').select2({
         dropdownParent: $('#modalEditBarang'),
         tags: true
      });

      $('#modalEditBarang').modal('show');

   });

   $('table').on('click', '.tombolHapusBarang', function () {

      var barang_id = $(this).data("id_barang");
      var gambar_barang = $(this).data('gambar_barang');
      $('#id_barangH').val(barang_id);

      $('#old_gambar').val(gambar_barang);
      $('#modalBarangHapus').modal('show');
   });

   $('table').on('click', '.tombolLihatGambar', function () {

      var gambar = $(this).data("gambar");
      var qr = $(this).data('qr');
      var getUrl = window.location;
      var baseUrl = getUrl.protocol + "///" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
      // $('#tampil-gambar').attr("src", baseUrl + "/public/admin/assets/barang/" + gambar);
      $('#tampil-qr').attr("src", baseUrl + "/public/admin/assets/qr/" + qr);
      $('#modalLihatGambar').modal('show');
   });

 

});