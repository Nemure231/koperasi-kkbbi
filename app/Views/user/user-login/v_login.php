<style type="text/css">
  #email-error,
  #sandi-error {
    color: #dc3545;}
</style>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="admin/assets/toko/logo.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>
            <h4 class="text-center"></h4>
            <div class="card card-primary">
              <?php echo $session->getFlashdata('pesan'); ?>
              <div class="card-header">
                <h4>Login</h4>
              </div>

              <div class="card-body">
                <!-- <form method="POST" name="login" id="login" action="<?php //echo base_url().'/auth' ?>" novalidate=""> -->
                <?php echo form_open(base_url().'/login', $attr);    ?>
                <?php echo csrf_field(); ?>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="sandi">E-mail</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                          </div>
                        </div>
                      
                        <?php echo form_input($inputemail); ?>
                      </div>
                    </div>
                    <label id="email-error" class="error" for="email"></label>
                    <label class="text-danger"><?php echo $validation->showError('email') ?></label>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="sandi">Sandi</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-key"></i>
                          </div>
                        </div>
                        <?php echo form_input($inputsandi); ?>
                      </div>
                    </div>
                    <label id="sandi-error" class="error" for="sandi"></label>
                    <label class="text-danger"><?php echo $validation->showError('sandi'); ?></label>

                    <!-- <div class="invalid-feedback">
                      please fill in your password
                    </div> -->
                    <div class="mt-2 text-muted">
                  
                  </div>
                  </div>

                 
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
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
