<section class="section-margin">
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/modules/izitoast/css/iziToast.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/bootstrap-datepicker/datepicker.min.css' ?>">
  <div class="container">
    <div class="row">
      <div class="col-lg-12" id="addhtml">
        <?php echo $session->getFlashdata('pesan_pendaftaran'); ?>
      </div>

      

      <div class="col-lg-12" id="purgeall">
        <form action="<?php echo base_url().'/pendaftaran/tambah' ?>" method="post" accept-charset="utf-8">
          <!-- <//?php echo csrf_field(); ?> -->
          <input type="hidden" id="csrf_pendaftaran" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
          <div class="card card-primary">
            
            <div class="card-body">

              <div class="row">
                <!-- <div class="col-lg-12">
                  <div class="alert alert-info">
                    
                         
                         Setelah mengisi semua data, Anda akan mendapat surel konfirmasi berisi kode konfirmasi.
                         Pastikan datang ke koperasi untuk melakukan konfirmasi dan melakukan pembayaran pendaftaran sebesar Rp.100.000 dengan sekretaris pada tanggal dan waktu yang telah Anda tentukan.

                        
                  </div>
                </div> -->
                <div class="col-lg-6">

                  <div class="row">
                    <div class="form-group col-lg-12 col-md-12">
                      <label>Nama Lengkap</label>
                      <input type="text" name="nama" id="nama" class="form-control <?php echo ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('nama', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('nama'); ?>
                      </div>
                    </div>

                    <div class="form-group col-sm-6 col-lg-6 col-md-6">
                      <label>No HP/WA</label>
                      <input type="text" name="telepon" id="telepon" class="form-control <?php echo ($validation->hasError('telepon')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('telepon', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('telepon'); ?>
                      </div>
                    </div>

                    <div class="form-group col-sm-6 col-lg-6 col-md-6">
                      <label>Surel</label>
                      <input type="text" name="surel" id="surel" class="form-control <?php echo ($validation->hasError('surel')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('surel', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('surel'); ?>
                      </div>
                    </div>

                    <div class="form-group  col-sm-6 col-lg-6 col-md-6">
                      <label>Sandi</label>
                      <input type="password" name="sandi" id="sandi" class="form-control <?php echo ($validation->hasError('sandi')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('pekerjaan', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('sandi'); ?>
                      </div>
                    </div>

                    <div class="form-group col-sm-6 col-lg-6 col-md-6">
                      <label>Ulang Sandi</label>
                      <input type="password" name="ulang_sandi" id="ulang_sandi" class="form-control <?php echo ($validation->hasError('ulang_sandi')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('no_ktp', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('ulang_sandi'); ?>
                      </div>
                    </div>

              


              
                    
                  

              
                  </div>



                </div>

                <div class="col-lg-6">

                  <div class="row">
                  <div class="form-group col-sm-6 col-lg-6 col-md-6">
                      <label>Pekerjaan</label>
                      <input type="text" name="pekerjaan" id="pekerjaan" class="form-control <?php echo ($validation->hasError('pekerjaan')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('pekerjaan', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('pekerjaan'); ?>
                      </div>
                    </div>

                    <div class="form-group col-sm-6 col-lg-6 col-md-6">
                      <label>NIK</label>
                      <input type="text" name="no_ktp" id="no_ktp" class="form-control <?php echo ($validation->hasError('no_ktp')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('no_ktp', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('no_ktp'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-4 col-sm-12">
                      <label>No Rekening<small class="text-info"> (Opsional)</small></label>
                      <input type="number" name="no_rekening" oninput="this.value = Math.abs(this.value)" id="no_rekening" class="form-control <?php echo ($validation->hasError('no_rekening')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('no_rekening', 0, TRUE); ?>" >
                     
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('no_rekening'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-4 col-sm-6">
                      <label>Bank<small class="text-info"> (Opsional)</small></label>
    
                        <select class="custom-select <?php echo ($validation->hasError('bank')) ? 'is-invalid' : ''; ?>" name="bank" value="<?php echo set_value('bank', '', TRUE); ?>" >
                          <option value="">--Pilih--</option>
                          <option value="BCA">BCA</option>
                          <option value="BRI">BRI</option>
                          <option value="MANDIRI">MANDIRI</option>

                          
                        </select>
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('bank'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-4 col-sm-6">
                      <label>Atas Nama<small  class="text-info"> (Opsional)</small></label>
                      <input type="text" name="atas_nama" id="atas_nama" class="form-control <?php echo ($validation->hasError('atas_nama')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('atas_nama', '', TRUE); ?>">
                     
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('atas_nama'); ?>
                      </div>
                    </div>

                    <div class="form-group col-12">
                          <label>Alamat</label>
                          <textarea name="alamat" id="alamat" class="form-control <?php echo ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>"><?php echo set_value('alamat', '', TRUE); ?></textarea>
                          <div class="invalid-feedback">
                        <?php echo $validation->showError('alamat'); ?>
                      </div>
                        </div>

                    <!-- <div class="form-group col-lg-4 col-md-4">
                      <label>Tanggal</label>
                      <input type="text" name="tanggal" id="tanggal" class="form-control <//?php echo ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('tanggal', '', TRUE); ?>" aria-describedby="bantuan-tanggal">
                    
                      <small id="bantuan-tanggal" class="form-text text-muted">
                        Tanggal Konfirmasi Pendaftaran yang Anda inginkan.
                      </small>
                      <div class="invalid-feedback">
                        <//?php echo $validation->showError('tanggal'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-4">
                        <label>Dari</label>
                        
                          <input type="text" value="" class="form-control <//?php echo ($validation->hasError('waktu_awal')) ? 'is-invalid' : ''; ?>" name="waktu_awal" id="ts_awal" aria-describedby="bantuan-waktu-awal" >
                          <small id="bantuan-waktu-awal" class="form-text text-muted">
                        Waktu awal konfirmasi pendaftaran.
                      </small>
                        <div class="invalid-feedback">
                          <//?php echo $validation->showError('waktu_awal'); ?>
                        </div>
                      </div>
                    
                    
                      <div class="form-group col-lg-4 col-md-4">
                        <label>Sampai</label>
                        
                          <input type="text" value="" class="form-control <//?php echo ($validation->hasError('waktu_akhir')) ? 'is-invalid' : ''; ?>" name="waktu_akhir" id="ts_sampai" aria-describedby="bantuan-waktu-akhir">
                          <small id="bantuan-waktu-akhir" class="form-text text-muted">
                          Waktu awal konfirmasi pendaftaran.
                      </small>
                        
                        <div class="invalid-feedback">
                          <//?php echo $validation->showError('waktu_akhir'); ?>
                        </div>
                      </div>-->

                  </div>



                
                </div>

              </div>
            
            </div>
            <div class="card-footer text-right" id="heya">
              <button type="submit" id="tombol-pendaftaran" class="btn btn-primary">Daftar</button>
              <!-- <a href="javascript:void(0)" class="btn btn-primary btn-submit" data-kodet=""
                id="tbhts">Bayar</a> -->
            </div>
          </div>
        </form>
        
      </div>
     




    </div>



  </div>

</section>





