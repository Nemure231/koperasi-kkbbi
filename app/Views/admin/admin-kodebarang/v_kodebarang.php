<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_kode_barang')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>
    <div class="section-body">
      <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-12">
          <?php echo form_open(base_url().'/suplai/kode/barang/ubah', $form_ubah);    ?>
          <input type="hidden" name="_method" value="PUT">
          <?php $pesan_edit = $session->getFlashdata('pesan_validasi_edit_kode_barang');?>
          <?php echo form_input($edit_id_kode_barang); ?>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Ubah Kode Barang</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="huruf_kode_barang">Huruf kode barang</label>
                    <?php echo edit_input_helper_no_modal('edit_huruf_kode_barang', 'text', $kode_barang['huruf_kode_barang'], $pesan_edit['huruf_kode_barang'] ?? []); ?>
                    <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback">'.$pesan_edit['huruf_kode_barang'].'</div>' : ''; ?>
                  </div>
                  <div class="form-group col-lg-6 col-sm-12 col-md-6">
                    <label for="jumlah_angka">Jumlah angka</label>
                    <?php echo edit_input_helper_no_modal('edit_jumlah_kode_barang', 'number', $kode_barang['jumlah_kode_barang'], $pesan_edit['jumlah_kode_barang'] ?? []); ?>
                  <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback">'.$pesan_edit['jumlah_kode_barang'].'</div>' : ''; ?>
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