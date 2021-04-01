<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/jquery-ui/jquery-ui.min.css' ?>">
<style type="text/css">
  #nama_pengirim_barang-error {
    color: #dc3545;}
    .select2 {
width:100%!important;
}
</style>
<div class="flash-data-barang" data-flashdata="<?php echo $session->getFlashdata('pesan_barangL');  ?>"></div>
<div class="flash-data-pengirim" data-flashdata="<?php echo $session->getFlashdata('pesan_pengirim');  ?>"></div>
<div class="flash-data-barang-masuk" data-flashdata="<?php echo $session->getFlashdata('pesan_barang_masuk');  ?>"></div>
<!-- Main Content -->

<div class="main-content">

  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Jika data Barang dan Pengirim belum tersedia, tambah di bawah ini.</h4>
              <div class="card-header-action">
                <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                    class="fas fa-minus"></i></a>
              </div>
            </div>
            <div class="collapse" id="mycard-collapse">
              <div class="card-body">


                <?php echo form_open(base_url().'', $form_pengirim);    ?>

                <div class="row">
                  <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <div class="input-group mb-3">
                      <?php echo form_input($input_nama_pengirim); ?>
                      <div class="input-group-append">
                        <!-- <button type="submit" class="btn btn-primary submit_nama_pengirim" type="button">Button</button> -->

                        <a href="javascript:void(0)" class="btn btn-primary submit_nama_pengirim">
                          Tambah
                        </a>


                      </div>
                    </div>
                    <label id="nama_pengirim_barang-error" class="error" for="nama_pengirim_barang"></label>
                  </div>
                </div>

                <?php echo form_close(); ?>


                <div class="row">

                  <div class="col-lg-6 col-md-6">
                    <div class="row">
                    <?php echo form_input($hidden_kode_barang); ?>
                      <div class="form-group col-lg-6 col-md-6 col-sm-6">
                        <label>Nama Barang</label>
                        <?php echo form_input($input_nama_barang); ?>
                      </div>

                      <div class="form-group col-lg-6 col-md-6 col-sm-6">
                        <label>Satuan</label>
                        <select class="custom-select satuan_id" id="inputGroupSelect05" name="satuan_id">
                            <option></option>
                            <?php foreach ($satuan as $s):?>
                            <option value="<?php echo $s['id_satuan']; ?>"><?php echo $s['nama_satuan']; ?></option>
                            <?php endforeach;  ?>
                          </select>
                      </div>

                      <div class="form-group col-lg-6 col-md-6 col-sm-6">
                        <label>Kategori</label>
                        <select class="custom-select kategori_id" id="inputGroupSelect05" name="kategori_id">
                            <option></option>
                            <?php foreach ($kategori as $k):?>
                            <option value="<?php echo $k['id_kategori']; ?>"><?php echo $k['nama_kategori']; ?></option>
                            <?php endforeach;  ?>
                          </select>
                      </div>


                      <div class="form-group col-lg-6 col-md-6 col-sm-6">
                        <label>Merek</label>
                        <select class="custom-select merek_id" id="inputGroupSelect05" name="merek_id">
                            <option></option>
                            <?php foreach ($merek as $m):?>
                            <option value="<?php echo $m['id_merek']; ?>"><?php echo $m['nama_merek']; ?></option>
                            <?php endforeach;  ?>
                          </select>
                      </div>





                    

                    </div>
                  </div>



                  <div class="col-lg-6 col-md-6">
                    <div class="row">
                      <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label>Keterangan</label>
                        <?php echo form_textarea($input_keterangan); ?>
                      </div>
                      <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                        <a href="javascript:void(0)" class="btn btn-primary submit_barang">
                          Tambah
                        </a>
                      </div>
                    </div>
                    <div>




                    </div>


                  </div>
                  <!-- <div class="card-footer">
                Card Footer
              </div> -->
                </div>
              </div>
            </div>

            <div class="col-lg-12 vom">
              <div class="card">
                <div class="card-header">
                  <h4>Tambah barang masuk</h4>
                  <div class="card-header-action">
                    <a class="btn btn-icon btn-primary" id="tambah_input" href="javascript:void(0)">Tambah Input</a>
                  </div>
                </div>
                <?php echo form_open(base_url().'/fitur/barang_masuk/tambah', $form_tambah_barang_masuk);    ?>
                <div class="card-body vim" id="tampil_input">


               
                  <div class="row par">

                    
                    <div class="col-lg-11 col-md-11 col-sm-10 cil1">
                      <div class="row cil2">



                        <div class="form-group col-lg-4 col-md-5 col-sm-12">
                          <!-- <label>Barang & Harga Pokok</label>
                
                         <div class="input-group"> -->
                          <label>Barang</label>

                          <select required="" class="custom-select barang_id" placeholder="Barang ...." name="barang_id[]"
                            id="inputGroupSelect05">
                            <option value=""></option>
                            <?php foreach ($barang as $b):?>
                            <option value="<?php echo $b['id_barang']; ?>"><?php echo $b['nama_barang']; ?>
                            </option>
                            <?php endforeach;  ?>
                          </select>


                          <!-- </div> -->
                        </div>

                        <div class="form-group col-lg-3 col-md-5 col-sm-8">
                          <label>Pengirim</label>
                          <select required="" class="custom-select pengirim_barang_id" id="pengirim_barang_id" data-uniq="1"
                            name="pengirim_barang_id[]">

                            <option value=""></option>
                            <?php foreach ($pengirim as $p):?>
                            <option value="<?php echo $p['id_pengirim_barang']; ?>">
                              <?php echo $p['nama_pengirim_barang']; ?>
                            </option>
                            <?php endforeach;  ?>

                          </select>
                        </div>

                        <div class="form-group col-lg-2 col-md-2 col-sm-4">
                          <label>Jumlah</label>
                          <?php echo form_input($input_jumlah_barang_masuk); ?>
                        </div>

                        <div class="form-group col-lg-3 col-md-12 col-sm-12 cilp3">
                          <label>Harga Pokok</label>
                          <div class="input-group mb-2 cilp4">
                            <div class="input-group-prepend cilp5">
                              <div class="input-group-text cilp6">
                               
                                  <div class="control-label"></div>
                                  <label class="custom-switch cilp7">

                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input ubah-pokok gembok-pokok">
                                    <span class="custom-switch-indicator"></span>

                                  </label>
                                
                                
                              </div>
                            </div>
                            <?php echo form_input($input_harga_pokok); ?>
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
                          <?php echo form_input($input_persen); ?>
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
                            <?php echo form_input($input_harga_anggota); ?>
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
                          <?php echo form_input($input_persen_konsumen); ?>
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
                            <?php echo form_input($input_harga_konsumen); ?>
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
                    <!-- < //?php echo form_input($input_harga_pokok); ?> -->
                  </div>



                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12  text-right">

                      <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>

                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>




              </div>




            </div>








          </div>
        </div>
  </section>
</div>

<div class="invisible">
  <?php echo $validation->listErrors(); ?>
</div>