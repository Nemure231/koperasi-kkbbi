<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">

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
              <?php echo form_open(base_url().'/laporan/keluar/tahunan', $form_tahun);    ?>
              <?php echo csrf_field(); ?>
              <div class="row">


                <div class="col-lg-6 mb-2">
                  <div class="alert alert-primary alert-has-icon">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                      <div class="alert-title">Petunjuk</div>
                      Anda juga dapat melakukan pencarian pada tahun yang telah lewat menggunakan form pencarian.
                    </div>
                  </div>



                </div>

                <div class="col-lg-6">

                  <div class="form-group">
                    <div class="input-group">

                      <?php echo form_input($input_tahun); ?>
                      <select name="gaya" class="custom-select" required id="inputGroupSelect05">
                        <option value="">Gaya tabel</option>
                        <option value="1">Simple</option>
                        <option value="2">Detail</option>
                        <option value="3">List Supplier</option>

                      </select>
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
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
                      <h3 class="text-center">Laporan Barang Keluar Tahunan</h3>
                      <h3 class="text-center"><?php echo $toko['nama_toko']; ?></h3>
                      <h5 class="text-center"><?php echo $toko['alamat_toko']; ?></h5>
                      <h5 class="text-center mb-5">HP: <?php echo $toko['telepon_toko']; ?></h5>
                      <h5 class="text-right"><?php echo $tahun_ini; ?>
                      </h5>
                    </div>
                    <div class="col-2">
                      <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                    </div>
                  </div>
                  <div class="row">
                    <?php if($tahun):  ?>


                    <div class="table-responsive">
                      <table class="table table-sm" style="width:100%" id="subtah">
                        <thead>
                          <tr>

                            <th>Nama Supplier</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Stok Sebelum</th>
                            <th class="text-center">Sisa</th>
                            
                            <th>Subtotal</th>
                            <!-- <th>Tanggal Beli</th> -->

                          </tr>
                        </thead>
                        <tbody>

                          <?php  $i =1;?>
                          <?php $sum=0;?>
                          <?php $sum_qty=0;?>
                          <?php foreach($tahun as $th):?>
                          <tr>

                            <td>
                             <?php echo $th['nama_pengirim_barang']; ?>
                             
                            </td>
                            <td><?php echo $th['nama_barang']; ?></td>
                            
                            <td>

                              <?php 
                      
                              if($th['tt_role_id'] == 4){
                                echo 'Rp. '. number_format($th['harga_konsumen'], 0,",",".");
                              }else{
                                echo 'Rp. '. number_format($th['harga_anggota'], 0,",",".");
                              }
                              
                              ?>

                            </td>
                            <td><?php echo $qty = $th['t_qty']; ?></td>
                            <td class="text-center"> <?php echo ($tahun_ini != date('Y')) ? '' : ''.$th['stok_barang'] + $th['t_qty'].''; ?></td>
                            <td class="text-center"><?php echo ($tahun_ini != date('Y')) ? '' : ''.$th['stok_barang'].''; ?></td>
                            <td><?php $total = $th['t_harga']; echo $th['t_harga']; ?>
                            </td>
                            <!-- <td><//?php echo $th['tanggal']; ?></td> -->

                          </tr>
                          <?php $sum += $total;?>
                          <?php $sum_qty += $qty;?>
                          <?php $i++;  ?>
                          <?php endforeach;?>


                        </tbody>


                        

                        <tfoot>
                      <tr>
                      <th colspan="1"></th>
                          <th colspan="1"></th>
                          <th colspan="1"></th>
                          <th class="text-center" colspan="1"></th>
                          <th class="text-center" colspan="1"></th>
                          <th class="text-center" colspan="1"></th>
                          <th colspan="1"></th>
                          <!-- <th colspan="1"></th> -->
                          

                         
                      </tr>
                  </tfoot>



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
                          Kemungkinan tidak ada transaksi pada tahun yang Anda cari. Silakan tekan tombol di bawah untuk
                          me-refresh halaman, dan kembali ke daftar data tahun ini.
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