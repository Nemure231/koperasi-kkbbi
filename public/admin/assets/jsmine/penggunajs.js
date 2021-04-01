
   // $(document).ready(function () {

   //    $("#propro");
   //    /*  When user click add user button */
   //    //$('#btn-simpan').click(function () {
   //       //$('.telepon').rules('add', { minlength: 12 });

   //       $('#btn-simpan').val("edit-pengguna");
   //       if ($("#formPengguna").length > 0) {
   //          $("#formPengguna").validate({

   //             rules: {
   //                nama: {
   //                   required: true,
   //                   normalizer: function (value) {
   //                      return $.trim(value);
   //                   },
   //                },
   //                telepon: {
   //                   number: true,
   //                   minlength: 12,
   //                   maxlength: 12,
   //                   nowhitespace: true,
   //                   required: {
   //                      depends: function () {
   //                         $(this).val($.trim($(this).val()));
   //                         return true;
   //                      }
   //                   },
   //                   normalizer: function (value) {
   //                      return $.trim(value);
   //                   },
   //                },
   //                alamat: {
   //                   required: true,
   //                   normalizer: function (value) {
   //                      return $.trim(value);
   //                   },
   //                },

   //             },
   //             messages: {
   //                nama: {
   //                   required: "Harus diisi",
                  
   //                },
   //                telepon: {
   //                   required: "Harus diisi!",
   //                   minlength: "Tidak boleh kurang dari 12!",
   //                   maxlength: "Tidak boleh lebih dari 12",
   //                   nowhitespace: "Harus diisi!",
   //                   number: "Harus angka!",
   //                },
   //                alamat: {
   //                   required: "Harus diisi",
                  
   //                },
   //             },
   //             submitHandler: function (form) {

   //                var actionType = $('#btn-simpan').val();


   //                $('#btn-simpan').html('Menyimpan ....');

   //                $.ajax({
   //                   data: $('#formPengguna').serialize(),
   //                   url: "pengguna/tambahneditpengguna",
   //                   headers:{'X-Requested-With': 'XMLHttpRequest'},
   //                   type: "POST",
   //                   dataType: 'json',
   //                   success: function (res) {

   //                      //var menu = '<tr id="pengguna_id_' + res.data.id_menu + '"><td>' + res.data.id_menu + '</td><td>' + res.data.menu + '</td>';

   //                      //menu += '<td><a href="javascript:void(0)" data-id="' + res.data.id_menu + '" class="btn btn-warning btn-action mr-1 edit-pengguna"><i class="fas fa-pencil-alt"></i></a> <a href="javascript:void(0)" data-id="' + res.data.id_menu + '" class="btn btn-danger btn-action hapus-pengguna"><i class="fas fa-trash"></i></a></td></tr>';

   //                      // var pengguna = '<div class="card" id="pengguna_id_' + res.data.id + '"><form id="formPengguna" name="formPengguna">';
   //                      // pengguna += '<input type="hidden" name="pengguna_id" id="pengguna_id" value="' + res.data.id + '"><div class="card-header"><h4>Edit Profile</h4></div><div class="card-body"><div class="row"><div class="form-group col-md-12 col-12"><label>Nama</label><input type="text" class="form-control" id="nama" name="nama" value="' + res.data.nama + '"></div></div>';
   //                      // pengguna += '<div class="row"><div class="form-group col-md-7 col-12"><label>E-mail</label><input type="email" id="email" readonly name="email" class="form-control" value="' + res.data.email + '""></div><div class="form-group col-md-5 col-12"><label>Phone</label><input type="tel" id="telepon" name="telepon" class="form-control" value="' + res.data.telepon + '"></div></div>';
   //                      // pengguna += '<div class="row"><div class="form-group col-md-12 col-12"><label>Alamat</label><textarea type="text" id="alamat" name="alamat"class="form-control">' + res.data.alamat + '</textarea></div></div>';
   //                      // pengguna += '</div>';
   //                      // pengguna += '<div class="card-footer text-right"><button type="submit" value="edit-pengguna" id="btn-simpan" class="btn btn-primary">Save Changes</button></div></form></div>';
   //                      var pengguna = '<div class="profile-widget-description" id="pengguna_id_' + res.data.id_user + '">';
   //                      pengguna += '<div class="profile-widget-name">' + res.data.nama + '<div class="text-muted d-inline font-weight-normal">';
   //                      pengguna += '<div class="slash"></div>'+ role + '</div></div></div>';
                        
   //                      var pengguna1 ='<div class="d-sm-none d-lg-inline-block" id="pengguna1_id_' + res.data.id + '">'+ res.data.nama + '</div></a>';
                        
              
                  

   //                      if (actionType == "edit-pengguna") {
   //                         Swal.fire({
   //                            title: 'Berhasil',
   //                            hideClass: {
   //                               popup: 'animate__animated animate__fadeOutUp animate__fast'
   //                            },
   //                            text: 'Profile berhasil diubah!',
   //                            icon: 'success'
   //                         });
   //                         $("#pengguna_id_" + res.data.id_user).replaceWith(pengguna);
   //                         $("#pengguna1_id_" + res.data.id_user).replaceWith(pengguna1);
   //                      }
   //                      //$('#formPengguna').trigger("reset");
   //                      //$('#modalMenu').modal('hide');
   //                      $('#btn-simpan').html('Simpan');
   //                   },
   //                   error: function (data) {
   //                      console.log('Error:', data);
   //                      $('#btn-simpan').html('Simpan');
   //                   }
   //                });
   //             }
   //          });
   //       }
   //    //});
   // });



   // /* When click edit user */

   // $('.prpr').on('click', '.edit-pengguna', function () {
   //    var pengguna_id = $(this).data("id");

   //    console.log(pengguna_id);

   //    $.ajax({
   //       type: "POST",
   //       url: "pengguna/ambilidp",
   //       data: {
   //          id: pengguna_id
   //       },
   //       dataType: "JSON",
   //       success: function (res) {
   //          if (res.success == true) {
   //             $('#menu-error').hide();
   //             $('#btn-simpan').html('Simpan');
   //             //$('#btn-simpan').val("edit-pengguna");
   //             // $('#pengguna_id').val(res.data.id);
   //             // $('#nama').val(res.data.nama);
   //             // $('#url').val(res.data.url);
   //             // $('#alamat').val(res.data.alamat);
   //             // $('#email').val(res.data.email);

   //          }
   //       },
   //       error: function (data) {

   //          console.log('Error:', data);

   //       }
   //    });
   //    console.log($('debug_result'));
   // });

   const flashData = $('.flash-data').data('flashdata');
   const flashDataInput = $('.flash-data-input').data('flashdatainput');
   const nam = $('.namo').text();
  

   if (flashData) {

      Swal.fire({
         title: 'Selamat datang kembali, ' + nam,
         showClass: {
            popup: 'animate__animated animate__fadeInDown animate__fast'
         },
         hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__fast'
         },
         icon: 'info',
         text: ' ' + flashData,

         focusConfirm: false,
         confirmButtonText:
            '<i class="fas fa-laugh-wink"</i> Ya!',
         confirmButtonAriaLabel: 'Terima kasih',
      });
   } else if (flashDataInput) {

      Swal.fire({
               title: 'Berhasil',
               hideClass: {
                  popup: 'animate__animated animate__fadeOutUp animate__fast'
               },
               text: ' ' + flashDataInput,
               icon: 'success'
            });

      
   }

