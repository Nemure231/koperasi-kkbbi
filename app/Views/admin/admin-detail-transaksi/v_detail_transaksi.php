
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

          <?php if($transaksi): ?>
            
            <div class="card-header">
           
            </div>
            <div class="card-body">
            <?php echo form_open(base_url().'/tambahttt', $form_insert);    ?>
            <?php echo csrf_field(); ?>
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2>Invoice</h2>
                      <div class="invoice-number"><?php echo $transaksi_row['ts_kode_transaksi']; ?></div>
                      <input type="hidden" name="tt_kode_transaksi" value="<?php echo $transaksi_row['ts_kode_transaksi']; ?>">
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
                          <?php echo $transaksi_row['nama']; ?><br>
                          <?php echo $transaksi_row['telepon']; ?><br>
                          <?php echo $transaksi_row['alamat']; ?><br>
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
                    <div class="section-title">Order Summary</div>
                    <p class="section-lead">All items here cannot be deleted.</p>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th data-width="40">#</th>
                          <th>Judul buku</th>
                          <th class="text-center">Harga</th>
                          <th class="text-center">Qty</th>
                          <th class="text-right">Subtotal</th>
                        </tr>
                        <?php  $i =1;?>
                        <?php foreach($transaksi as $ts):?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $ts['judul_buku']; ?></td>
                          <td class="text-center"><?php echo 'Rp '. number_format($ts['harga_buku'], 0,",","."); ?></td>
                          <td class="text-center"><?php echo $ts['ts_qty']; ?></td>
                          <td class="text-right"><?php echo 'Rp '. number_format($ts['ts_harga'], 0,",","."); ?></td>
                        </tr>
                        <?php $i++;  ?>
                        <?php endforeach;?>
                        
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Payment Method</div>
                        <p class="section-lead">The payment method that we provide is to make it easier for you to pay invoices.</p>
                        <div class="images">
                          <img src="assets/img/visa.png" alt="visa">
                          <img src="assets/img/jcb.png" alt="jcb">
                          <img src="assets/img/mastercard.png" alt="mastercard">
                          <img src="assets/img/paypal.png" alt="paypal">
                        </div>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value" id="total"><?php echo 'Rp '. number_format($total['ts_harga'], 0,",","."); ?></div>
                          <input type="hidden" id="total2" value="<?php echo $total['ts_harga']; ?>">
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Jumlah uang</div>
                          <div class="invoice-detail-value"><input class="form-control" id="jumlah" name="tt_jumlah_uang" type="number"> </div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Kembalian</div>
                          <div class="invoice-detail-value invoice-detail-value-lg"><input class="form-control-plaintext text-right" id="kembali" name="tt_kembalian" readonly="" type="text"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                  <button type="submit" class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i>Bayar</button>
                  <a href="#" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</a>
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


