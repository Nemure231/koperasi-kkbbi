$("#buku_id_1").remove();

function previewImg() {
   const sampul = document.querySelector('#gambar_barang');
   const sampulLabel = document.querySelector('.custom-file-label');
   const imgPrev = document.querySelector('.img-prev');

   sampulLabel.textContent = sampul.files[0].name;

   const fileSampul = new FileReader();

   fileSampul.readAsDataURL(sampul.files[0]);

   fileSampul.onload = function (e) {
      imgPrev.src = e.target.result;
   }
}



function previewImg1() {
   const sampul = document.querySelector('#gambar_barangE');
   const sampulLabel = document.querySelector('#img-edit-label');
   const imgPrev = document.querySelector('.img-prevE');

   sampulLabel.textContent = sampul.files[0].name;

   const fileSampul = new FileReader();

   fileSampul.readAsDataURL(sampul.files[0]);

   fileSampul.onload = function (e) {
      imgPrev.src = e.target.result;
   }
}


const flashDataHapus = $('#flash-data-hapus').data('flashdatahapus');
const flashData = $('.flash-data').data('flashdata');
const flashDataSalah = $('barang_error').html();

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

if (flashDataSalah != 0) {

   Swal.fire({
      title: 'Gagal',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      html: ' ' + flashDataSalah,
      icon: 'error'
   });

   //$('#modalBuku').modal('show');
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
      // $('#formEditBarang').attr("action", "suplai/barang/ubah");
      $('#img-edit').attr("src", "admin/assets/barang/" + gambar_barang);
      $('#img-edit-label').text(gambar_barang);
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
      $('#gambar_barang_lama').val(gambar_barang);
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

      // $('#btn-simpan-hapus').attr("href", "suplai/barang/hapus/" + barang_id);
      $('#id_barangH').val(barang_id);
      // $('#btn-simpan-hapus2').attr("action", "suplai/barang/kecoh/" + barang_id);

      $('#old_gambar').val(gambar_barang);
      //$('#formGenre').trigger("reset");
      //$('#judulBukuHapus').html("");
      $('#modalBarangHapus').modal('show');

      //   Swal.fire({
      //      title: 'Yakin ingin menghapus?',
      //      text: "Data yang telah dihapus tidak dapat dikembalikan lagi!",
      //      icon: 'warning',
      //      hideClass: {
      //         popup: 'animate__animated animate__fadeOutUp animate__fast'
      //      },
      //      showCancelButton: true,
      //      confirmButtonColor: '#3085d6',
      //      cancelButtonColor: '#d33',
      //      cancelButtonText: 'Batal',
      //      confirmButtonText: 'Ya, hapus!'
      //   }).then((result) => {
      //      if (result.value) {
      //         $.ajax({
      //            type: "Post",
      //            url: "buku/hapusbuku",
      //            data: {
      //               buku_id: buku_id
      //            },
      //            dataType: "json",
      //            success: function (data) {
      //               $("#buku_id_" + buku_id).remove();

      //               //location.reload();
      //            },
      //            error: function (data) {
      //               //console.log('Error:', data);
      //            }
      //         });
      //         Swal.fire({
      //            title: 'Berhasil',
      //            hideClass: {
      //               popup: 'animate__animated animate__fadeOutUp animate__fast'
      //            },
      //            text: 'Menu berhasil dihapus!',
      //            icon: 'success'
      //         });

      //      }
      //   });
   });


});