<style type="text/css">
  #katasandi_sebelum-error,
  #katasandi_baru-error,
  #katasandi_baru1-error {
    color: #dc3545;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div id="flash-data-salah" data-flashdatasalah="<?php echo $session->getFlashdata('salah');  ?>"></div>
<div id="flash-data-sama" data-flashdatasama="<?php echo $session->getFlashdata('sama');  ?>"></div>
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
        <input type="hidden" name="_method" value="PUT">
          <?php echo csrf_field(); ?>
      

            <div class="card card-primary">
              <div class="card-header">
                <h4></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-lg-12 col-sm-12 col-md-12">
                    <label for="katasandi_sebelum">Kata sandi sebelumnya</label>
                    <input type="password" class="form-control <?php echo ($validation->hasError('katasandi_sebelum')) ? 'is-invalid' : ''; ?>" id="katasandi_sebelum" name="katasandi_sebelum"
                      placeholder="" autofocus>
                      <label class="text-danger"><?php echo $validation->showError('katasandi_sebelum'); ?></label>
                  </div>
                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="katasandi_baru">Kata sandi baru</label>
                    <input type="password" class="form-control <?php echo ($validation->hasError('katasandi_baru')) ? 'is-invalid' : ''; ?>" id="katasandi_baru" name="katasandi_baru" placeholder="">
                    <label class="text-danger"><?php echo $validation->showError('katasandi_baru'); ?></label>
                  </div>
                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="katasandi_baru1">Ulangi kata sandi baru</label>
                    <input type="password" class="form-control <?php echo ($validation->hasError('katasandi_baru1')) ? 'is-invalid' : ''; ?>" id="katasandi_baru1" name="katasandi_baru1"
                      placeholder="">
                    <label class="text-danger"><?php echo $validation->showError('katasandi_baru1'); ?> </label>
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