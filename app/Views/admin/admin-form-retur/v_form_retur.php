<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_invoice');  ?>"></div>
<div class="flash-data-ceklis" data-flashdata="<?php echo $session->getFlashdata('pesan_belum_ceklis');  ?>"></div>
<div class="flash-data-klik" data-flashdata="<?php echo $session->getFlashdata('pesan_belum_klik');  ?>"></div>
<div class="flash-data-transaksi" data-flashdata="<?php echo $session->getFlashdata('pesan_transaksi');  ?>"></div>
<div class="flash-data-kasir-retur" data-flashdata="<?php echo $session->getFlashdata('pesan_pembelian');  ?>"></div>
<div class="flash-data-jeniskasir" data-flashdata="<?php echo $session->getFlashdata('pesan_jenis_kasir');  ?>"></div>
<div class="flash-data-hapus-keranjang-admin"
  data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_keranjang_admin');  ?>"></div>
<div class="flash-data-hapus-all-keranjang-admin"
  data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_all_keranjang_admin');  ?>"></div>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>
    
    <div class="section-body">

      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <!-- <div class="col-9">

              <div class="alert alert-primary alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Petunjuk</div>
                  Tekan tombol refresh di samping untuk mengosongkan riwayat transaksi. DAN BILA SUPPLIER INGIN MERETUR BARANGNYA SENDIRI, ISILAH KOLOM PENCARIAN KODE TRANSAKSI DENGAN "RETUR SUPPLIER", LALU PILIH BARANG YANG INGIN DIRETUR, RIWAYAT TRANSAKSI BIARKAN SAJA KOSONG JANGAN LUPA DICENTANG, TIDAK PERLU MENGISI JUMLAH UANG, DAN LANGSUNG KLIK SIMPAN.
                </div>
              </div>
            </div>

            <div class="col-2 text-left">
              <a href="" class="btn btn-icon btn-lg btn-primary"><i class="fas fa-redo"></i></a>
            </div> -->
           
            <div class="col-lg-12">
           
              <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                  <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                  </button>
                    <?php echo $pesan_retur; ?>Pastikan memasukkan data dengan benar dan teliti.
                </div>
              </div>
            
              <div class="card card-primary">
                <div class="card-header">
                  <h4>
                   

                    <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahBarang"><i
                  class="fas fa-plus"></i> Tambah barang</a>
                 
                  </h4>

                  <?php echo form_open(base_url().'/fitur/retur', $form_kode_transaksi);    ?>
                  <?php echo csrf_field(); ?>
                  <div class="input-group">

                    <?php echo form_input($input_kode_transaksi); ?>
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>
                <?php  $i =1;?>
                <?php  $l =1;?>
                
                
                <?php echo form_open(base_url().'/fitur/retur/tambah_transaksi_sementara', $form_retur);    ?>
                <?php echo csrf_field(); ?>
                <div class="card-body">

                  <div class="row">

                    <div class="col-lg-12">

                      <div class="table-responsive">

                        <table class="table table-sm jik">
                          <thead>
                            <tr>
                              <th class="text-center" scope="col">#</th>
                              <th scope="col">Nama</th>
                              <th scope="col">Harga</th>
                              <th class="text-center" scope="col">QTY</th>
                              <th scope="col">Subtotal</th>
                              <th scope="col">Opsi</th>
                            </tr>
                          </thead>
                          <tbody id="tampil_transaksi">
                            <tr>
                              <th colspan="6" class="bg-secondary">
                                <h6 class="text-center ">Riwayat Transaksi <?php echo $nama_kode; ?></h6>


                              </th>
                            </tr>
                            <?php if($riwayat):  ?>

                            <?php foreach($riwayat as $r):?>

                            <?php if($r['tt_role_id'] == 4){
                              $harga = $r['harga_konsumen'];
                            }elseif($r['tt_role_id'] == 5){
                              $harga = $r['harga_anggota'];
                            }
                            
                            
                            ?>
                            <tr id="par-tab" class="par-tab">
                            <input type="hidden" class="form-control" name="kode_retur" value="<?php echo $kode_retur; ?>">
                              <input type="hidden" class="form-control" name="transaksi_total_id" value="<?php echo $r['id_transaksi_total']; ?>">
                              <input type="hidden" class="form-control" name="role_id" value="<?php echo $r['tt_role_id']; ?>"> 
                              <input type="hidden" class="form-control barang_id_riwayat" name="barang_id_riwayat[]" disabled value="<?php echo $r['t_barang_id']; ?>">
                              <td class="text-center"><?php echo $i; ?></td>
                              <td><?php echo $r['nama_barang']; ?></td>
                              <td class="td_harga_riwayat"><input type="text" readonly
                                  class="form-control harga_riwayat" data-hargariwayat="<?php  echo $harga; ?>"
                                  value="<?php  echo 'Rp. '. number_format($harga, 0,",","."); ?>"></td>
                              <td class="text-center td_qty_riwayat">
                                <input oninput="this.value = Math.abs(this.value)" min="1"
                                  max="<?php echo $r['t_qty']; ?>"
                                  data-qtyriwayat="<?php echo $r['t_qty']; ?>" class="form-control text-center qty_riwayat"
                                  type="number" name="qty_riwayat[]" value="<?php echo $r['t_qty']; ?>">
                              </td>
                            
                              <td class="tab-subtotal td_subtotal_riwayat"><input disabled readonly
                                  class="form-control subtotal_riwayat" type="text" name="subtotal_riwayat[]"
                                  value="<?php echo $r['t_harga']; ?>"></td>
                              <td class="tab-checkhar">
                                <div class="custom-control custom-checkbox tabcom tabcomp">
                                  <input data-subtotal="<?php echo $r['t_harga']; ?>"
                                    class="custom-control-input tab-mass tab-massp tab-cus" type="checkbox"
                                    id="customCheck<?php echo $r['t_barang_id']; ?>">
                                  <label class="custom-control-label" for="customCheck<?php echo $r['t_barang_id']; ?>">
                                    Pilih
                                  </label>
                                </div>
                              </td>

                            </tr>
                            <?php $i++;  ?>
                            <?php endforeach;?>
                           
                              <tr>
                                <th class="text-right" colspan="3">Total Transaksi <?php echo $nama_kode; ?></th>
                                <th colspan="1" class="td-qty"></th>
                                <th colspan="1" class="mopl"><input type="text" class="form-control tab-total"
                                    readonly></th>
                                <th colspan="1">
                                <th>
                              </tr>
                            

                            <?php else  : ?>

                            <?php endif; ?>
                            <tr>
                              <th colspan="6" class="bg-secondary">
                                <h6 class="text-center">Keranjang Retur</h6>
                              </th>
                            </tr>
                            <?php $sum=0;?>
                            <?php if($keranjang):  ?>

                            <?php foreach($keranjang as $k):?>



                            <tr id="par-tab">
                              <td class="text-center"><?php echo $l; ?></td>
                              <td><?php echo $k['nama_barang']; ?></td>
                              <td><?php echo 'Rp '. number_format($k['harga'], 0,",",".");  ?></td>
                              <td class="text-center"><?php echo $k['tt_qty']; ?></td>
                              
                              <td class="tab-subtotal">
                                <?php echo 'Rp '. number_format($k['tt_qty'] * $k['harga'], 0,",",".");  ?></td>
                              <?php $totals = $k['tt_qty'] * $k['harga'];?>
                              <?php $sum += $totals;?>
                              <td>
                                <a href="javascript:void(0)" class="btn btn-danger tombolhapusk"
                                  data-kode="<?php echo $k['kr_kode_keranjang']; ?>">Hapus</a>
                              </td>

                            </tr>
                            <?php $l++;  ?>
                            <?php endforeach;?>
                            <tr>
                              <th class="text-right" colspan="3">Total Transaksi Retur</th>
                              <th colspan="1" class="td-qty"></th>
                              <th colspan="1"><input value="<?php echo $sum; ?>" type="text"
                                  class="form-control tab-total-retur" readonly></th>
                              <th colspan="1">
                                <a href="javascript:void(0)" id="tombolhapuskalladmin" class="btn btn-danger">Hapus
                                  semua</a>
                              <th>

                            </tr>

                            <?php else  : ?>

                            <?php endif; ?>

                          </tbody>
                          <tbody id="tampil_total_transaksi">
                            <tr>
                              <th colspan="3" class="bg-secondary">
                                <h6 class="text-center">Hasil Retur Pas/Lebih</h6>
                              </th>
                              <th colspan="3" class="bg-secondary">
                                <h6 class="text-center">Hasil Retur Kurang</h6>
                              </th>
                            </tr>

                            <tr class="kembalian">
                              <th colspan="2">Kembalian</th>
                              <th colspan="1"><input type="text" name="kembalian_pl" class="form-control tab-kembalian" readonly></th>
                              <th colspan="1" class="text-center">Total Bayar</th>
                              <th colspan="1"><input type="text" min="0" oninput="this.value = Math.abs(this.value)"
                                  value="0" name="total_bayar_k" class="form-control tab-total-bayar" readonly></th>

                            </tr>

                            <tr class="jumlah-uang">
                              <th class="text-center" colspan="3"> </th>
                              <th colspan="1" class="text-center">Jumlah Uang</th>
                              <th colspan="1"><input name="jumlah_uang_k" oninput="this.value = Math.abs(this.value)" min="0" value="0"
                                  type="number" class="form-control tab-jumlah-uang jum-ung"></th>
                              <th colspan="1"></th>
                            </tr>
                            <tr class="kembalian-uang">
                              <th colspan="3"><button type="submit" class="btn btn-block btn-primary">Simpan</button></th>
                              <th colspan="1" class="text-center">Kembalian</th>
                              <th colspan="1"><input type="text" name="kembalian_k" readonly="" value="0"
                                  oninput="this.value = Math.abs(this.value)" min="0"
                                  class="form-control tab-kembalian-uang kem-ung"></th>
                              <th colspan="1"></th>


                            </tr>
                            <tr>
                              <th colspan="3"></th>
                              <th colspan="1"></th>
                              <th colspan="1" class="notif-kembalian"></th>
                              <th colspan="1"></th>


                            </tr>
                            <tr id="tr-total" class="invisible">
                              <th colspan="4">Total</th>
                              <th colspan="1"><input type="text" name="total_bayar_k" class="form-control tab-total-real" readonly></th>
                              <th colspan="1">
                              <th>
                                <input type="hidden" value="<?php echo $sum; ?>" class="form-control tab-total-fake"
                                  readonly>

                            </tr>
                          </tbody>

                        </table>
                       
                      </div>
                    </div>



                  </div>


                </div>
               
                <?php echo form_close(); ?>


              </div>
            </div>
          </div>
        </div>











      </div>

    </div>
  </section>
</div>


<!-- Modal -->
<div class="modal fade" id="modalPembelian" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-center text-light">Daftar Barang
          <div class="d-inline"><?php echo $nama_jenis_kasir; ?></div>
        </h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <div class="modal-body">

        <div class="row">
          


          <div class="col-lg-12">
          <?php if($barang): ?>
            <div class="table-responsive">
              <table class="table table-striped" id="rere">
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
            <?php else  : ?>



              
            <div class="empty-state" data-height="400">
              <div class="empty-state-icon">
                <i class="fas fa-question"></i>
              </div>
              <h2>Daftar barang kosong</h2>
              <p class="lead">
                Daftar barang akan ditampilkan setelah Anda mencari kode transaksi
              </p>
            


            </div>
        
              <?php endif; ?>





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
                <div class="empty-state" data-height="120">
                  <div class="empty-state-icon bg-danger">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin menghapus barang ini dari keranjang? </h2>
                  <p class="lead">
                    Riwayat transaksi akan terhapus juga, pastikan untuk mencari kembali
                    kode transaksi.
                  </p>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">

      <?php echo form_open(base_url().'/fitur/retur/hapus_barang', $form_hapus_barang);    ?>
        <?php echo form_input($hidden_kode_hapus_barang); ?>
        <?php echo csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

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
                <div class="empty-state" data-height="120">
                  <div class="empty-state-icon bg-danger">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin semua data keranjang?</h2>
                    <p class="lead">
                    Riwayat transaksi akan terhapus juga, pastikan untuk mencari kembali
                    kode transaksi.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">

      <?php echo form_open(base_url().'/fitur/retur/hapus_keranjang', $form_hapus_keranjang);    ?>
        <?php echo csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Hapus keranjang</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>