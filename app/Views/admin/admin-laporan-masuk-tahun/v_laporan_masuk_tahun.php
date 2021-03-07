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
        <?php echo $pesan_tahun;  ?>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card" >
            <div class="card-header">
              <h4>Agar hasil print rapi, pastikan koneksi internet menyala.</h4>
              <div class="card-header-action">
                <a href="javascript:void(0)" id="print" class="btn btn-primary">
                  Print
                </a>
              </div>
            </div>

            <div class="card-body">
            <?php echo form_open(base_url().'/laporan/masuk/tahunan', $form_tahun);    ?>
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
                    <label>Form pencarian</label>
                    <div class="input-group">

                    <?php echo form_input($input_tahun); ?>
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
                  <h3 class="text-center">Laporan Barang Masuk Tahunan</h3>
                  <h3 class="text-center"><?php echo $toko['nama_toko']; ?></h3>
                  <h5 class="text-center"><?php echo $toko['alamat_toko']; ?></h5>
                  <h5 class="text-center mb-5">HP: <?php echo $toko['telepon_toko']; ?></h5>
                  <h5 class="text-right">Tahun <?php date_default_timezone_set("Asia/Jakarta"); echo  date('Y'); ?></h5>
                </div>
                <div class="col-2">
                <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                </div>
              </div>
              
              <div class="row">
              <?php if($tahun):  ?>
                
                <div class="table-responsive">
                <div class="row">

                 
                    <?php $sum=0;?>
                    <?php $sum_qty=0;?>

                    <?php
                            $urut = 0;
                            $nomor = 0;
                            $grup = '-';
                            foreach ($tahun as $b) {
                                if ($grup == '-' || $grup != $b['nama_pengirim_barang']) {
                                    $kat = $b['nama_pengirim_barang'];
                                    $hor = $b['tanggal_masuk'];
                                    
                                    

                                    if ($grup != '-')
                                        echo "</table></div>";
                                      

                                     

                                        echo "<div class='col-lg-6 col-md-6 col-sm-12'><table class='table table-sm'>";

                                       
                                      echo "<tr class='text-center'>
                                              <td colspan='9' style='text-align:right; border: 1px solid black; border-top:1px solid black; border-bottom:none;' colspan=''>
                                                <b>
                                                  ".$kat."
                                                  <div style='float:left;'>".'Tanggal & waktu: '.$hor."</div>
                                                  
                                                </b>
                                              </td>
                                            </tr>";

                                     
                                        echo "<tr>
                                              <th style='text-align:center; border: 1px solid black;' scope='col'>#</th>
                                              <th style='text-align:center; border: 1px solid black; border-right: none; border-left: none;' scope='col'>Nama Barang</th>
                                              <th style='text-align:center; border:1px solid black; ' scope='col'>Jumlah Barang</th>
                                              <th style='text-align:center; border:1px solid black; border-right: 1px solid black; border-left: none;' scope='col'>Harga Pokok</th>
                                              <th style='text-align:center; border:1px solid black; border-right: 1px solid black; border-left: none;' scope='col'>Subtotal</th>
                                              
                                             
                                      </tr>";
                                    $nomor = 1;
                                }
                                $grup = $b['nama_pengirim_barang'];
                                if ($urut == 500) {
                                    $nomor = 0;
                                    echo "<div class='pagebreak'> </div> ";
                                }
                                ?>
                    <tr>
                      <th class="text-center" style="border:1px solid black;" scope="row"><?php echo $nomor++ ?></th>
                      <td style="border:1px solid black; border-right: none; border-left: none;">
                        <?php echo $b['nama_barang']; ?></td>
                      <td class="text-center" style="border:1px solid black;"><?php echo $qty = $b['jumlah_barang_masuk']; ?></td>
                      <td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
                        <?php echo 'Rp. '. number_format($b['harga_pokok_pb'], 0,",","."); ?></td>
                      <td style="border:1px solid black; border-right: 1px solid black; border-left: none;">
                        <?php $total = $b['harga_pokok_pb'] * $b['jumlah_barang_masuk']; echo 'Rp. '. number_format($total, 0,",",".");?></td>

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
                          <th style="text-align: center; border: 1px solid black;" scope="col">Total Jumlah Barang</th>

                        </tr>
                      </thead>
                      <tbody>
                        <tr style="border: 1px solid black;">

                          <td style="text-align: center; border: 1px solid black;"><?php echo 'Rp. '. number_format($sum, 0,",","."); ?></td>
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
                    Kemungkinan tidak ada barang masuk pada tahun yang Anda cari. Silakan tekan tombol di bawah untuk me-refresh halaman, dan kembali ke daftar data tahun ini.
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