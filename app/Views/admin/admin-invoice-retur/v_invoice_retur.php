<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_transaksi_sementara_retur')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Invoice Retur</h1>
    </div>

    <div class="section-body">
        <?php echo form_open(base_url().'/form/tambahtransaksiretur', $form_invoice);    ?>
          <?php echo csrf_field(); ?>

      <div class="invoice">
        <div class="invoice-print">
          <div class="row">
            <div class="col-lg-12">
              <div class="invoice-title">
                <h2>Invoice Retur</h2>
                <div class="invoice-number"><?php echo $row_retur['tsr_kode_retur']; ?></div>
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
                    
                  </address>
                </div>
              </div>
              <!-- //set_value('tt_nama_penerima', ''); -->
              <div class="row">
                <div class="col-md-6">
                  <address>
                  <!-- <strong>Tambahan:</strong>
                  <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nama penerima ...." name="tt_nama_penerima" id="tt_nama_penerima" value="<//?php echo set_value('tt_nama_penerima', ''); ?>" >
                        <input type="text" class="form-control <//?php echo ($validation->hasError('tt_telepon_penerima')) ? 'is-invalid' : ''; ?>" placeholder="No Telepon ...." name="tt_telepon_penerima" id="tt_telepon_penerima" value="<//?php echo set_value('tt_telepon_penerima', ''); ?>" >
                      </div>
                      <div class="input-group">
                        <textarea class="form-control text-left" name="tt_keterangan" id="tt_keterangan" placeholder="Keterangan ...."><//?php echo set_value('tt_nama_penerima', ''); ?></textarea>
                        <textarea class="form-control text-left" name="tt_alamat_penerima" id="tt_alamat_penerima" placeholder="Alamat penerima ...."><//?php echo set_value('tt_alamat_penerima', ''); ?></textarea>
                      </div>
                    </div>
                    <label class="text-danger">
                      <//?php echo $validation->showError('tt_telepon_penerima'); ?>
                    </label>  -->
                  </address>
                </div>
                <div class="col-md-6 text-md-right">
                  <address>
                    <strong>Tanggal Transaksi:</strong><br>
                    <?php date_default_timezone_set("Asia/Jakarta"); echo date('Y-m-d H:i:s'); ?><br><br>
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
                    <th>Nama Barang</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Subtotal</th>
                  </tr>
                  <th colspan="5" class="bg-secondary">
                    <h6 class="text-center ">Daftar barang riwayat transaksi: </h6>
                  </th>
                  <?php  $i =1;?>
                  <?php $total=0; ?>
                  <?php $total_qty=0; ?>
                    <?php foreach($retur_riwayat as $rr):?>
                      <?php $harga= $rr['tsr_r_subtotal']; ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $rr['nama_barang']; ?></td>

                        <?php if($rr['tsr_role_id'] == 4):  ?>
                          <td class="text-center"><?php echo 'Rp. '. number_format($rr['harga_konsumen'], 0,",","."); ?></td>
                        <?php else  : ?>
                          <td class="text-center"><?php echo 'Rp. '. number_format($rr['harga_anggota'], 0,",","."); ?></td>
                        <?php endif; ?>
                        <td class="text-center"><?php echo $qty= $rr['tsr_r_qty']; ?></td>
                        <td class="text-right"><?php echo 'Rp. '. number_format($harga, 0,",","."); ?></td>
                        <?php $total += $harga;?>
                        <?php $total_qty += $qty;?>
                      </tr>
                    <?php $i++;  ?>
                  <?php endforeach;?>
                  <tr>
                    <td colspan="1">Total</td>
                    <td colspan="2"></td>
                    <td colspan="1" class="text-center"><?php echo $total_qty; ?></td>
                    <td colspan="1" class="text-right"><?php echo 'Rp. '. number_format($total, 0,",","."); ?></td>

                  <tr>
                  <th colspan="5" class="bg-secondary">
                    <h6 class="text-center ">Daftar barang baru</h6>
                  </th>
                  <?php  $i1 =1;?>
                  <?php $total1=0; ?>
                  <?php $total_qty1=0; ?>
                    <?php foreach($retur_new as $rn):?>
                      <?php $harga1= $rn['tsr_n_subtotal']; ?>
                      <tr>
                        <td><?php echo $i1; ?></td>
                        <td><?php echo $rn['nama_barang']; ?></td>

                        <?php if($rn['tsr_role_id'] == 4):  ?>
                          <td class="text-center"><?php echo 'Rp. '. number_format($rn['harga_konsumen'], 0,",","."); ?></td>
                        <?php else  : ?>
                          <td class="text-center"><?php echo 'Rp. '. number_format($rn['harga_anggota'], 0,",","."); ?></td>
                        <?php endif; ?>
                        <td class="text-center"><?php echo $qty1 = $rn['tsr_n_qty']; ?></td>
                        <td class="text-right"><?php echo 'Rp. '. number_format($harga1, 0,",","."); ?></td>
                        <?php $total1 += $harga1;?>
                        <?php $total_qty1 += $qty1;?>
                      </tr>
                    <?php $i1++;  ?>
                  <?php endforeach;?>
                  <tr>
                    <td colspan="1">Total</td>
                    <td colspan="2"></td>
                    <td colspan="1" class="text-center"><?php echo $total_qty1; ?></td>
                    <td colspan="1" class="text-right"><?php echo 'Rp. '. number_format($total1, 0,",","."); ?></td>

                  <tr>


                  
                </table>
              </div>
              <div class="row mt-4">
                <div class="col-lg-8">
                  <div class="section-title">Petunjuk</div>
                  <p class="section-lead text-justify">Daftar barang dalam invoice ini dapat dihapus semuanya dengan menekan tombol <strong>batalkan</strong> di bawah, jika pelanggan ingin membatalkan transaksi tiba-tiba.
                  </p>
                </div>
                <!-- <div class="col-lg-8">
                  <div class="section-title">Peringatan</div>
                  <p class="section-lead text-justify">Jika tombol <strong>simpan</strong> sudah ditekan, Anda tidak dapat mem-print invoice lagi. Jadi pastikan, menekan tombol <strong>simpan</strong> paling terakhir.
                  </p>
                  
                </div> -->
                <div class="col-lg-4 text-right">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Total</div>
                    <div class="invoice-detail-value"><?php echo 'Rp. '. number_format($row_retur['tsr_total_bayar_k'], 0,",","."); ?></div>
                  </div>
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Jumlah Uang</div>
                    <div class="invoice-detail-value"><?php echo 'Rp. '. number_format($row_retur['tsr_jumlah_uang_k'], 0,",","."); ?></div>
                  </div>
                  <hr class="mt-2 mb-2">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Kambalian</div>

                    <?php if($row_retur['tsr_kembalian_pl'] == 0 ): ?>
                    <div class="invoice-detail-value invoice-detail-value-lg"><?php echo 'Rp. '. number_format($row_retur['tsr_kembalian_k'], 0,",","."); ?></div>
                    
                    <?php else  : ?>
                      <div class="invoice-detail-value invoice-detail-value-lg"><?php echo 'Rp. '. number_format($row_retur['tsr_kembalian_pl'], 0,",","."); ?></div>
                    <?php endif; ?>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="text-md-right">
          <div class="float-lg-left mb-lg-0 mb-3">


          
          <input type="hidden" name="tt_tanggal_beli" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('Y-m-d H:i:s'); ?>" class="form-control">
            <button type="submit" class="btn btn-primary btn-icon icon-left mr-3"><i class="fas fa-credit-card"></i> Simpan
            </button>
         

          </div>
        </div>


        <div class="text-md-right">
          <div class="float-lg-left mb-lg-0 mb-3">

            <a href="javascript:void(0)" id="tombolhapusinvoice" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Batalkan</a>
          </div>
          <!-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> -->
        </div>



      </div>
      <?php echo form_close(); ?>

      <div class="invisible"><?php echo $validation->listErrors(); ?></div>

      



    </div>



  </section>
</div>


<!-- Modal -->
<div class="modal fade" id="modalhapusinvoice" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light"></h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i style="font-size: 24px;" class="fas fa-10x fa-times"></i></span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="empty-state" data-height="80">
                  <div class="empty-state-icon bg-danger">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin menghapus semua data invoice ini?</h2>
                  <p class="lead">
                    Stok barang yang telah dipilih sebelumnya akan ditambahkan kembali seperti semula.
                  </p>

                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">

        <form class="btn btn-block"
          action="<?php echo base_url().'/form/kecohhapusinvoiceretur'.'/'.''.$id_session.'' ?>" method="post"
          accept-charset="utf-8">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        </form>

      </div>

    </div>
  </div>
</div>