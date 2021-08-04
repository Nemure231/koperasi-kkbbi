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
                   
     
            <?php echo $session->getFlashdata('pesan_data')['pesan'] ??''; ?>
          
               
           </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4></h4>
              <div class="card-header-action">
                <a href="javascript:void(0)" id="print" class="btn btn-primary">
                  Print
                </a>
              </div>
            </div>

            <div class="card-body">


                <div class="row">
                <div class="col-lg-6 mb-2">
                <div class="alert alert-primary alert-has-icon">
                      <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">Petunjuk</div>
                        Anda juga dapat melakukan pencarian pada bulan yang telah lewat menggunakan form pencarian.
                      </div>
                    </div>
                  
                   
                
                  </div>
                
                  <div class="col-lg-6">
                  <?php echo form_open(base_url().'/laporan/keuangan-bulanan/cari', $form_bulan);    ?>
            <?php echo csrf_field(); ?>
                    <div class="form-group">
                    <label>Form pencarian</label>
                        <div class="input-group">
                       
                      <input type="text" name="cari_bulan" id="cari_bulan" placeholder="Cari cari bulan...."
                      class ="form-control <?php echo ($validation->hasError('cari_bulan')) ? 'is-invalid' : ''; ?>" required/>
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('cari_bulan'); ?>
                      </div>
                      <input type="text" name="cari_tahun" id="cari_tahun" placeholder="Cari cari tahun...."
                      class ="form-control <?php echo ($validation->hasError('cari_tahun')) ? 'is-invalid' : ''; ?>" required/>
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('cari_tahun'); ?>
                      </div>
                     

  
                      

                      
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                  </div>
                  
              

                </div>
               
              <div class="row" id="area-1">
               
                <div class="col-lg-12">
                <div class="row">
                  <div class="col-2">
                  <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_koperasi_inter']); ?>"
                          style="width:150px; height: 150px; object-fit:cover;">
                  </div>
                  <div class="col-8">
                  <h3 class="text-center">Laporan Keuangan Bulanan</h3>
                  <h3 class="text-center"><?php echo $toko['nama_toko']; ?></h3>
                  <h5 class="text-center"><?php echo $toko['alamat_toko']; ?></h5>
                  <h5 class="text-center mb-5">HP: <?php echo $toko['telepon_toko']; ?></h5>
                  <h5 class="text-right"><?php  echo  $bulan_tahun; ?></h5>
                  </div>
                <div class="col-2">
                <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                </div>
              </div>
                  <div class="row">
                  <?php if($validation->hasError('nama_pengeluaran')):  ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>
                        <?php echo $validation->showError('nama_pengeluaran'); ?>
                      </strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php endif;  ?>
                  <?php if($validation->hasError('total_pengeluaran')):  ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>
                        <?php echo $validation->showError('total_pengeluaran'); ?>
                      </strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php endif;  ?>
                  

                      <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Barang Keluar</th>
                          <th scope="col">Barang Masuk</th>
                          <th scope="col">Margin Laba</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row"> <?php echo $session->getFlashdata('pesan_data')['tahun_bulan'] ?? ''; ?></th>
                          <td><?php echo $session->getFlashdata('pesan_data')['total_barang_keluar'] ?? 0; ?></td>
                          <td><?php echo $session->getFlashdata('pesan_data')['total_barang_masuk'] ?? 0; ?></td>

                          <?php $keluar = $session->getFlashdata('pesan_data')['total_barang_keluar'] ?? 0; ?>
                          <?php $masuk = $session->getFlashdata('pesan_data')['total_barang_masuk'] ?? 0; ?>

                          <?php $total = ($masuk - $keluar); ?></td>
                          <td><?php echo  str_replace("-", "", $total); ?></td>
                        </tr>

                        <tr>
                          
                          <th scope="row">Jumlah Penjualan Barang</th>
                          <td><?php echo $session->getFlashdata('pesan_data')['total_barang_keluar'] ?? 0; ?></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th scope="row">Pendaftarn</th>
                          <td><?php echo $session->getFlashdata('pesan_data')['total_pendaftaran'] ?? 0; ?></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th scope="row">Utang Barang Masuk</th>
                          <td><?php echo $session->getFlashdata('pesan_data')['total_barang_masuk'] ?? 0; ?></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th scope="row">Cash On Hand</th>
                          <td>Hasil Perhitungan</td>
                          <td><a class="btn btn-primary" id="hitung_keuangan" href="javascript:void(0)">Hitung</a></td>
                          <td></td>
                        </tr>
                        <thead>
                        <tr>
                          <th colspan="4"class="text-center">Pengeluaran</th>
                        </tr>

                        <form action="<?php echo base_url().'/laporan/keuangan-bulanan/tambah' ?>" class="btn btn-block" method="post" accept-charset="utf-8">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="bulan_pengeluaran" value="<?php echo $tanggal['bulan'] ?>">
                          <input type="hidden" name="tahun_pengeluaran" value="<?php echo $tanggal['tahun'] ?>">
                        <tr>
                          
                          <td><input type="text" name="nama_pengeluaran[]" class="form-control" placeholder="Nama pengeluaraan"></input></td>
                          <td><input type="number" name="total_pengeluaran[]" class="form-control" placeholder="Total pengeluaraan"></input></td>
                          <td><a class="btn btn-icon btn-primary" id="tambah_input" href="javascript:void(0)">Tambah Input <i class="fas fa-plus"></i></a></td>
                          <td><button type="submit" class="btn btn-primary">Simpan</button></td>
                        </tr>
                        <tr>
                          
                          <td><input type="text" name="nama_pengeluaran[]" class="form-control" placeholder="Nama pengeluaraan"></input></td>
                          <td><input type="number" name="total_pengeluaran[]" class="form-control" placeholder="Total pengeluaraan"></input></td>
                          <td></td>
                          <td></td>
                        </tr>
                    </form>


                      </thead>

                        


                        
                      </tbody>
                    </table>






                  




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