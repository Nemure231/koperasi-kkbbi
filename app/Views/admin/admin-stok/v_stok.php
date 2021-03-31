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
          <!-- <//?php echo form_input($input_id_stokH); ?> -->
          <div class="card card-primary">
            <?php $habis = $session->getFlashdata('data_stok')  ?>
            <?php if($habis):  ?>
            <div class="card-header">
              <h4>Cari Stok Hampir Habis</h4>
              <?php echo form_open(base_url().'/suplai/stok/cari', $form_stok);    ?>
              <div class="input-group">
               <?php echo form_input($input_minimal_stok); ?>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
            <div class="card-body">
              <div class="row">

                <div class="col-lg-12 col-sm-12 col-md-12">
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
                          <td><?php echo $h['kode_barang']; ?></td>
                          <td><?php echo $h['nama_barang']; ?></td>
                          <td class="text-center">
                            <div class="badge badge-danger"><?php echo $h['stok_barang']; ?></div>
                          </td>
                        </tr>
                        <?php $i++;  ?>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <?php else  : ?>
            <div class="card-header">
              <h4>Cari Stok Hampir Habis</h4>
              <?php echo form_open(base_url().'/suplai/stok/cari', $form_stok);    ?>
              <div class="input-group">
              <?php echo form_input($input_minimal_stok); ?>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>

            <div class="card-body">
              <div class="empty-state" data-height="400">
                <div class="empty-state-icon">
                  <i class="fas fa-question"></i>
                </div>
                <h2>Data tersebut tidak ada</h2>
                <p class="lead">
                  Kemungkinan tidak ada stok yang lebih kecil daripada stok minimal yang Anda input.
                </p>
              </div>
            </div>
            <?php endif; ?>
            <div class="card-footer">

            </div>
          </div>

        </div>

      </div>




    </div>
  </section>
</div>