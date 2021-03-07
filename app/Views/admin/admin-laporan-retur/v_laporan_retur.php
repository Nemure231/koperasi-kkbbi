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

        <!-- <div class="col-12">
          <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th scope="col" class="text-center" colspan="5">Summary Bulan</th>
               
              </tr>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Bulan </th>
                <th scope="col">Total</th>
                <th scope="col">Bulan</th>
                <th scope="col">Total</th>
              </tr>
              <tr>
                <th scope="col" class="text-center bg-secondary" colspan="3">Masuk</th>
                <th scope="col" class="text-center bg-secondary" colspan="2">Keluar</th>
               
              </tr>
            </thead>
            <tbody>
              <//?php  $i =1;?>
              <//?php foreach($man as $m):?>
              <tr>
                <th scope="row"><//?php echo $i; ?></th>
                <td><//?php echo $m['nama_bulan2']; ?></td>
                <td><//?php echo $m['hargasum2']; ?></td>
                <td><//?php echo $m['nama_bulan']; ?></td>
                <td><//?php echo $m['hargasum']; ?></td>
              </tr>
              <//?php $i++;  ?>
              <//?php endforeach;?>
            </tbody>
          </table>


        </div> -->



        <div class="col-12">

          <?php echo $pesan_retur; ?>

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
              <?php echo form_open(base_url().'/laporan/retur', $form_retur);    ?>
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <div class="alert alert-primary alert-has-icon">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                      <div class="alert-title">Petunjuk</div>
                      Anda juga dapat melakukan pencarian pada renggang tanggal yang telah lewat menggunakan form
                      pencarian.
                    </div>
                  </div>



                </div>
                <div class="col-lg-6">

                  <div class="form-group">
                    <label>Form pencarian</label>
                    <div class="input-group">

                      <?php echo form_input($input_awal); ?>
                      <?php echo form_input($input_akhir); ?>
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
                      <h3 class="text-center">Laporan Retur</h3>
                      <h3 class="text-center"><?php echo $toko['nama_toko']; ?></h3>
                      <h5 class="text-center"><?php echo $toko['alamat_toko']; ?></h5>
                      <h5 class="text-center mb-5">HP: <?php echo $toko['telepon_toko']; ?></h5>
                      <h5 class="text-right"><?php  echo  $retur_ini; ?></h5>
                    </div>
                    <div class="col-2">
                      <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                    </div>
                  </div>
                  <div class="row">
                    <?php if($retur):  ?>

                    <div class="table-responsive">
                      <div class="row">


                        <?php $sum=0;?>
                        <?php $sum_qty=0;?>
                        <?php $subtot=0;?>

                        <?php
                          $urut = 0;
                          $nomor = 0;
                          $grup = '-';
                          foreach ($retur as $r) {
                              if ($grup == '-' || $grup != $r['trt_kode_retur']) {
                                $kat = $r['trt_kode_retur'];
                                $hor = $r['trt_tanggal'];
                                $nam = $r['tt_nama_penerima'];
                                $tkt = $r['tt_kode_transaksi'];
                                $rol = $r['role'];
                                $usr = $r['nama'];
                                $ps = $r['trt_hp_kembalian'];
                                $th  = $r['trt_hk_total_bayar'];
                                $jm = $r['trt_hk_jumlah_uang'];
                                $tk = $r['trt_hk_kembalian'];
                                $nth = $r['trt_n_total_harga'];
                                $rth = $r['trt_r_total_harga'];

                              
                                if($ps == 0){
                                  //kembalian
                                  $epas= $tk;
                                }else{
                                  $epas = $ps;
                                }
                                
                                

                                if ($grup != '-')
                                
                                    echo "</table></div>";
                  
                                    echo "<div class='col-12 col-12 col-12'><table class='table table-sm'>";

                                    echo "<tr class='text-center'>
                                            <td colspan='9' style='text-align:right; border-top:1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom:none;' colspan=''>
                                              <b>
                                                ".$kat.'/'.$tkt."
                                                <div style='float:left;'>".'Tanggal & waktu: '.$hor."</div>
                                                
                                              </b>
                                            </td>
                                          </tr>";

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
                                        Kembalian: ".'Rp. '. number_format($epas, 0,",",".")."
                                        <div style='float:left;'>".'Jenis pembeli: '.$rol."</div>
                                        
                                        
                                      </b>
                                    </td>
                                  </tr>";


                                  echo "<tr><th colspan='5' style='border: 1px solid black; background-color:#cdd3d8 !important;'>
                                  <h6 class='text-center '>Riwayat</h6>
                                </th>
                                <th colspan='4' style='border: 1px solid black; background-color:#cdd3d8 !important;'>
                                  <h6 class='text-center '>Tukar</h6>
                                </th></tr>";

                                echo "<tr><th colspan='5' style='border: 1px solid black; background-color:#cdd3d8 !important;'>
                                  <strong>Total Riwayat: ".'Rp. '. number_format($rth, 0,",",".")."</strong>
                                </th>
                                <th colspan='4' style='border: 1px solid black; background-color:#cdd3d8 !important;'>
                                  <strong>Total Tukar: ".'Rp. '. number_format($nth, 0,",",".")."</strong>
                                </th></tr>";

                                echo "<tr>
                                        <th style='text-align:center; border: 1px solid black;' scope='col'>#</th>
                                        <th style='text-align:center; border: 1px solid black; border-right: none; border-left: none;' scope='col'>Nama(R)</th>
                                        <th style='text-align:center; border:1px solid black; ' scope='col'>Harga(R)</th>
                                        <th style='text-align:center; border:1px solid black; ' scope='col'>QTY(R)</th>
                                        <th style='text-align:center; border:1px solid black; border-right: 1px solid black; border-left: none;' scope='col'>Subtotal(R)</th>
                                        <th style='text-align:center; border: 1px solid black; border-right: none; border-left: none;' scope='col'>Nama(T)</th>
                                        <th style='text-align:center; border:1px solid black; ' scope='col'>Harga(T)</th>
                                        <th style='text-align:center; border:1px solid black; ' scope='col'>QTY(T)</th>
                                        <th style='text-align:center; border:1px solid black; border-right: 1px solid black; border-left: none;' scope='col'>Subtotal(T)</th>
                                      
                                        </tr>";
                              $nomor = 1;
                          }
                          $grup = $r['trt_kode_retur'];
                          if ($urut == 500) {
                              $nomor = 0;
                              echo "<div class='pagebreak'> </div> ";
                          }
                          ?>
                        <tr>
                          <th class="text-center" style="border:1px solid black;" scope="row"><?php echo $nomor++ ?>
                          </th>
                          <td style="border:1px solid black; border-right: none; border-left: none;">
                            <?php echo $r['r_nama']; ?></td>

                          <td class="text-center" style="border:1px solid black;">

                            <?php if($r['trt_role_id'] == 4): ?>
                            <?php echo $r['r_harga_konsumen']; ?>
                            <?php else  : ?>
                            <?php echo $r['r_harga_anggota']; ?>
                            <?php endif; ?>


                          </td>



                          <td class="text-center" style="border:1px solid black;">

                            <?php if($r['r_qty'] == 0): ?>
                            -
                            <?php else  : ?>
                            <?php echo $r['r_qty']; ?>
                            <?php endif; ?>

                          </td>

                          <td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
                            <?php if($r['r_subtotal'] == 0): ?>
                            -
                            <?php else  : ?>
                            <?php echo $r['r_subtotal']; ?>
                            <?php endif; ?>


                          </td>


                          <td
                            style="<?php echo ($r['n_nama'] != '') ? 'background-color: #fc544b !important; color: white; border:1px solid black; border-right: none; border-left: none;' : 'border:1px solid black; border-right: none; border-left: none;'; ?>">
                            <?php if($r['n_nama'] == ''): ?>
                            -
                            <?php else  : ?>
                            <?php echo $r['n_nama']; ?>
                            <?php endif; ?>

                          </td>

                          <td class="text-center"
                            style="<?php echo ($r['n_harga_konsumen'] != 0 && $r['n_harga_anggota'] != 0) ? 'background-color: #fc544b !important; color: white; border:1px solid black; border-right: none;' : 'border:1px solid black; border-right: none;'; ?>">

                            <?php if($r['trt_role_id'] == 4): ?>
                            <?php echo $r['n_harga_konsumen']; ?>
                            <?php else  : ?>
                            <?php echo $r['n_harga_anggota']; ?>
                            <?php endif; ?>

                          </td>


                          <td class="text-center"
                            style="<?php echo ($r['n_qty'] != 0) ? 'background-color: #fc544b !important; color: white; border:1px solid black;' : 'border:1px solid black;'; ?>">

                            <?php if($r['n_qty'] == 0): ?>
                            -
                            <?php else  : ?>
                            <?php echo $r['n_qty']; ?>
                            <?php endif; ?>

                          </td>

                          <td
                            style="<?php echo ($r['n_subtotal'] != 0) ? 'background-color: #fc544b !important; color: white; border:1px solid black; border-right: 1px solid black; border-left: none;' : 'border:1px solid black; border-right: 1px solid black; border-left: none;'; ?>">
                            <?php if($r['n_subtotal'] == 0): ?>
                            -
                            <?php else  : ?>
                            <?php echo $r['n_subtotal']; ?>
                            <?php endif; ?>


                          </td>





                        </tr>


                        <!-- <//?php   $sum += $total;?> -->
                        <!-- < ?php $sum_qty += $qty;?> -->



                        <?php
                    }
                    ?>



                        </table>

                      </div>
                    </div>
                    <!-- <table class="table table-sm">
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
                                <//?php echo 'Rp. '. number_format($sum, 0,",",".");  ?></td>
                              <td style="text-align: center; border: 1px solid black;">< ?php echo $sum_qty; ?></td>

                            </tr>
                          </tbody>
                        </table> -->
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