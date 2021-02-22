
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">

<!-- Main Content -->

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">

          <?php if($utang_row): ?>
            
            <div class="card-header">
           
            </div>
            <div class="card-body">
            <?php echo form_open(base_url().'/kasir/simpan_invoice_utang', $form_utang);    ?>
            <?php echo csrf_field(); ?>
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2>Invoice</h2>
                      <div class="invoice-number"><?php echo $utang_row['ts_kode_transaksi']; ?></div>
                      <input type="hidden" name="tt_kode_transaksi" value="<?php echo $utang_row['ts_uri']; ?>">
                      <input type="hidden" name="tt_kode_transaksi2" value="<?php echo $utang_row['ts_kode_transaksi']; ?>">
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Kasir:</strong><br>
                            <?php echo $user['nama']; ?><br>
                            1234 Main<br>
                            Apt. 4B<br>
                            Bogor Barat, Indonesia
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Pelanggan:</strong><br>
                          <?php echo $utang_row['ts_nama_pengutang']; ?><br>
                          <?php echo $utang_row['ts_nomor_pengutang']; ?><br>
                          <!-- <//?php echo $utang_row['alamat']; ?><br> -->
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <!-- <address>
                          <strong>Payment Method:</strong><br>
                          Visa ending **** 4242<br>
                          ujang@maman.com
                        </address> -->
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Tanggal transaksi:</strong><br>
                         <?php date_default_timezone_set("Asia/Jakarta"); echo date('Y-m-d H:i:s'); ?><br><br>
                         <input type="hidden" name="tt_tanggal_beli" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('Y-m-d H:i:s'); ?>">
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row mt-4">
                  <div class="col-md-12">
                  <div class="section-title">Daftar barang</div>
              <p class="section-lead">Daftar barang yang berada di bawah ini tidak bisa dihapus satu per satu.</p>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th data-width="40">#</th>
                          <th>Judul buku</th>
                          <th class="text-center">Harga</th>
                          <th class="text-center">Qty</th>
                          <th class="text-right">Subtotal</th>
                        </tr>
                        <?php $total=0; ?>
                        <?php  $i =1;?>
                        <?php foreach($utang as $ut):?>
                          <?php $harga_tot= $ut['ts_harga']; ?>
                          <?php if($ut['ts_role_id'] == 4){
                              $harga = $ut['harga_konsumen'];
                          }else{
                            $harga = $ut['harga_anggota'];
                          } ?>

                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $ut['nama_barang']; ?></td>
                          <td class="text-center"><?php echo 'Rp '. number_format($harga, 0,",","."); ?></td>
                          <td class="text-center"><?php echo $ut['ts_qty']; ?></td>
                          <td class="text-right"><?php echo 'Rp '. number_format($ut['ts_harga'], 0,",","."); ?></td>
                        </tr>
                        <?php $total += $harga_tot;?>
                        <?php $i++;  ?>
                        <?php endforeach;?>
                        
                      </table>
                    </div>
                    <div class="row mt-4">
                      <!-- <div class="col-lg-8">
                        <div class="section-title">Petunjuk</div>
                          <p class="section-lead text-justify">Daftar barang dalam invoice ini dapat dihapus semuanya dengan menekan tombol <strong>batalkan</strong> di bawah, jika pelanggan ingin membatalkan transaksi tiba-tiba.
                        </p>
                        </div> -->
                      <div class="col-lg-8">
                        <!-- <div class="section-title">Peringatan</div>
                          <p class="section-lead text-justify">Jika tombol <strong>simpan</strong> sudah ditekan, Anda tidak dapat mem-print invoice lagi. Jadi pastikan, menekan tombol <strong>simpan</strong> paling terakhir.
                          </p> -->
                      
                      </div>
                    
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value" id="total"><?php echo 'Rp '. number_format($total, 0,",","."); ?></div>
                          <input type="hidden" id="total2" value="<?php echo $total; ?>">
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Jumlah uang</div>
                          <div class="invoice-detail-value">
                          <input class="form-control <?php echo ($validation->showError('tt_jumlah_uang')) ? 'is-invalid' : ''; ?>" id="jumlah" name="tt_jumlah_uang" min="0" oninput="this.value = Math.abs(this.value)" type="number">
                          <div class="invalid-feedback text-danger">
                            <?php echo $validation->showError('tt_jumlah_uang'); ?>
                          </div>    
                          
                          </div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Kembalian</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">
                            <input class="form-control-plaintext text-right" id="kembali" name="tt_kembalian" readonly="" type="text">
                            
                          </div>
                          <label class="text-danger" id="notif-kembalian"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                  <button type="submit" class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i>Simpan</button>
                  <!-- <a href="javascript:void(0)" id="tombolhapusinvoice" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Batalkan</a> -->
                </div>
                <!-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> -->
              </div>
            </div>
            <?php echo form_close(); ?>
            </div>

            <?php else  : ?>

            <div class="card-header">
                  <h4>Data Kosong</h4>
                </div>

                    <div class="card-body">
                  <div class="empty-state" data-height="400">
                    <div class="empty-state-icon bg-danger">
                      <i class="fas fa-question"></i>
                    </div>
                    <h2>Belum ada transaksi</h2>
                    <p class="lead">
                     Silahkan periksa lagi lain kali
                    </p>
          

                  </div>
                </div>
                    <?php endif; ?>



          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<!-- Modal
<div class="modal fade" id="modalhapusinvoice" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light"></h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i style="font-size: 24px;" class="fas fa-10x fa-times"></i></span>
        </button>
      </div>
    
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="empty-state" data-height="80">
                  <div class="empty-state-icon bg-danger">
                  <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin semua data invoice ini?</h2>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">

      <//?php 
        if //(!$utang_row){
          $mumu = '';
        //}else{
          //$mumu = $utang_row['ts_kode_transaksi'];
        //}
      
      ?>

        <form class="btn btn-block"
          action="<//?php echo base_url().' '.'/'.''.$mumu.'' ?>" method="post"
          accept-charset="utf-8">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        </form>

      </div>

    </div>
  </div>
</div> -->


