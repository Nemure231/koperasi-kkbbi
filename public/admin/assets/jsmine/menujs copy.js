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

      $("#meme").DataTable();
      /*  When user click add user button */
      $('#tombolTambahMenu').click(function () {
         $('#btn-simpan').val("tambah-menu");
         $('#menu_id').val('');
         $('#formMenu').trigger("reset");
         $('#judulMenu').html("Tambah Menu");
         $('#modalMenu').modal('show');
         $('.menu').rules('add', {remote: {
            url: "menu/unikmenu",
            type: "post"
         }});
      });

      $('#tombolTambahMenuNol').click(function () {
         $('#btn-simpan').val("tambah-menu-baru");
         $('#menu_id').val('');
         $('#formMenu').trigger("reset");
         $('#judulMenu').html("Tambah Menu");
         $('#modalMenu').modal('show');
         $('.menu').rules('add', {remote: {
            url: "menu/unikmenu",
            type: "post"
         }});
      });

      if ($("#formMenu").length > 0) {
         $("#formMenu").validate({

            rules: {
               menu: {
                  required: true,
                  normalizer: function (value) {
                     return $.trim(value);
                  },
                  remote: {
                     url: "menu/unikmenu",
                     type: "post"
                  }
               }

            },
            messages: {
               menu: {
                  required: "Harus diisi",
                  remote: "Nama menu sudah ada!",
               },
            },


            submitHandler: function (form) {

               var actionType = $('#btn-simpan').val();

               $('#btn-simpan').html('Menyimpan ....');

               $.ajax({
                  data: $('#formMenu').serialize(),
                  url: "menu/tambahneditmenu",
                  headers:{'X-Requested-With': 'XMLHttpRequest'},
                  type: "POST",
                  dataType: 'json',
                  success: function (res) {

                     var menu = '<tr id="menu_id_' + res.data.id_menu + '"><td>' + res.data.id_menu + '</td><td>' + res.data.menu + '</td>';

                     menu += '<td><a href="javascript:void(0)" data-id="' + res.data.id_menu + '" class="btn btn-warning btn-action mr-1 edit-menu"><i class="fas fa-pencil-alt"></i></a> <a href="javascript:void(0)" data-id="' + res.data.id_menu + '" class="btn btn-danger btn-action hapus-menu"><i class="fas fa-trash"></i></a></td></tr>';

                     var mem = '<li class="menu-header" id="id_menuu_' + res.data.id_menu + '">' + res.data.menu + '</li>';
                     
                     if (actionType == "tambah-menu") {

                        Swal.fire({
                           title: 'Berhasil',
                           hideClass: {
                              popup: 'animate__animated animate__fadeOutUp animate__fast'
                           },
                           text: 'Menu baru berhasil ditambahkan!',
                           icon: 'success'
                        });
                        $('#meme').prepend(menu);
                        $('#tambah').prepend(mem);

                     } else if (actionType == "edit-menu") {
                        Swal.fire({
                           title: 'Berhasil',
                           hideClass: {
                              popup: 'animate__animated animate__fadeOutUp animate__fast'
                           },
                           text: 'Menu berhasil diubah!',
                           icon: 'success'
                        });
                        $("#menu_id_" + res.data.id_menu).replaceWith(menu);
                        $("#id_menuu_" + res.data.id_menu).replaceWith(mem);
                     }else if (actionType == "tambah-menu-baru"){

                     
                        location.reload();
   
                      }
                     $('#formMenu').trigger("reset");
                     $('#modalMenu').modal('hide');
                     $('#btn-simpan').html('Simpan');
                  },
                  error: function (data) {
                     //console.log('Error:', data);
                     $('#btn-simpan').html('Simpan');
                  }
               });
            }
         });
      }
   });


   /* When click edit user */

   $('table').on('click', '.edit-menu', function () {
      var menu_id = $(this).data("id");

      console.log(menu_id);
      
      $.ajax({
         type: "POST",
         url: "menu/ambilidm",
         data: {
            id: menu_id
         },
         dataType: "JSON",
         headers:{'X-Requested-With': 'XMLHttpRequest'},
         success: function (res) {
            if (res.success == true) {
               $('#menu-error').hide();
               $('#modalMenu').modal('show');
               $('.menu').rules('remove', 'remote');
               $('#judulMenu').html("Edit Menu");
               $('#btn-simpan').val("edit-menu");
               $('#menu_id').val(res.data.id_menu);
               $('#menu').val(res.data.menu);
               
            }
         },
         error: function (data) {

            console.log('Error:', data);

         }
      });
      console.log($('debug_result'));
   });

   $('.menu').on('change', function () {
      $('.menu').rules('add', {remote: {
         url: "menu/unikmenu",
         type: "post"
      }});
   });

   $('table').on('click', '.hapus-menu', function () {

      var menu_id = $(this).data("id");

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
               url: "menu/hapusmenu",
               data: {
                  menu_id: menu_id
               },
               dataType: "json",
               headers:{'X-Requested-With': 'XMLHttpRequest'},
               success: function (data) {
                  $("#menu_id_" + menu_id).remove();
                  $("#id_menuu_" + menu_id).remove();
               },
               error: function (data) {
                  //console.log('Error:', data);
               }
            });
            Swal.fire({
               title: 'Berhasil',
               hideClass: {
                  popup: 'animate__animated animate__fadeOutUp animate__fast'
               },
               text: 'Menu berhasil dihapus!',
               icon: 'success'
            });

         }
      });

      


   });
