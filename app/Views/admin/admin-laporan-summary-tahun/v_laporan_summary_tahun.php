<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/bootstrap-datepicker/datepicker.min.css' ?>">
<!-- Main Content -->

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">

          <?php echo $pesan_tahun; ?>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Agar hasil print rapi, pastikan koneksi internet menyala.</h4>
              <div class="card-header-action">
                <a href="javascript:void(0)" id="print" class="btn btn-primary">
                  Print
                </a>
              </div>
            </div>

            <div class="card-body">
              <?php echo form_open(base_url().'/laporan/summary_tahun', $form_tahun);    ?>
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <div class="alert alert-primary alert-has-icon">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                      <div class="alert-title">Petunjuk</div>
                      Anda juga dapat melakukan pencarian pada rentang tahun yang telah lewat menggunakan form
                      pencarian.
                    </div>
                  </div>



                </div>
                <div class="col-lg-6">

                  <div class="form-group">
                    <label>Form pencarian</label>
                    <div class="input-group">

                      <?php echo form_input($input_awal); ?>
                      <?php echo form_input($input_akhir); ?>
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Cari</button>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <?php echo form_close(); ?>

              <div class="row" id="area-1">

                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-2">
                      <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_koperasi_inter']); ?>"
                        style="width:150px; height: 150px; object-fit:cover;">
                    </div>
                    <div class="col-8">
                      <h3 class="text-center">Laporan Barang Summary Tahun</h3>
                      <h3 class="text-center"><?php echo $toko['nama_toko']; ?></h3>
                      <h5 class="text-center"><?php echo $toko['alamat_toko']; ?></h5>
                      <h5 class="text-center mb-5">HP: <?php echo $toko['telepon_toko']; ?></h5>
                      <h5 class="text-right"><?php  echo  $tahun_ini; ?></h5>
                    </div>
                    <div class="col-2">
                      <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                    </div>
                  </div>
                  <div class="row">
                    <?php if($tahun_ini):  ?>



                    <div class="col-6">
                      <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                          <thead>
                          <tr>

                              <th style="border: 1px solid black; background-color:#cdd3d8 !important;" scope="col" class="text-center" colspan="3">Masuk</th>

                            </tr>
                            
                            <tr>
                              <th class="text-center" style="border: 1px solid black;" scope="col">#</th>
                              <th style="border: 1px solid black;" scope="col">Tahun</th>
                              <th style="border: 1px solid black;" scope="col">Total</th>

                            </tr>
                            
                          </thead>
                          <tbody>
                            <?php  $i =1;?>
                            <?php foreach($tahun_masuk as $m):?>
                            <tr>
                              <th class="text-center" style="border: 1px solid black;" scope="row"><?php echo $i; ?></th>

                              <td style="border: 1px solid black;"><?php echo $m['nama_tahun']; ?></td>
                              <td style="border: 1px solid black;"><?php echo 'Rp. '. number_format($m['hargasum'], 0,",","."); ?></td>
                            </tr>
                            <?php $i++;  ?>
                            <?php endforeach;?>
                          </tbody>
                        </table>
                      </div>


                    </div>


                    <div class="col-6">
                      <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                          <thead>
                            <tr>

                            <th style="border: 1px solid black; background-color:#cdd3d8 !important;" scope="col" class="text-center" colspan="3">Keluar</th>

                            </tr>
                            
                            <tr>
                              <th class="text-center" style="border: 1px solid black;" scope="col">#</th>
                              <th style="border: 1px solid black;" scope="col">Tahun</th>
                              <th style="border: 1px solid black;" scope="col">Total</th>

                            </tr>
                           
                          </thead>
                          <tbody>
                            <?php  $i =1;?>
                            <?php foreach($tahun_keluar as $m):?>
                            <tr>
                              <th class="text-center" style="border: 1px solid black;" scope="row"><?php echo $i; ?></th>

                              <td style="border: 1px solid black;"><?php echo $m['nama_tahun']; ?></td>
                              <td style="border: 1px solid black;"><?php echo 'Rp. '. number_format($m['hargasum'], 0,",","."); ?></td>
                            </tr>
                            <?php $i++;  ?>
                            <?php endforeach;?>
                          </tbody>
                        </table>
                      </div>


                    </div>







                    <?php else  : ?>

                    <div class="card-header">
                      <h4>Data Kosong</h4>
                    </div>

                    <div class="card-body">
                      <div class="empty-state" data-height="400">
                        <div class="empty-state-icon">
                          <i class="fas fa-question"></i>
                        </div>
                        <h2>Data yang Anda cari tidak ada</h2>
                        <p class="lead">
                          Kemungkinan tidak ada transaksi pada renggang tanggal yang Anda cari.
                        </p>
                        <!-- <a href="" class="btn btn-icon icon-left btn-primary"><i class="fas fa-redo"></i> Refresh</a> -->
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

</div>
</section>
</div>