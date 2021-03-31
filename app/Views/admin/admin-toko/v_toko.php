<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/user/assets1/bootstrap-timepicker/css/bootstrap-timepicker.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_toko')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">

      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card profile-widget">
            <div class="profile-widget-header">
              <img alt="image" src="<?php echo base_url('admin/assets/toko').'/'.$toko['logo_toko'] ?>"
                class="profile-widget-picture">
              <div class="profile-widget-items">

              </div>
            </div>
            <div class="profile-widget-description">
              <div class="profile-widget-name">KKBBI <div class="text-muted d-inline font-weight-normal">
                  <div class="slash"></div> <?php echo $toko['nama_toko']; ?>
                </div>
              </div>

              <?php echo form_open_multipart(base_url().'/tempat/toko/ubah', $form_toko);    ?>
              <!-- <input type="hidden" name="_method" value="PUT"> -->
              <?php echo form_input($edit_id_toko); ?>
              <?php echo form_input($logo_lama); ?>
      

              <div class="row">

                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                  <label>Nama Toko</label>
                  <?php echo edit_input_helper_no_modal('nama_toko', 'text', $toko['nama_toko'], $validation->hasError('nama_toko')); ?>
                  <div class="invalid-feedback">
                  <?php echo $validation->getError('nama_toko'); ?>
                  </div>
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                  <label>E-mail</label>
                  <?php echo edit_input_helper_no_modal('email_toko', 'text', $toko['email_toko'], $validation->hasError('email_toko')); ?>
                  <div class="invalid-feedback">
                  <?php echo $validation->getError('email_toko'); ?>
                  </div>
                </div>
                <div class=" form-group col-sm-12 col-md-12 col-lg-4">
                  <label>Telepon</label>
                  <?php echo edit_input_helper_no_modal('telepon_toko', 'text', $toko['telepon_toko'], $validation->hasError('telepon_toko')); ?>
                  <div class="invalid-feedback">
                  <?php echo $validation->getError('telepon_toko'); ?>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                  <label>Alamat</label>
                  <?php echo edit_textarea_helper_no_modal('alamat_toko', 'text', $toko['alamat_toko'], $validation->hasError('alamat_toko')); ?>
                  <div class="invalid-feedback">
                    <?php echo $validation->getError('alamat_toko'); ?>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-4 pb-3">
                  <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                    class="img-thumbnail img-prev" style="width:200x; height: 100px; object-fit:cover;">
                </div>


                <div class="col-sm-6 col-md-8 col-lg-8">
                  <div class="row">
                    <div class="col-12 mb-3">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input <?php echo ($validation->hasError('logo_toko')) ? 'is-invalid' : ''; ?>" id="logo_toko" name="logo_toko"
                          onchange="previewImg()">
                        <div class="invalid-feedback">
                          <?php echo $validation->getError('logo_toko'); ?>
                        </div>
                        <label class="custom-file-label text-left"
                          for="logo_toko"><?php echo esc($toko["logo_toko"]); ?></label>

                      </div>
                    </div>
                    <div class="col-12">
                      <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>



                </div>

              </div>

              <?php echo form_close(); ?>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>