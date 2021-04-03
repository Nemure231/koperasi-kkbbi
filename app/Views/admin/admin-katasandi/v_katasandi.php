<style type="text/css">
  #katasandi_sebelum-error,
  #katasandi_baru-error,
  #katasandi_baru1-error {
    color: #dc3545;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan');  ?>"></div>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body" id="katkat">
      <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-12">
        <?php echo form_open(base_url().'/akun/sandi/ubah', $attr);    ?>
        <?php $pesan_edit = $session->getFlashdata('pesan_validasi_edit_sandi');?>
        <input type="hidden" name="_method" value="PUT">
            <div class="card card-primary">
              <div class="card-header">
                <h4></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-lg-12 col-sm-12 col-md-12">
                    <label for="password_lama">Kata sandi sebelumnya</label>
                      <?php $salah = $session->getFlashdata('salah'); ?>
                      <?php echo edit_input_helper_no_modal('password_lama', 'password', '', $salah ?? ''); ?>
                      <?php echo ($salah ?? '') ? '<div class="invalid-feedback ">'.$salah.'</div>' : ''; ?>
                  </div>
                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="password">Kata sandi baru</label>
                    <?php $sama = $session->getFlashdata('sama'); ?>
                    <?php echo edit_input_helper_no_modal('password', 'password', '', $pesan_edit['password'] ?? $sama ?? ''); ?>
                    <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback ">'.$pesan_edit['password'].'</div>' : ''; ?>
                    <?php echo ($sama ?? '') ? '<div class="invalid-feedback ">'.$sama.'</div>' : ''; ?>
                  </div>

                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="password_confirmation">Ulangi kata sandi baru</label>
                    <?php echo edit_input_helper_no_modal('password_confirmation', 'password', '', $pesan_edit['password'] ?? []); ?>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          <?php echo form_close(); ?>
        </div>

      </div>
    </div>
  </section>
</div>