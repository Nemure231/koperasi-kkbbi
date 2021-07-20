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
                   
                   <?php echo $pesan_minggu; ?>
               
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
              <?php echo form_open(base_url().'/laporan/keluar', $form_minggu);    ?>
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
                          Jika ingin melihat data minggu kedua, pilihlah tanggal 8 sampai 14
                        </div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel"
                          aria-labelledby="list-messages-list">
                          Jika ingin melihat data minggu ketiga, pilihlah tanggal 15 sampai 21
                        </div>
                        <div class="tab-pane fade" id="list-settings" role="tabpanel"
                          aria-labelledby="list-settings-list">
                          Jika ingin melihat data minggu keempat, pilihlah tanggal 22 sampai 28
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
                        <option value="3">List Supplier</option>

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
                  <h3 class="text-center">Laporan Barang Keluar Mingguan</h3>
                  <h3 class="text-center"><?php echo $toko['nama_toko']; ?></h3>
                  <h5 class="text-center"><?php echo $toko['alamat_toko']; ?></h5>
                  <h5 class="text-center mb-5">HP: <?php echo $toko['telepon_toko']; ?></h5>
                  <h5 class="text-right"><?php  echo  $minggu_ini; ?></h5>
                  </div>
                <div class="col-2">
                <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                </div>
              </div>
                  <div class="row">
                    <?php if($minggu):  ?>

                    <div class="table-responsive">
                    <div class="row">

                     
                        <?php $sum=0;?>
                        <?php $sum_qty=0;?>
                        <?php $subtot=0;?>

                        <?php
          $urut = 0;
          $nomor = 0;
          $grup = '-';
          foreach ($minggu as $d) {
              if ($grup == '-' || $grup != $d['tt_kode_transaksi']) {
                $kat = $d['tt_kode_transaksi'];
                $hor = $d['tanggal'];
                $nam = $d['tt_nama_penerima'];
                $rol = $d['role'];
                $usr = $d['nama'];
                $th  = $d['tt_total_harga'];
                $jm = $d['tt_jumlah_uang'];
                $tk = $d['tt_kembalian'];
                $rl = $d['role'];
                

                if ($grup != '-')
                    echo "</table></div>";
                  

                  

                    echo "<div class='col-lg-6 col-md-6 col-sm-12'><table class='table table-sm'>";

                   
                  echo "<tr class='text-center'>
                          <td colspan='9' style='text-align:right; border-top:1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom:none;' colspan=''>
                            <b>
                              ".$kat."
                              <div style='float:left;'>".'Tanggal & waktu: '.$hor."</div>
                              
                            </b>
                          </td>
                        </tr>";

                        //$subtot += $har;

                        echo "<tr class='text-center'>
                        <td colspan='9' style='text-align:right; border: 1px solid black; border-top: none; border-bottom:none;' colspan=''>
                          <b>
                            Total Beli: ".'Rp. '. number_format($th, 0,",",".")."
                            <div style='float:left;'>".'Kasir: '.$usr."</div>
                            
                          </b>
                        </td>
                      </tr>";

                      echo "<tr class='text-center'>
                        <td colspan='9' style='text-align:right; border: 1px solid black; border-top: none; border-bottom:none;' colspan=''>
                          <b>
                          Jumlah Uang: ".'Rp. '. number_format($jm, 0,",",".")."
                            <div style='float:left;'>".'Nama pembeli: '.$nam."</div>
                            
                            
                          </b>
                        </td>
                      </tr>";

                     

                      echo "<tr class='text-center'>
                        <td colspan='9' style='text-align:right; border: 1px solid black; border-top: none; border-bottom:none;' colspan=''>
                          <b>
                            Kembalian: ".'Rp. '. number_format($tk, 0,",",".")."
                            <div style='float:left;'>".'Jenis pembeli: '.$rl."</div>
                            
                            
                          </b>
                        </td>
                      </tr>";


                    echo "<tr>
                          <th style='text-align:center; border: 1px solid black;' scope='col'>#</th>
                          <th style='text-align:center; border: 1px solid black; border-right: none; border-left: none;' scope='col'>Nama Barang</th>
                          <th style='text-align:center; border:1px solid black; ' scope='col'>QTY</th>
                          <th style='text-align:center; border:1px solid black; border-right: 1px solid black; border-left: none;' scope='col'>Harga Satuan</th>
                          <th style='text-align:center; border:1px solid black; border-right: 1px solid black; border-left: none;' scope='col'>Subtotal</th>
                          
                         
                  </tr>";
                  $nomor = 1;
              }
              $grup = $d['tt_kode_transaksi'];
              if ($urut == 500) {
                  $nomor = 0;
                  echo "<div class='pagebreak'> </div> ";
              }
              ?>
                        <tr>
                          <th class="text-center" style="border:1px solid black;" scope="row"><?php echo $nomor++ ?>
                          </th>
                          <td style="border:1px solid black; border-right: none; border-left: none;">
                            <?php echo $d['nama_barang']; ?></td>
                          <td class="text-center" style="border:1px solid black;"><?php echo $qty = $d['t_qty']; ?></td>
                          <td style="border:1px solid black; border-right: 1px solid black; border-left: none;">

                            <?php

          if($d['tt_role_id'] == 4){
            echo 'Rp. '. number_format($d['harga_konsumen'], 0,",",".");
          }elseif($d['tt_role_id'] == 5){
            echo 'Rp. '. number_format($d['harga_anggota'], 0,",",".");
          }
      
      
      ?>

                          </td>
                          <td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
                            <?php $total = $d['t_harga']; echo 'Rp. '. number_format($total, 0,",","."); ?></td>

                        </tr>

                        <?php $sum += $total;?>
                        <?php $sum_qty += $qty;?>



                        <?php
            }
            ?>

                        




                      </table></div></div>
                      <table class="table table-sm">
                          <thead>
                            <tr style="border: 1px solid black;">

                              <th style="text-align: center; border: 1px solid black;" scope="col">Total Harga</th>
                              <th style="text-align: center; border: 1px solid black;" scope="col">Total Jumlah Barang
                              </th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr style="border: 1px solid black;">

                              <td style="text-align: center; border: 1px solid black;">
                                <?php echo 'Rp. '. number_format($sum, 0,",",".");  ?></td>
                              <td style="text-align: center; border: 1px solid black;"><?php echo $sum_qty; ?></td>

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
                          Kemungkinan tidak ada transaksi pada renggang tanggal yang Anda cari. Silakan tekan tombol
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