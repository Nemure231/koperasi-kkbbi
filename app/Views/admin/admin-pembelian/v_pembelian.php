<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_pembelian');  ?>"></div>
<div class="flash-data-transaksi" data-flashdata="<?php echo $session->getFlashdata('pesan_transaksi');  ?>"></div>
<div class="flash-data-utang" data-flashdata="<?php echo $session->getFlashdata('pesan_transaksi_sementara_utang');  ?>"></div>
<div class="flash-data-invoice" data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_invoice');  ?>"></div>
<div class="flash-data-jeniskasir" data-flashdata="<?php echo $session->getFlashdata('pesan_jenis_kasir');  ?>"></div>
<div class="flash-data-hapus-keranjang-admin"
  data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_keranjang_admin');  ?>"></div>
<div class="flash-data-hapus-all-keranjang-admin"
  data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_all_keranjang_admin');  ?>"></div>
<style type="text/css">
  #jumlah_uang-error,
  #kembalian-error,
  #nomor_telepon_hutang-error {
    color: #dc3545;}
</style>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div id="idjk" data-role_id_jenis_kasir="<?php echo $role_id_jenis_kasir; ?>" class="invisible"></div>
      <div class="row">
        <div class="col-lg-12" id="purgeall">
          <?php echo form_open(base_url().'/kasir/tambahtransaksisementarakonsumen', $form_pembelian);    ?>
          <?php echo csrf_field(); ?>
          <?php echo form_input($hidden_kode_transaksi); ?>
          <div class="card card-primary">

            <?php if($keranjang):  ?>
            <div class="card-header">
              <h4>
                Keranjang
              </h4>


              <div class="card-header-action">
                <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolPembelian">
                  <i class="fas fa-plus"></i>Tambah barang
                </a>
                <a href="javascript:void(0)" id="tombolhapuskalladmin" class="btn btn-danger">Hapus semua</a>
              </div>


            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nama Produk</th>
                      <th scope="col">Harga</th>
                      <th scope="col">QTY</th>
                      <th scope="col">Subtotal</th>
                      <th scope="col">Opsi</th>
                    </tr>
                  </thead>
                  <tbody class="hap">
                    <?php  $i =1;?>
                    <?php $sum=0;?>
                    <?php $sum_qty=0; ?>
                    <?php foreach($keranjang as $k):?>
                    <?php $total = $k['tt_qty'] * $k['harga']; ?>
                    <tr>
                      <th scope="row"><?php echo $i; ?></th>
                      <td><?php echo $k['nama_barang']; ?></td>
                      <td><?php echo 'Rp. '. number_format($k['harga'], 0,",","."); ?></td>
                      <td><?php echo $qty= $k['tt_qty']; ?></td>
                      <td><?php echo 'Rp. '. number_format($k['tt_qty'] * $k['harga'], 0,",","."); ?></td>
                      <?php $sum += $total;?>
                      <?php $sum_qty += $qty; ?>

                      <td>
                        <a href="javascript:void(0)" id="tombolhapusk" class="btn btn-danger"
                          data-kode="<?php echo $k['k_kode_keranjang']; ?>">Hapus</a>

                      </td>
                    </tr>
                    <?php echo form_input($hidden_role_id); ?>
                    <?php $i++;  ?>
                    <?php endforeach;?>

                    <tr>
                      <th colspan="3">Total</th>
                      <th colspan="1"><?php echo $sum_qty; ?></th>
                      <th colspan="2" id="total"><?php echo 'Rp. '. number_format($sum, 0,",","."); ?></th>
                    </tr>

                    <tr>
                      <th colspan="3">Jumlah uang</th>
                      <th colspan="1"></th>
                      <th colspan="2">
                        <input type="number" name="jumlah_uang" id="jumlah_uang" class="form-control">
                        <!-- <//?php echo ($validation->showError('jumlah_uang')) ? 'is-invalid' : ''; ?> -->
                        <div class="invalid-feedback">
                          <!-- <//?php echo $validation->showError('jumlah_uang'); ?> -->
                        </div>
                      </th>
                      
                    </tr>
                    <tr>
                      <th colspan="3">Kembalian</th>
                      <th colspan="1"></th>
                      <th colspan="2">
                        <input type="text" name="kembalian" id="kembalian" readonly="" class="form-control">
                        <!-- <//?php echo ($validation->showError('kembalian')) ? 'is-invalid' : ''; ?> -->


                        <label class="text-danger" id="notif-kembalian">
                         
                      </label>
                      </th>
                      
                    </tr>

                    <tr>
                      <th colspan="3">Nomor Telepon</th>
                      <th colspan="1"></th>
                      <th colspan="2">
                      <input id="nomor_telepon_hutang" readonly name="nomor_telepon_hutang" class="form-control nomor_telepon_hutang" value="" >
                      <label class="text-danger" id="err-thph"></label>  
                      <!-- <//?php echo ($validation->showError('kembalian')) ? 'is-invalid' : ''; ?> -->


                        
                      </th>
                      
                    </tr>

                    <tr>
                      <th colspan="3">Nama Pengutang</th>
                      <th colspan="1"></th>
                      <th colspan="2">
                      <input id="nama_penghutang" readonly name="nama_penghutang" class="form-control nama_penghutang" value="" >
                      <label class="text-danger" id="err-npht"></label>  
                      <!-- <//?php echo ($validation->showError('kembalian')) ? 'is-invalid' : ''; ?> -->


                        
                      </th>
                     
                    </tr>


                  </tbody>
                </table>
              </div>
              <div class="invisible">
                <?php echo $validation->listErrors(); ?>
              </div>
              <div class="row">
                <div class="col-lg-2">
                  <div class="form-group nuk">
                    <div class="control-label">Utang?</div>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="status_transaksi" value="2" class="custom-switch-input ngutang">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">Ya!</span>
                    </label>
                  </div>
                </div>

              </div>
            
           
            <div class="card-footer text-center heh" id="heya">
              <div class="invisible" id="total2"><?php echo $sum ?></div>
              <!-- <button type="submit" id="btn-submitt" class="btn btn-primary">Bayar</button> -->
              <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
            </div>

            <?php else  : ?>


            <div class="card-header">
              <h4>Data Keranjang Kosong</h4>
            </div>

            <div class="card-body">
              <div class="empty-state" data-height="400">
                <div class="empty-state-icon">
                  <i class="fas fa-question"></i>
                </div>
                <h2>Belum ada barang di dalam keranjang</h2>
                <p class="lead">
                  Silakan tekan tombol dibawah untuk menambahan data
                </p>
                <a href="javascript:void(0)" data-role_id_jenis_kasir="<?php echo $role_id_jenis_kasir; ?>"
                  class="btn btn-icon icon-left btn-primary" id="tombolPembelian"><i class="fas fa-plus"></i> Tambah
                  keranjang</a>
              </div>
            </div>





            <?php endif; ?>


          </div>

        </div>
        <?php echo form_close(); ?>

      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPembelian" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-center text-light">Daftar Barang &mdash;
          <div class="d-inline"><?php echo $nama_jenis_kasir; ?></div>
        </h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <div class="modal-body">

        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <?php echo form_open(base_url().'/kasir/ubahjeniskasir', $form_jenis_kasir);    ?>
            <input type="hidden" name="_method" value="PUT">
            <?php echo form_input($hidden_id_jenis_kasir); ?>
            <div class="form-group">
              <label>Jenis Kasir</label>
              <div class="input-group">
                <select class="custom-select role_idE" name="role_idE" id="inputGroupSelect04">
                  <option value="">Pilih jenis kasir</option>
                  <?php foreach($role as $r):?>
                  <option value="<?php echo $r['id_role'] ?>"><?php echo $r['role']; ?></option>
                  <?php endforeach;?>
                </select>

                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary" type="button">Ubah</button>
                </div>
              </div>

            </div>

            <?php echo form_close();    ?>

          </div>


          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-striped" id="pempem">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Harga</th>

                    <th>Stok</th>
                    <th>QTY</th>
                    <th>Opsi</th>
                  </tr>
                </thead>

                <tbody>

                  <?php foreach($barang as $b):?>
                  <tr>
                    <td><?php echo $b['kode_barang']; ?></td>
                    <td><?php echo $b['nama_barang']; ?></td>
                    <td><?php echo $b['nama_satuan']; ?></td>
                    <td><?php echo 'Rp '. number_format($b['harga'], 0,",","."); ?></td>
                    <td><?php echo $b['stok_barang']; ?></td>
                    <td><input oninput="this.value = Math.abs(this.value)" id="qty_barang<?php echo $b['id_barang']; ?>"
                        min="0" type="number" class="form-control qty2<?php echo $b['id_barang']; ?>"></td>
                    <td class="text-center">
                      <a href="javascript:void(0)" class="btn btn-primary mr-1 tambah-keranjang"
                        data-id_barang="<?php echo $b['id_barang']; ?>"
                        data-stok_barang="<?php echo $b['stok_barang']; ?>"
                        data-harga_barang="<?php echo $b['harga']; ?>"><i class="fas fa-plus"></i></a>
                    </td>
                  </tr>

                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>





      </div>



    </div>
  </div>
</div>


<!-- Modal Hapus Satu-->
<div class="modal fade" id="modalhapusk" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light" id="judulk"></h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i style="font-size: 24px;" class="fas fa-10x fa-times"></i></span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12" id="yappa">
            <div class="card">
              <div class="card-body">
                <div class="empty-state" data-height="80">
                  <div class="empty-state-icon bg-danger">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin menghapus barang ini dari keranjang?</h2>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">

        <form id="btn-hapus-keranjang" class="btn btn-block" method="post">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        </form>

      </div>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalhapuskalladmin" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light" id="judulk"></h5>
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
                  <h2>Yakin ingin semua data keranjang?</h2>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">

        <form class="btn btn-block"
          action="<?php echo base_url().'/kasir/kecohhapusallkeranjangadmin'.'/'.''.$id_session.'' ?>" method="post"
          accept-charset="utf-8">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Hapus keranjang</button>
        </form>

      </div>

    </div>
  </div>
</div>