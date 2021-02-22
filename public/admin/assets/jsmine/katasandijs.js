
   $(document).ready(function () {

      $("#katkat");
      /*  When user click add user button */
      //$('#btn-simpan').click(function () {
      //$('.telepon').rules('add', { minlength: 12 });

      $('#btn-simpan').val("edit-katasandi");
      if ($("#formKatasandi").length > 0) {
         $("#formKatasandi").validate({

            rules: {
            katasandi_sebelum: {
               nowhitespace: true,
               required: {
                  depends: function () {
                     $(this).val($.trim($(this).val()));
                     return true;
                  }
               },
               normalizer: function (value) {
                  return $.trim(value);
               },
            },
            katasandi_baru: {
               nowhitespace: true,
               minlength: 6,
               required: {
                  depends: function () {
                     $(this).val($.trim($(this).val()));
                     return true;
                  }
               },
               normalizer: function (value) {
                  return $.trim(value);
               },
            },
            katasandi_baru1: {
               equalTo: "#katasandi_baru",
            },
         },
         messages: {
            katasandi_sebelum: {
               required: "Harus diisi!",
               nowhitespace: "Harus diisi!"
            },
            katasandi_baru: {
               required: "Harus diisi!",
               minlength: "Terlalu pendek!",
               nowhitespace: "Harus diisi!"
            },
            katasandi_baru1: {
               equalTo: "Harus sama dengan kata sandi baru!"
            },
         },
            submitHandler: function (form) {

               var actionType = $('#btn-simpan').val();

               //var role = '<?php echo $user['role'];  ?>';

               $('#btn-simpan').html('Menyimpan ....');

               $.ajax({
                  data: $('#formKatasandi').serialize(),
                  url: "pengguna/tambahneditkatasandi",
                  headers: { 'X-Requested-With': 'XMLHttpRequest' },
                  type: "POST",
                  dataType: 'json',
                  success: function (res) {

                     //var menu = '<tr id="pengguna_id_' + res.data.id_menu + '"><td>' + res.data.id_menu + '</td><td>' + res.data.menu + '</td>';

                     //menu += '<td><a href="javascript:void(0)" data-id="' + res.data.id_menu + '" class="btn btn-warning btn-action mr-1 edit-pengguna"><i class="fas fa-pencil-alt"></i></a> <a href="javascript:void(0)" data-id="' + res.data.id_menu + '" class="btn btn-danger btn-action hapus-pengguna"><i class="fas fa-trash"></i></a></td></tr>';

                     // var pengguna = '<div class="card" id="pengguna_id_' + res.data.id + '"><form id="formPengguna" name="formPengguna">';
                     // pengguna += '<input type="hidden" name="pengguna_id" id="pengguna_id" value="' + res.data.id + '"><div class="card-header"><h4>Edit Profile</h4></div><div class="card-body"><div class="row"><div class="form-group col-md-12 col-12"><label>Nama</label><input type="text" class="form-control" id="nama" name="nama" value="' + res.data.nama + '"></div></div>';
                     // pengguna += '<div class="row"><div class="form-group col-md-7 col-12"><label>E-mail</label><input type="email" id="email" readonly name="email" class="form-control" value="' + res.data.email + '""></div><div class="form-group col-md-5 col-12"><label>Phone</label><input type="tel" id="telepon" name="telepon" class="form-control" value="' + res.data.telepon + '"></div></div>';
                     // pengguna += '<div class="row"><div class="form-group col-md-12 col-12"><label>Alamat</label><textarea type="text" id="alamat" name="alamat"class="form-control">' + res.data.alamat + '</textarea></div></div>';
                     // pengguna += '</div>';
                     // pengguna += '<div class="card-footer text-right"><button type="submit" value="edit-pengguna" id="btn-simpan" class="btn btn-primary">Save Changes</button></div></form></div>';
                     // var pengguna = '<div class="profile-widget-description" id="pengguna_id_' + res.data.id + '">';
                     // pengguna += '<div class="profile-widget-name">' + res.data.nama + '<div class="text-muted d-inline font-weight-normal">';
                     // pengguna += '<div class="slash"></div>' + role + '</div></div></div>';

                     // var pengguna1 = '<div class="d-sm-none d-lg-inline-block" id="pengguna1_id_' + res.data.id + '">Hi, ' + res.data.nama + '</div></a>';

                     // if (actionType == "edit-katasandi") {
                     //    Swal.fire({
                     //       title: 'Berhasil',
                     //       hideClass: {
                     //          popup: 'animate__animated animate__fadeOutUp animate__fast'
                     //       },
                     //       text: res,
                     //       icon: 'success'
                     //    });
                        //$("#pengguna_id_" + res.data.id).replaceWith(pengguna);
                        //$("#pengguna1_id_" + res.data.id).replaceWith(pengguna1);
                     // }
                    

                    window.location.href = "katasandi";
                     $('#formKatasandi').trigger("reset");
                     //$('#modalMenu').modal('hide');
                     $('#btn-simpan').html('Simpan');
                  },
                  error: function (data) {
                    window.location.href = "katasandi";
                     $('#formKatasandi').trigger("reset");
                     //console.log('Error:', data);
                     $('#btn-simpan').html('Simpan');
                  }
               });
            }
         });
      }
      //});
   });



   /* When click edit user */

   $('#katkat').on('click', '.edit-katasandi', function () {
      var katasandi_id = $(this).data("id");

      console.log(katasandi_id);

      $.ajax({
         type: "POST",
         url: "pengguna/ambilidk",
         data: {
            id: katasandi_id
         },
         dataType: "JSON",
         success: function (res) {
            if (res.success == true) {
               $('#menu-error').hide();
               $('#btn-simpan').html('Simpan');
               //$('#btn-simpan').val("edit-pengguna");
               // $('#pengguna_id').val(res.data.id);
               // $('#nama').val(res.data.nama);
               // $('#url').val(res.data.url);
               // $('#alamat').val(res.data.alamat);
               // $('#email').val(res.data.email);

            }
         },
         error: function (data) {

           // console.log('Error:', data);

         }
      });
      //console.log($('debug_result'));
   });
