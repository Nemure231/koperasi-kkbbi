<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_kode_transaksi')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-12">
          <?php echo form_open(base_url().'/barang/editkodetransaksi', $form_kodetransaksi);    ?>
          <input type="hidden" name="_method" value="PUT">
          <?php echo csrf_field(); ?>
          <?php echo form_input($hidd_id_kode_transaksi); ?>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Ubah kode transaksi</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="huruf_kode_transaksi">Huruf kode transaksi</label>
                    <!-- < ?php echo form_input//($input_huruf_kode_transaksi); ?> -->
                    <input type="text" name="huruf_kode_transaksi" value="<?php echo esc($kode['huruf_kode_transaksi']); ?>" id="huruf_kode_transaksi" class="form-control <?php echo ($validation->showError('huruf_kode_transaksi')) ? 'is-invalid' : ''; ?>" autofocus />
                      <label class="text-danger"><?php echo $validation->showError('huruf_kode_transaksi'); ?></label>
                  </div>
                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="jumlah_angka">Jumlah angka</label>
                    <!-- < ?php echo form_input//($input_jumlah_angka); ?> -->
                    <input type="text" name="jumlah_angka" value="<?php echo esc($kode['jumlah_angka']); ?>" id="jumlah_angka" class="form-control <?php echo ($validation->showError('jumlah_angka')) ? 'is-invalid' : ''; ?>" />
                    <label class="text-danger"><?php echo $validation->showError('jumlah_angka'); ?></label>
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