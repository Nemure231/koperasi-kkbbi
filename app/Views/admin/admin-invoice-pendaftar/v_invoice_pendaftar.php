<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/izitoast/css/iziToast.min.css' ?>">

<!-- Main Content -->
<div id="invoice-sukses"
  data-flashdata="<?php echo $session->getFlashdata('pesan_sukses');  ?>">  </div>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>
        <?php echo esc($title); ?>
      </h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">

            <?php if($pendaftar): ?>

            <div class="card-header">

            </div>
            <div class="card-body">
             
              
              <div class="invoice">
                <div class="invoice-print">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="invoice-title">
                        <h2>Invoice Pendaftaran</h2>
                        <div class="invoice-number">
                          <?php echo $pendaftar['kode']; ?><br>
                        </div>
                        <!-- <input type="hidden" name="tt_kode_transaksi" value="<//?php echo $pendaftar/['ts_uri']; ?>">
                      <input type="hidden" name="tt_kode_transaksi2" value="<//?php echo $pendaftar/['ts_kode_transaksi']; ?>"> -->
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-6">
                          <address>
                            <strong>Kasir:</strong><br>
                            <?php echo $user['nama']; ?><br>
                          </address>
                        </div>

                        <div class="col-md-6 text-md-right">
                          <address>
                            <strong>Toko:</strong><br>
                            <?php echo $toko['nama_toko']; ?><br>
                            <?php echo $toko['alamat_toko']; ?><br>
                            <?php echo $toko['telepon_toko']; ?><br>
                            <?php echo $toko['email_toko']; ?><br>

                          </address>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <address>
                            <strong>Pendaftar:</strong><br>
                            <?php echo $pendaftar['nama']; ?>
                          </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                          <address>
                            <strong>Tanggal transaksi:</strong><br>
                            <?php echo $pendaftar['tanggal']; ?><br><br>
                            
                          </address>
                        </div>
                      </div>
                    </div>
                  </div>
                
                  <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="section-title">Pendaftaran Offline</div>
                      <p class="section-lead"></p>
                      
                   
                      <form action="<?php echo base_url().'/fitur/pendaftar/invoice/ubah'; ?> " method="post" accept-charset="utf-8">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="kode" value="<?php echo $pendaftar['kode']; ?>">
                      <input type="hidden" name="_method" value="PUT">
                      <div class="row mt-4 mb-3">
                    
                    
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
                            <div class="invoice-detail-value" id="total">
                              <?php echo 'Rp '. number_format(100000, 0,",","."); ?>
                            </div>
                            <input type="hidden" id="total2" value="100000">
                          </div>
                          <div class="invoice-detail-item">
                            <div class="invoice-detail-name">Jumlah uang</div>
                            <div class="invoice-detail-value">
                              <input
                                class="form-control <?php echo ($validation->hasError('biaya')) ? 'is-invalid' : ''; ?>"
                                id="jumlah" name="biaya" min="0" oninput="this.value = Math.abs(this.value)"
                                type="number">
                              <div class="invalid-feedback">
                                <?php echo $validation->showError('biaya'); ?>
                              </div>

                            </div>
                          </div>
                          <!-- <hr class="mt-2 mb-2">
                          <div class="invoice-detail-item">
                            <div class="invoice-detail-name">Kembalian</div>
                            <div class="invoice-detail-value invoice-detail-value-lg">
                              <input class="form-control-plaintext text-right" id="kembali" name="tt_kembalian"
                                readonly="" type="text">

                            </div>
                            <label class="text-danger" id="notif-kembalian"></label>
                          </div> -->
                        </div>
                        <div class="col-lg-6">
                          <div class="text-md-right">
                            <div class="float-lg-left mb-lg-0 mb-3">
                              <button type="submit" class="btn btn-primary btn-icon icon-left"><i
                                  class="fas fa-credit-card"></i>Simpan</button>
                            </div>
                           
                          </div>
                        </div>
                       
                      
                       

                        <!-- <div class="col-lg-12">
                          <div class="text-md-right">
                            <div class="float-lg-left mb-lg-0 mb-3">
                              <button type="submit" class="btn btn-primary btn-icon icon-left"><i
                                  class="fas fa-credit-card"></i>Simpan</button>
                            </div>
                            <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                          </div>
                        </div> -->

                      
                      </div>
            </form>


                      <form action="" method="post" accept-charset="utf-8">
                        <div class="row">
                        <div class="col-lg-12">
                          <div class="text-md-right">
                            <div class="float-lg-left mb-lg-0 mb-3">
                              <button type="submit" class="btn btn-primary btn-icon icon-left"><i
                                  class="fas fa-cash"></i>Simpan</button>
                            </div>
                            <!-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> -->
                          </div>
                        </div>
                        </div>
                      </form>
                    

                      

                    </div>
                  </div>
                 


                  
                </div>
                <hr>

              </div>
             
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
        if //(!$pendaftar){
          $mumu = '';
        //}else{
          //$mumu = $pendaftar['ts_kode_transaksi'];
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