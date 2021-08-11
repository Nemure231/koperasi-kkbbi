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
                <img alt="image" src="<?php echo base_url('admin/assets/profile').'/'. 'default.png'; ?>" class="rounded-circle profile-widget-picture">
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
        
                <div class="card-header">
                <div class="alert alert-info">
                     Data ini tidak dapat diubah langsung oleh Anda, silakan hubungi Sekretaris bila ingin melakukan perubahan.
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    

                  </div>
                  <div class="row">
                    <div class="form-group col-md-7 col-12">
                      <label>Surel</label>
                      <input type="text" class="form-control" readonly value="<?php echo esc($user['email']); ?>">
                  
                    </div>
                    <div class="form-group col-md-5 col-12">
                      <label>Phone</label>
                      <input type="text" readonly class="form-control" value="<?php echo esc($user['telepon']); ?>">
                     
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12 col-12">
                      <label>Alamat</label>
                      <textarea readonly class="form-control"> <?php echo esc($user["alamat"]); ?> </textarea>
                     
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group mb-0 col-12">
                    
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                </div>
            </div>
          </div>
        </div>





      </div>


    </div>



  </div>

</section>