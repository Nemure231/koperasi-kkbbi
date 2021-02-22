

<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan')  ?>"></div>
<div class="flash-data-input" data-flashdatainput="<?php echo $session->getFlashdata('pesan_pengguna')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body prpr">

      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
          <div class="card profile-widget card-primary">
            <div class="profile-widget-header">
              <img alt="image" src="<?php echo base_url('admin/assets/profile').'/'. $user['gambar']; ?>"
                class="rounded-circle profile-widget-picture">
              <!-- <div class="profile-widget-items">
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Posts</div>
                  <div class="profile-widget-item-value">187</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Followers</div>
                  <div class="profile-widget-item-value">6,8K</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Following</div>
                  <div class="profile-widget-item-value">2,1K</div>
                </div>
              </div> -->
            </div>
            <div class="profile-widget-description" id="pengguna_id_<?php echo $user['id_user'];?>">
              <div class="profile-widget-name"><?php echo $user['nama'];  ?> <div
                  class="text-muted d-inline font-weight-normal">
                  <div class="slash"></div> <?php echo $user['role'];  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
          <div class="card card-primary">
          <?php echo form_open(base_url().'/pengguna/editpengguna', $form_pengguna); ?>
             
              <?php echo csrf_field(); ?>
              <div class="card-header">
                <h4>Edit Profile</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12 col-12">
                    <label>Nama</label>
                    <input type="text" class="form-control <?php echo ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" autofocus="" name="nama" value="<?php echo $user['nama']; ?>">
                    <div class="invalid-feedback">
                      <?php echo $validation->showError('nama'); ?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-7 col-12">
                    <label>E-mail</label>
                    
                    <?php echo form_input($email); ?>
                  </div>
                  <div class=" form-group col-md-5 col-12">
                    <label>Phone</label>
                    <input type="text" class="form-control <?php echo ($validation->hasError('telepon')) ? 'is-invalid' : ''; ?>" name="telepon" value="<?php echo $user['telepon']; ?>">
                    <div class="invalid-feedback">
                      <?php echo $validation->showError('telepon'); ?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12 col-12">
                    <label>Alamat</label>
                    <textarea type="text" class="form-control <?php echo ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" autofocus="" name="alamat" ><?php echo $user['alamat']; ?></textarea>
                    <div class="invalid-feedback">
                      <?php echo $validation->showError('alamat'); ?>
                    </div>
                  </div>
            
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
              </div>
              <?php echo form_close(); ?>
          </div>


        </div>
      </div>
    </div>
  </section>
</div>