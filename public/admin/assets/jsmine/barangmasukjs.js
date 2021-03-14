const flashDataBarang = $('.flash-data-barang').data('flashdata');

if (flashDataBarang) {
  Swal.fire({
    title: 'Berhasil',
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp animate__fast'
    },
    text: ' ' + flashDataBarang,
    icon: 'success'
  });

}

const flashDataPengirim = $('.flash-data-pengirim').data('flashdata');

if (flashDataPengirim) {
  Swal.fire({
    title: 'Berhasil',
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp animate__fast'
    },
    text: ' ' + flashDataPengirim,
    icon: 'success'
  });

}

const flashDataBarangMasuk = $('.flash-data-barang-masuk').data('flashdata');

if (flashDataBarangMasuk) {
  Swal.fire({
    title: 'Berhasil',
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp animate__fast'
    },
    text: ' ' + flashDataBarangMasuk,
    icon: 'success'
  });

}


const flashDataSalah = $('.errors').html();

if (flashDataSalah) {

   Swal.fire({
      title: 'Gagal',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      html: ' ' + flashDataSalah,
      icon: 'error'
   });
}




$(document).ready(function () {
  $('#swal2-content ul li').css("color", "#dc3545");
  $("#masmas").DataTable();
  
  $('.barang_id').select2();
  $('.pengirim_barang_id').select2();
  $('.satuan_id').select2({tags: true});
  $('.kategori_id').select2({tags: true});
  $('.merek_id').select2({tags: true});

  $('.vim').on('change', '.barang_id', function () {
    var tum = $(this).val();
    // var mom = $(this).attr("data-barang_id", tum);
    // $('div').find('.harga_pokok', )

    $.ajax({
      url: 'barang_masuk/ambil_harga',
      //method: "POST",
      //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
      //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
      //bergitulah caranya agar dapat menjaalankan fungsi di controller
      data: {
        barang_id: tum
      },
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      type: "post",
      dataType: 'json',
      context: this,
      success: function (res) {


        if (res.data[0].harga_pokok != 0) {
          $(this).parents('.par').find('.harga_pokok').val(res.data[0].harga_pokok).attr('readonly', '');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cilp3').children('.cilp4').children('.cilp5').children('.cilp6').children('.cilp7').find('.gembok-pokok').attr('checked', '');

        } else {
          $(this).parents('.par').find('.harga_pokok').val(res.data[0].harga_pokok).removeAttr('readonly');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cilp3').children('.cilp4').children('.cilp5').children('.cilp6').children('.cilp7').find('.gembok-pokok').removeAttr('checked');
        }

        if (res.data[0].harga_konsumen != 0) {
          $(this).parents('.par').find('.harga_konsumen').val(res.data[0].harga_konsumen).attr('readonly', '');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cilk3').children('.cilk4').children('.cilk5').children('.cilk6').children('.cilk7').find('.gembok-persen-konsumen').attr('checked', '');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cilk3').children('.cilk4').find('.persen_konsumen').attr('readonly', '');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cil3').children('.cil4').children('.cil5').children('.cil6').children('.cil7').find('.gembok-konsumen').attr('checked', '');
        } else {
          $(this).parents('.par').find('.harga_konsumen').val(res.data[0].harga_konsumen).removeAttr('readonly');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cil3').children('.cil4').children('.cil5').children('.cil6').children('.cil7').find('.gembok-konsumen').removeAttr('checked');
          // $(this).parents('.par').children('.cil1').children('.cil2').children('.cilk3').children('.cilk4').children('.cilk5').children('.cilk6').children('.cilk7').find('.gembok-persen-konsumen').removeAttr('checked');
        }

        if (res.data[0].harga_anggota != 0) {
          $(this).parents('.par').find('.harga_anggota').val(res.data[0].harga_anggota).attr('readonly', '');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cilg3').children('.cilg4').children('.cilg5').children('.cilg6').children('.cilg7').find('.gembok-persen').attr('checked', '');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.cilg3').children('.cilg4').find('.persen').attr('readonly', '');
          $(this).parents('.par').children('.cil1').children('.cil2').children('.clic3').children('.clic4').children('.clic5').children('.clic6').children('.clic7').find('.gembok-anggota').attr('checked', '');
        } else {
          $(this).parents('.par').find('.harga_anggota').val(res.data[0].harga_anggota);
        }






      }
    });
  });




  $('.vim').on('change keyup blur', '.persen', function () {
    var total = $(this).parents('.par').find('.harga_pokok').val();
    var persen = $(this).parents('.par').find('.persen').val();

    var dis = (persen / 100).toFixed(2);
    var mul = total * dis;
    var asli = total + mul;

    $(this).parents('.par').find('.harga_anggota').val(+total + +mul);

  });

  $('.vim').on('change keyup blur', '.persen_konsumen', function () {
    var total = $(this).parents('.par').find('.harga_anggota').val();
    var persen = $(this).parents('.par').find('.persen_konsumen').val();

    var dis = (persen / 100).toFixed(2);
    var mul = total * dis;

    $(this).parents('.par').find('.harga_konsumen').val(+total + +mul);

  });



  $('.vim').on('click', '.del-row', function () {
    $(this).parents('.par').remove();
    $('.vim').parents().find('.del-gar').remove();



  });


  $('.vim').on('change', '.ubah-pokok', function () {
    if (this.checked) {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cilp3')
        .children('.cilp4').find('.harga_pokok').attr('readonly', '');
    } else {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cilp3')
        .children('.cilp4').find('.harga_pokok').removeAttr('readonly');

    }



  });


  $('.vim').on('change', '.ubah-konsumen', function () {
    if (this.checked) {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cil3')
        .children('.cil4').find('.harga_konsumen').attr('readonly', '');
    } else {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cil3')
        .children('.cil4').find('.harga_konsumen').removeAttr('readonly');

    }



  });


  $('.vim').on('change', '.ubah-anggota', function () {
    if (this.checked) {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.clic3')
        .children('.clic4').find('.harga_anggota').attr('readonly', '');
    } else {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.clic3')
        .children('.clic4').find('.harga_anggota').removeAttr('readonly');

    }
  });

  $('.vim').on('change', '.ubah-persen', function () {
    if (this.checked) {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cilg3')
        .children('.cilg4').find('.persen').attr('readonly', '');
    } else {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cilg3')
        .children('.cilg4').find('.persen').removeAttr('readonly');

    }



  });


  $('.vim').on('change', '.ubah-persen-konsumen', function () {
    if (this.checked) {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cilk3')
        .children('.cilk4').find('.persen_konsumen').attr('readonly', '');
    } else {
      $(this).parents('.par').children('.cil1').children('.cil2').children('.cilk3')
        .children('.cilk4').find('.persen_konsumen').removeAttr('readonly');

    }
  });






  $('#tombolTambahBarangMasuk').click(function () {

    $('#modalTambahBarangMasuk').modal('show');

  });


  $('.submit_nama_pengirim').click(function () {

    var nama = $('#nama_pengirim_barang').val();

    if (nama == '') {
      Swal.fire({
        title: 'Gagal',
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp animate__fast'
        },
        text: 'Nama pengirim harus diisi!',
        icon: 'error'
      });

    } else {



      $.ajax({
        url: 'barang_masuk/tambah_pengirim',
        //method: "POST",
        //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
        //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
        //bergitulah caranya agar dapat menjaalankan fungsi di controller
        data: {
          nama_pengirim_barang: nama
        },
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        type: "POST",
        dataType: 'json',
        success: function (res) {
          location.reload();

        }
      });
    }

  });

  $('.submit_barang').click(function () {

    var nama_barang = $('#nama_barang').val();
    var satuan_id = $('.satuan_id').val();
    var kategori_id = $('.kategori_id').val();
    var merek_id = $('.merek_id').val();
    var keterangan = $('#keterangan').val();
    var kode_barang = $('#kode_barang').val();

    if (nama_barang == '') {
      Swal.fire({
        title: 'Gagal',
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp animate__fast'
        },
        text: 'Nama barang harus diisi!',
        icon: 'error'
      });

    } else if (satuan_id == '') {
      Swal.fire({
        title: 'Gagal',
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp animate__fast'
        },
        text: 'Satuan harus dipilih!',
        icon: 'error'
      });

    } else if (merek_id == '') {
      Swal.fire({
        title: 'Gagal',
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp animate__fast'
        },
        text: 'Merek harus dipilih!',
        icon: 'error'
      });

    } else if (kategori_id == '') {
      Swal.fire({
        title: 'Gagal',
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp animate__fast'
        },
        text: 'Kategori harus dipilih!',
        icon: 'error'
      });

    } else if (keterangan == '') {
      Swal.fire({
        title: 'Gagal',
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp animate__fast'
        },
        text: 'Keterangan harus diisi!',
        icon: 'error'
      });

    } else {

      $.ajax({
        url: 'barang_masuk/tambah_barang',
        //method: "POST",
        //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
        //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
        //bergitulah caranya agar dapat menjaalankan fungsi di controller
        data: {
          kode_barang: kode_barang,
          nama_barang: nama_barang,
          satuan_id: satuan_id,
          kategori_id: kategori_id,
          merek_id: merek_id,
          keterangan: keterangan
        },
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        type: "POST",
        dataType: 'json',
        success: function (res) {

          location.reload();

        }
      });
    }

  });


  $('#tambah_input').click(function () {

    

    $.ajax({
      url: 'barang_masuk/ambil_detail',
      type: 'get',
      dataType: 'json',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
     },
      data: '',
      success: function (res) {
        //    console.log(res.data);
        //    return false;
        //console.log(res.success);

        if (res.response == true) {
          

          let barang = res.data;

          var self = this;
          this.rules = [];

          $.each(barang, function (i) {

            var tambah = barang[i].nama_barang;
            var idm = barang[i].id_barang;

            var rus = `<option value="` + idm + `">` + tambah + `</option>`;
            self.rules.push(rus);
            
          });

          let pengirim = res.data1;
          var self1 = this;
          this.rules1 = [];

          $.each(pengirim, function (i) {
            var tambah1 = pengirim[i].nama_pengirim_barang;
            var idk = pengirim[i].id_pengirim_barang;

            var rus = `<option value="` + idk + `">` + tambah1 + `</option>`;
            self1.rules1.push(rus);
            
          });

          var men = `

                
                 <hr class="rounded mb-3 bg-primary del-gar">

          
            <div class="row par">

                    
                    <div class="col-lg-11 col-md-11 col-sm-10 cil1">
                      <div class="row cil2">



                      <div class="form-group col-lg-4 col-md-5 col-sm-12">
                          
                          <label>Barang</label>

                          <select required class="custom-select barang_id" placeholder="Barang ...." name="barang_id[]"
                            id="inputGroupSelect05">
                            <option>` + this.rules + `</option>
                                                      </select>


                          <!-- </div> -->
                        </div>

                        <div class="form-group col-lg-3 col-md-5 col-sm-8">
                          <label>Pengirim</label>
                          <select required class="custom-select pengirim_barang_id" id="pengirim_barang_id" data-uniq="1"
                            name="pengirim_barang_id[]">

                            <option>` + this.rules1 + `</option>
                            
                          </select>
                        </div>

                        <div class="form-group col-lg-2 col-md-2 col-sm-4">
                          <label>Jumlah</label>
                          <input required type="number" name="jumlah_barang_masuk[]" value="" id="jumlah_barang_masuk" class="form-control jumlah_barang_masuk" autofocus=""  />
                        </div>

                        <div class="form-group col-lg-3 col-md-12 col-sm-12 cilp3">
                          <label>Harga Pokok</label>
                          <div class="input-group mb-2 cilp4">
                            <div class="input-group-prepend cilp5">
                              <div class="input-group-text cilp6">
                               
                                  <div class="control-label"></div>
                                  <label class="custom-switch cilp7">

                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input ubah-pokok gembok-pokok"
                                      >
                                    <span class="custom-switch-indicator"></span>

                                  </label>
                                
                                
                              </div>
                            </div>
                            <input required type="number" name="harga_pokok[]" value="" id="harga_pokok" class="form-control harga_pokok"  />
                          </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6 cilg3">
                        <label>Persen Anggota</label>
                        <div class="input-group mb-2 cilg4">
                          <div class="input-group-prepend cilg5">
                            <div class="input-group-text cilg6">
                             
                                <div class="control-label"></div>
                                <label class="custom-switch cilg7">

                                  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input ubah-persen gembok-persen"
                                    >
                                  <span class="custom-switch-indicator"></span>

                                </label>
                              
                              
                            </div>
                          </div>
                          <input type="number" value="" id="persen" class="form-control persen"  />
                          <div class="input-group-append">
                            <div class="input-group-text">%</div>
                          </div>
                        </div>
                      </div>

  


                        <div class="form-group col-lg-3 col-md-6 col-sm-6 clic3">
                        <label>Harga Anggota</label>
                        <div class="input-group mb-2 clic4">
                          <div class="input-group-prepend clic5">
                            <div class="input-group-text clic6">
                             
                                <div class="control-label"></div>
                                <label class="custom-switch clic7">

                                  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input gembok-anggota ubah-anggota"
                                   >
                                  <span class="custom-switch-indicator"></span>

                                </label>
                              
                            
                            </div>
                          </div>
                          <input required type="number" name="harga_anggota[]" value="" id="harga_anggota" class="form-control harga_anggota"  />
                        </div>
                      </div>



                        <div class="form-group col-lg-3 col-md-6 col-sm-6 cilk3">
                        <label>Persen Konsumen</label>
                        <div class="input-group mb-2 cilk4">
                          <div class="input-group-prepend cilk5">
                            <div class="input-group-text cilk6">
                             
                                <div class="control-label"></div>
                                <label class="custom-switch cilk7">

                                  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input ubah-persen-konsumen gembok-persen-konsumen"
                                    >
                                  <span class="custom-switch-indicator"></span>

                                </label>
                              
                              
                            </div>
                          </div>
                          <input type="number" value="" id="persen_konsumen" class="form-control persen_konsumen"  />
                          <div class="input-group-append">
                            <div class="input-group-text">%</div>
                          </div>
                        </div>
                      </div>
 

                      <div class="form-group col-lg-3 col-md-6 col-sm-6 cil3">
                          <label>Harga Konsumen</label>
                          <div class="input-group mb-2 cil4">
                            <div class="input-group-prepend cil5">
                              <div class="input-group-text cil6">
                               
                                  <div class="control-label"></div>
                                  <label class="custom-switch cil7">

                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input gembok-konsumen ubah-konsumen"
                                     >
                                    <span class="custom-switch-indicator"></span>

                                  </label>
                                
                              
                              </div>
                            </div>
                            <input required type="number" name="harga_konsumen[]" value="" id="harga_konsumen" class="form-control harga_konsumen"  />
                          </div>
                        </div>

            
                      </div>

                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2 cil">

                      <div class="row">
                      
                        <div class="col-lg-12 mb-2 col-md-3">
                          <div class="badges text-center">
                            <a href="javascript:void(0)" class="del-row"> <span
                                class="badge badge-danger">Hapus</span></a>


                          </div>
                        </div>
                       

                      </div>
                    </div>
                    
                  
                  
                  
                  </div>`;

          // <input type="number" name="harga_pokok[]" value="" id="harga_pokok" class="form-control harga_pokok"  />

          $('#tampil_input').append(men);
          $('.barang_id').select2();
          $('.pengirim_barang_id').select2();

        } else {
          Swal.fire({
            title: 'Peringatan',
            hideClass: {
               popup: 'animate__animated animate__fadeOutUp animate__fast'
            },
            text: 'Tidak ada barang!',
            icon: 'warning'
         });
        }
      }
    });
  });












});