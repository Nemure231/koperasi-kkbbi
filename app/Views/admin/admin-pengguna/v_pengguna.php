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
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card profile-widget card-primary">
            <div class="profile-widget-header">
              <img alt="image" src="<?php echo base_url('admin/assets/profile').'/'. $user['gambar']; ?>"
                class="rounded-circle profile-widget-picture">
      
            </div>
            <div class="profile-widget-description">
              <div class="profile-widget-name"><?php echo $user['name'];  ?> <div
                  class="text-muted d-inline font-weight-normal">
                  <div class="slash"></div> <?php echo $user['nama_role'];  ?>
                </div>
              </div>
              <?php echo form_open(base_url().'/akun/profil/ubah', $form_pengguna); ?>
              <input type="hidden" name="_method" value="PUT">
              <div class="row">
                <div class="form-group col-md-12 col-lg-4">
                  <label>Nama</label>
                  <input type="text"
                    class="form-control <?php echo ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" autofocus=""
                    name="nama" value="<?php echo $user['name']; ?>">
                  <div class="invalid-feedback">
                    <?php echo $validation->showError('nama'); ?>
                  </div>
                </div>

                <div class="form-group col-md-7 col-lg-4">
                  <label>E-mail</label>

                  <?php echo form_input($email); ?>
                </div>
                <div class=" form-group col-md-5 col-lg-4">
                  <label>Phone</label>
                  <input type="text"
                    class="form-control <?php echo ($validation->hasError('telepon')) ? 'is-invalid' : ''; ?>"
                    name="telepon" value="<?php echo $user['telepon']; ?>">
                  <div class="invalid-feedback">
                    <?php echo $validation->showError('telepon'); ?>
                  </div>
                </div>

                <div class="form-group col-md-12 col-12">
                  <label>Alamat</label>
                  <textarea type="text"
                    class="form-control <?php echo ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>"
                    autofocus="" name="alamat"><?php echo $user['alamat']; ?></textarea>
                  <div class="invalid-feedback">
                    <?php echo $validation->showError('alamat'); ?>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-lg-12">
                  <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
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