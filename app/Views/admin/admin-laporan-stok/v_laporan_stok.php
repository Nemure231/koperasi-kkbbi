<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/bootstrap-datepicker/datepicker.min.css' ?>">
<!-- Main Content -->


<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>
        <?php echo esc($title); ?>
      </h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
        <?php echo $session->getFlashdata('pesan_data')['pesan'] ??''; ?>
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
              <?php echo form_open(base_url().'/laporan/stok/cari', $form_minggu);    ?>
              <div class="row">
                <div class="col-lg-6 mb-3">


                </div>
                <div class="col-lg-6">

                  <!-- <div class="form-group">
                    <label>Form pencarian</label>
                    <div class="input-group">

                    <input type="text" name="cari_awal_minggu" id="cari_awal_minggu" placeholder="Cari cari bulan...."
                      class ="form-control <//?php echo ($validation->hasError('cari_awal_minggu')) ? 'is-invalid' : ''; ?>" required/>
                      <div class="invalid-feedback">
                        <//?php echo $validation->showError('cari_awal_minggu'); ?>
                      </div>
                      <input type="text" name="cari_akhir_minggu" id="cari_akhir_minggu" placeholder="Cari cari tahun...."
                      class ="form-control <//?php echo ($validation->hasError('cari_akhir_minggu')) ? 'is-invalid' : ''; ?>" required/>
                      <div class="invalid-feedback">
                        <//?php echo $validation->showError('cari_akhir_minggu'); ?>
                      </div>
                      <select name="gaya" class="custom-select" required id="inputGroupSelect05">
                        <option value="">Gaya tabel</option>
                        <option value="1">Simple</option>
                        <option value="2">Detail</option>

                      </select>
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Cari</button>
                      </div>
                    </div>
                  </div> -->

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

                      <h3 class="text-center">Laporan Stok</h3>
                      <h3 class="text-center">
                        <?php echo $toko['nama_toko']; ?>
                      </h3>
                      <h5 class="text-center">
                        <?php echo $toko['alamat_toko']; ?>
                      </h5>
                      <h5 class="text-center mb-5">HP:
                        <?php echo $toko['telepon_toko']; ?>
                      </h5>
                      <h5 class="text-right">
                      <?php echo $session->getFlashdata('pesan_data')['minggu_ini'] ?? $minggu_ini; ?>
                      </h5>
                    </div>
                    <div class="col-2">
                      <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                    </div>
                  </div>
                  <div class="row">
                  <?php $stokm = $session->getFlashdata('pesan_data')['stok'] ?? $stok; ?>

                    <?php if($stokm):  ?>
                      <input type="hidden" id="csrf_riwayat_masuk" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                      <input type="hidden" id="csrf_riwayat_keluar" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                      <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Stok Masuk</th>
                          <th scope="col">Stok Terjual</th>
                          <th scope="col">Sisa</th>
                        </tr>
                      </thead>
                      <tbody>
                    
                        <?php $i=1;?>
                        <?php foreach($stokm as $s):?>
                        <tr>
                          <th scope="row">
                          <?php  echo $i;?>
                          </th>
                          <td><?php  echo $s['nama'];?></td>
                          <td><a href="javascript:void(0)" data-id_barang="<?php echo $s['id_barang'];?>" class="text-dark tombol-lihat-riwayat-masuk"><?php echo $s['stok_sebelum'];?></a></td>
                          <td><a href="javascript:void(0)" data-id_barang="<?php echo $s['id_barang'];?>" class="text-dark tombol-lihat-riwayat-keluar"><?php echo $s['stok_terjual'];?></a></td>
                          <?php  $sisa = $s['stok_sebelum'] - $s['stok_terjual'];?>
                          <td style="<?php echo ($sisa == 0) ? ' -webkit-print-color-adjust: exact; background-color: #fc544b !important; color: white;' : ''; ?>"><?php  echo $sisa;?></td>

                        </tr>
                        <?php $i++;  ?>
                        <?php endforeach;?>
                      </tbody>
                    </table>





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
                          Kemungkinan tidak ada barang masuk pada renggang tanggal yang Anda cari. Silakan tekan tombol
                          di bawah untuk me-refresh halaman.
                        </p>
                        <a href="" class="btn btn-icon icon-left btn-primary"><i class="fas fa-redo"></i> Refresh</a>
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
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-lihat-riwayat-masuk" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Riwayat masuk</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
      <div class="modal-body">
        <div class="row">

        <table class="table" id="tabel-riwayat-masuk">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Stok</th>
                          <th scope="col">Tanggal Masuk</th>
                          
                        </tr>
                      </thead>
                      <tbody id="tampil-riwayat-masuk">
                    
                       
                       
                      </tbody>
                    </table>
         

        </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-lihat-riwayat-keluar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Riwayat keluar</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
      <div class="modal-body">
        <div class="row">

        <table class="table" id="tabel-riwayat-keluar">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Stok</th>
                          <th scope="col">Tanggal keluar</th>
                          
                        </tr>
                      </thead>
                      <tbody id="tampil-riwayat-keluar">
                    
                       
                       
                      </tbody>
                    </table>
         

        </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>