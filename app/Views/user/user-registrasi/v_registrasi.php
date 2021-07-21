<!-- <style type="text/css">
  #email-error,
  #sandi-error {
    color: #dc3545;}
</style> -->

<body>
  <div id="app">
  <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
            <?php echo $session->getFlashdata('pesan_regis'); ?>
              <div class="card-header"><h4>Register</h4></div>

              <div class="card-body">
              <?php echo form_open(base_url().'/tambahregis', $form_registrasi);    ?>
              <?php echo csrf_field(); ?>
                  <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input id="nama" type="text" class="form-control <?php echo ($validation->showError('nama')) ? 'is-invalid' : ''; ?>" name="nama" value="<?php echo set_value('nama', '') ?>">
                    <div class="invalid-feedback text-danger">
                      <?php echo $validation->showError('nama'); ?>
                    </div>
                    
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control <?php echo ($validation->showError('email')) ? 'is-invalid' : ''; ?>" name="email" value="<?php echo set_value('email', '') ?>">
                    <div class="invalid-feedback text-danger">
                      <?php echo $validation->showError('email'); ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="sandi" class="d-block">Kata Sandi</label>
                      <input id="sandi" type="password" class="form-control <?php echo ($validation->showError('sandi')) ? 'is-invalid' : ''; ?>" name="sandi">
                      <div class="invalid-feedback text-danger">
                      <?php echo $validation->showError('sandi'); ?>
                    </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="ulang_sandi" class="d-block">Konfirmasi Kata Sandi</label>
                      <input id="ulang_sandi" type="password" class="form-control <?php echo ($validation->showError('ulang_sandi')) ? 'is-invalid' : ''; ?>" name="ulang_sandi">
                      <div class="invalid-feedback text-danger">
                      <?php echo $validation->showError('ulang_sandi'); ?>
                    </div>
                    </div>

                  </div>

                  
                  <div class="row ">
                    <div class="col-lg-6 mb-3 text-center">
                      <div class="text-muted">
                        Sudah punya akun? <a href="<?php echo base_url().'/login' ?>">Masuk</a>
                      </div>
                    </div>

                    <div class="col-lg-6 mb-3 text-center">
                        <div class="text-muted">
                          Lupa kata sandi? <a href="<?php echo base_url().'/ubahpass' ?>">Ganti</a>
                        </div>
                    </div>

                  </div>

                  <!-- <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                    </div>
                  </div> -->
                  

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                    
                  </div>
                  <?php echo form_close(); ?>
                  
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>