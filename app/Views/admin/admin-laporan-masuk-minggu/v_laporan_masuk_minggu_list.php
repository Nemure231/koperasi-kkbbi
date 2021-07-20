<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/bootstrap-datepicker/datepicker.min.css' ?>">
<!-- Main Content -->

<style>
  tr.group,
  tr.group:hover {
    background-color: #ddd !important;
  }
</style>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
        <?php echo $pesan_minggu;  ?>
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
            <?php echo form_open(base_url().'/laporan/masuk', $form_minggu);    ?>
            <?php echo csrf_field(); ?>
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <div class="row">
                    <div class="col-lg-12">
                    <div class="section-title mt-0">Petunjuk</div>  
                  </div>
                    <div class="col-6">
                      <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list"
                          href="#list-home" role="tab">Minggu pertama</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                          href="#list-profile" role="tab">Minggu Kedua</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                          href="#list-messages" role="tab">Minggu Ketiga</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                          href="#list-settings" role="tab">Minggu Keempat</a>
                      </div>
                    </div>
                    <div class="col-6 text-justify">
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel"
                          aria-labelledby="list-home-list">
                          Jika ingin melihat data minggu pertama, pilihlah tanggal 1 sampai 7
                        </div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel"
                          aria-labelledby="list-profile-list">
                          Jika ingin melihat data minggu pertama, pilihlah tanggal 8 sampai 14
                        </div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel"
                          aria-labelledby="list-messages-list">
                          Jika ingin melihat data minggu pertama, pilihlah tanggal 15 sampai 21
                        </div>
                        <div class="tab-pane fade" id="list-settings" role="tabpanel"
                          aria-labelledby="list-settings-list">
                          Jika ingin melihat data minggu pertama, pilihlah tanggal 22 sampai 28
                        </div>
                      </div>
                    </div>
                  </div>


                </div>
                <div class="col-lg-6">

                 
                  <div class="form-group">
                    <label>Form pencarian</label>
                    <div class="input-group">

                    <?php echo form_input($input_awal_minggu); ?>
                        <?php echo form_input($input_akhir_minggu); ?>
                      <select name="gaya" class="custom-select" required id="inputGroupSelect05">
                        <option value="">Gaya tabel</option>
                        <option value="1">Simple</option>
                        <option value="2">Detail</option>

                      </select>
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

                  <h3 class="text-center">Laporan Barang Masuk Mingguan</h3>
                  <h3 class="text-center"><?php echo $toko['nama_toko']; ?></h3>
                  <h5 class="text-center"><?php echo $toko['alamat_toko']; ?></h5>
                  <h5 class="text-center mb-5">HP: <?php echo $toko['telepon_toko']; ?></h5>
                  <h5 class="text-right"><?php echo $minggu_ini; ?></h5>
                  </div>
                <div class="col-2">
                <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                </div>
              </div>
                  <div class="row">
                  <?php if($minggu):  ?>
                    <div class="table-responsive">
                      <table class="table table-sm" style="width:100%" id="masming">
                        <thead>
                          <tr>

                            <th>Nama</th>
                            <th>Barang</th>
                            <th>Harga Pokok</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Tanggal Masuk</th>

                          </tr>
                        </thead>
                        <tbody>


                          <?php $sum=0;?>
                          <?php $sum_qty=0;?>
                          <?php foreach($minggu as $mig):?>
                          <tr>

                            <td>
                             
                              <?php echo $mig['nama_pengirim_barang']; ?>
                            </td>
                            <td><?php echo $mig['nama_barang']; ?></td>

                            <td>

                              <?php 
                      
                              
                                echo 'Rp. '. number_format($mig['harga_pokok_pb'], 0,",",".");
                              
                              
                              ?>

                            </td>
                            <td><?php echo $qty = $mig['jumlah_barang_masuk']; ?></td>
                            <td>

                              <?php 
                      
                              
                                echo 'Rp. '. number_format($mig['total_harga_pokok'], 0,",",".");
                              
                              
                              ?>

                            </td>
                            <td><?php echo $mig['jam']; ?></td>
                            <?php $total = $mig['total_harga_pokok']; ?>


                          </tr>
                          <?php $sum += $total;?>
                          <?php $sum_qty += $qty;?>

                          <?php endforeach;?>


                        </tbody>


                        <tbody>


                          <tr>
                            <td colspan="1"></td>


                            <td colspan="1"></td>
                            <td colspan="1"><strong><?php echo $sum_qty; ?></strong></td>
                            <td colspan="1"><strong><?php echo 'Rp. '. number_format($sum, 0,",",".");  ?></strong></td>


                          </tr>

                        </tbody>



                      </table>







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
                    Kemungkinan tidak ada barang masuk pada renggang tanggal yang Anda cari. Silakan tekan tombol di bawah untuk me-refresh halaman.
                    </p>
                    <a href="" class="btn btn-icon icon-left btn-primary"><i
                        class="fas fa-redo"></i> Refresh</a>
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