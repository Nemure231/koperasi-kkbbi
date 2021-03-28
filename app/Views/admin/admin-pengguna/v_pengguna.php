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
              <?php $pesan_edit = $session->getFlashdata('pesan_validasi_edit_pengguna');?>
              <input type="hidden" name="_method" value="PUT">
              <div class="row">
                <div class="form-group col-md-12 col-lg-4">
                  <label>Nama</label>
                  <?php echo edit_input_helper_no_modal('name', 'text', $user['name'], $pesan_edit['name'] ?? []); ?>
                  <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['name'].'</div>' : ''; ?>
                </div>

                <div class="form-group col-md-7 col-lg-4">
                  <label>E-mail</label>
                  <?php echo form_input($email); ?>
                </div>
                <div class=" form-group col-md-5 col-lg-4">
                  <label>Phone</label>
                  <?php echo edit_input_helper_no_modal('telepon', 'text', $user['telepon'], $pesan_edit['telepon'] ?? []); ?>
                  <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['telepon'].'</div>' : ''; ?>
                </div>

                <div class="form-group col-md-12 col-12">
                  <label>Alamat</label>
                  <?php echo edit_textarea_helper_no_modal('alamat', 'text', $user['alamat'], $pesan_edit['alamat'] ?? []); ?>
                  <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['alamat'].'</div>' : ''; ?>
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