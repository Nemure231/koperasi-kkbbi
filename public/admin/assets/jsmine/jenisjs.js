
var hi = $("#hitung").hasClass("1");

if (hi){
   $("#fdt").addClass("flash-data");
}

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

    $("#jenjen").DataTable();
    /*  When user click add user button */

    $('#tombolTambahJenisBuku').click(function () {
       $('#btn-simpan').val("tambah-jenisbuku");
       $('#jenis_buku_id').val('');
       $('#formJenisBuku').trigger("reset");
       $('#judulJenisBuku').html("Tambah Jenis Buku");
       $('#modalJenisBuku').modal('show');
       $('.jenisbuku').rules('add', {remote: {
          url: "unikjenisbuku",
          type: "post"
       }});
    });

    $('#tombolTambahJenisBukuNol').click(function () {
      $('#btn-simpan').val("tambah-jenisbuku-baru");
      $('#jenis_buku_id').val('');
      $('#formJenisBuku').trigger("reset");
      $('#judulJenisBuku').html("Tambah Jenis Buku");
      $('#modalJenisBuku').modal('show');
      $('.jenisbuku').rules('add', {remote: {
         url: "unikjenisbuku",
         type: "post"
      }});
   });

    if ($("#formJenisBuku").length > 0) {
       $("#formJenisBuku").validate({

          rules: {
             nama_jenis_buku: {
                required: true,
                normalizer: function (value) {
                   return $.trim(value);
                },
                remote: {
                   url: "unikjenisbuku",
                   type: "post"
                }
             }

          },
          messages: {
             nama_jenis_buku: {
                required: "Harus diisi",
                remote: "Nama jenis buku sudah ada!",
             },
          },


          submitHandler: function (form) {

             var actionType = $('#btn-simpan').val();

             $('#btn-simpan').html('Menyimpan ....');

             $.ajax({
                data: $('#formJenisBuku').serialize(),
                url: "tambahneditjenisbuku",
                headers:{'X-Requested-With': 'XMLHttpRequest'},
                type: "POST",
                dataType: 'json',
                success: function (res) {

                   var jenisbuku = '<tr id="jenis_buku_id_' + res.data.id_jenis_buku + '"><td>' + res.data.id_jenis_buku + '</td><td>' + res.data.nama_jenis_buku + '</td>';

                   jenisbuku += '<td><a href="javascript:void(0)" data-id="' + res.data.id_jenis_buku + '" class="btn btn-warning btn-action mr-1 edit-jenisbuku"><i class="fas fa-pencil-alt"></i></a> <a href="javascript:void(0)" data-id="' + res.data.id_jenis_buku + '" class="btn btn-danger btn-action hapus-jenisbuku"><i class="fas fa-trash"></i></a></td></tr>';

            
                   
                   if (actionType == "tambah-jenisbuku") {

                      Swal.fire({
                         title: 'Berhasil',
                         hideClass: {
                            popup: 'animate__animated animate__fadeOutUp animate__fast'
                         },
                         text: 'Jenis buku baru berhasil ditambahkan!',
                         icon: 'success'
                      });
                      $('#jenjen').prepend(jenisbuku);
                      

                   } else if (actionType == "edit-jenisbuku") {
                      Swal.fire({
                         title: 'Berhasil',
                         hideClass: {
                            popup: 'animate__animated animate__fadeOutUp animate__fast'
                         },
                         text: 'Jenis buku berhasil diubah!',
                         icon: 'success'
                      });
                      $("#jenis_buku_id_" + res.data.id_jenis_buku).replaceWith(jenisbuku);
                     
                   }else if (actionType == "tambah-jenisbuku-baru"){

                     location.reload();

                   }
                   $('#formJenisBuku').trigger("reset");
                   $('#modalJenisBuku').modal('hide');
                   $('#btn-simpan').html('Simpan');
                },
                error: function (data) {
                   console.log('Error:', data);
                   $('#btn-simpan').html('Simpan');
                }
             });
          }
       });
    }
 });


 /* When click edit user */

 $('table').on('click', '.edit-jenisbuku', function () {
    var jenis_buku_id = $(this).data("id");

    console.log(jenis_buku_id);
    
    $.ajax({
       type: "POST",
       url: "ambilidj",
       data: {
          id: jenis_buku_id
       },
       dataType: "JSON",
       success: function (res) {
          if (res.success == true) {
             $('#nama_jenis_buku-error').hide();
             $('#modalJenisBuku').modal('show');
             $('.jenisbuku').rules('remove', 'remote');
             $('#judulJenisBuku').html("Edit Jenis Buku");
             $('#btn-simpan').val("edit-jenisbuku");
             $('#jenis_buku_id').val(res.data.id_jenis_buku);
             $('#nama_jenis_buku').val(res.data.nama_jenis_buku);
             
          }
       },
       error: function (data) {

          console.log('Error:', data);

       }
    });
    console.log($('debug_result'));
 });

$('.jenisbuku').on('change', function () {
   $('.jenisbuku').rules('add', {
      remote: {
         url: "unikjenisbuku",
         type: "post"
      }
   });
});

 $('table').on('click', '.hapus-jenisbuku', function () {

    var jenis_buku_id = $(this).data("id");

    Swal.fire({
       title: 'Yakin ingin menghapus?',
       text: "Data yang telah dihapus tidak dapat dikembalikan lagi!",
       icon: 'warning',
       hideClass: {
          popup: 'animate__animated animate__fadeOutUp animate__fast'
       },
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       cancelButtonText: 'Batal',
       confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
       if (result.value) {
          $.ajax({
             type: "Post",
             url: "hapusjenisbuku",
             data: {
                jenis_buku_id: jenis_buku_id
             },
             dataType: "json",
             success: function (data) {
                $("#jenis_buku_id_" + jenis_buku_id).remove();
                
             },
             error: function (data) {
                console.log('Error:', data);
             }
          });
          Swal.fire({
             title: 'Berhasil',
             hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__fast'
             },
             text: 'Jenis buku berhasil dihapus!',
             icon: 'success'
          });

       }
    });


 });
