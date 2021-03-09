<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_stok')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-12">
          <?php echo form_open(base_url().'/pengaturan/stok/ubah', $form_stok);    ?>
          <input type="hidden" name="_method" value="PUT">
          <?php echo csrf_field(); ?>
          <?php echo form_input($input_id_stokH); ?>
          <div class="card card-primary">
            <div class="card-header">
              <h4>Cari stok hampir habis</h4>
            </div>
            <div class="card-body">
              <div class="row">

                <div class="form-group col-lg-6 col-sm-12 col-md-6">
                  <label for="huruf_kode_buku">Stok minimal</label>
                  <div class="input-group mb-3">
                    <input type="number" name="min_stok" value="<?php echo esc($stok['min_stok']); ?>" id="min_stok"
                      class="form-control <?php echo ($validation->showError('min_stok')) ? 'is-invalid' : ''; ?>"
                      autofocus />
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                   
                  </div>
                  <label class="text-danger"><?php echo $validation->showError('min_stok'); ?></label>
                </div>
                <div class="form-group col-lg-12 col-sm-12 col-md-12">
                  <div class="table-responsive">
                    <table class="table table-striped" id="stst">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nama Buku</th>
                          <th>Kode</th>
                          <th>Stok</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php  $i =1;?>
                        <?php foreach($habis as $h):?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $h['kd']; ?></td>
                          <td><?php echo $h['jb']; ?></td>
                          <td class="text-center"><div class="badge badge-danger"><?php echo $h['sb']; ?></div></td>
                        </tr>
                        <?php $i++;  ?>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">

            </div>
          </div>
          <?php echo form_close(); ?>
        </div>

      </div>




    </div>
  </section>
</div>