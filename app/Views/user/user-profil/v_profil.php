<section class="section-margin">
  <div class="container">
    <div class="row">
    <div class="col-lg-12">
    <?php echo $session->getFlashdata('pesan_editprofil'); ?>
    </div>
      <div class="col-12 col-md-12 col-lg-12">
        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-3">
            <div class="card profile-widget">
              <div class="profile-widget-header">
                <img alt="image" src="<?php echo base_url('admin/assets/profile').'/'. $user['gambar']; ?>" class="rounded-circle profile-widget-picture">
                <div class="profile-widget-items">
                  
                </div>
              </div>
              <div class="profile-widget-description">
                <div class="profile-widget-name"><?php echo esc($user['nama']); ?> <div class="text-muted d-inline font-weight-normal">
                    <div class="slash"></div>
                  </div>
                </div>
                
              </div>
              <div class="card-footer text-center">
                
              </div>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
            <?php echo form_open(base_url().'/profil/editprofil', $form_profil); ?>
            <?php echo csrf_field(); ?>
            <?php echo form_input($id_user_hidden); ?>
                <div class="card-header">
                  <h4>Edit Profil</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-12 col-12">
                      <label>Nama Lengkap</label>
                      <input type="text" name="nama" class="form-control <?php echo ($validation->showError('nama')) ? 'is-invalid' : ''; ?>" value="<?php echo esc($user['nama']); ?>">
                      <div class="invalid-feedback text-danger">
                      <?php echo $validation->showError('nama'); ?>
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="form-group col-md-7 col-12">
                      <label>E-mail</label>
                      <input type="email" name="email" class="form-control" value="<?php echo esc($user['email']); ?>" readonly="">
                      <div class="invalid-feedback">
                    
                      </div>
                    </div>
                    <div class="form-group col-md-5 col-12">
                      <label>Phone</label>
                      <input type="text" name="telepon" class="form-control <?php echo ($validation->showError('telepon')) ? 'is-invalid' : ''; ?>" value="<?php echo esc($user['telepon']); ?>">
                      <div class="invalid-feedback">
                      <?php echo $validation->showError('telepon'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12 col-12">
                      <label>Alamat</label>
                      <textarea name="alamat" class="form-control <?php echo ($validation->showError('alamat')) ? 'is-invalid' : ''; ?>"> <?php echo esc($user["alamat"]); ?> </textarea>
                      <div class="invalid-feedback">
                      <?php echo $validation->showError('alamat'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group mb-0 col-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                        <label class="custom-control-label" for="newsletter">Berlangganan berita dari kami?</label>
                        <div class="text-muted form-text">
                          Kami akan mengirim berita tantang daftar produk terbaru melalui email anda.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close(); ?>
            </div>
          </div>
        </div>





      </div>


    </div>



  </div>

</section>