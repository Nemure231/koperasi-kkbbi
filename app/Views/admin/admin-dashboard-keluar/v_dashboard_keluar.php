<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<!-- Main Content -->
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">

      <div class="col-lg-4 col-md-6 col-sm-12 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-file"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Barang keluar hari ini</h4>
              </div>
              <div class="card-body">
                <?php 
                
                if(!$row_keluar_hari){
                  echo 'Rp. 0';
                }else{
                  echo 'Rp. '. number_format($row_keluar_hari['total_bkh'], 0,",",".").' ('.$row_keluar_hari['total_ttq'].')';
                }
                ?>
              </div>
              <div class="card-footer text-right">
              <a href="<?php echo base_url().'/laporan/keluar/harian' ?>">Lihat selengkapnya &rarr;</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-paste"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Barang keluar bulan ini</h4>
              </div>
              <div class="card-body">
                <?php 
                
                if(!$row_keluar_bulan){
                  echo 'Rp. 0';
                }else{
                  echo 'Rp. '. number_format($row_keluar_bulan['total_bkb'], 0,",",".").' ('.$row_keluar_bulan['total_ttq'].')';
                }
                ?>
              </div>
              <div class="card-footer text-right">
              <a href="<?php echo base_url().'/laporan/keluar/bulanan' ?>">Lihat selengkapnya &rarr;</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-file-alt"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Barang keluar tahun ini</h4>
              </div>
              <div class="card-body">
                <?php 
                
                if(!$row_keluar_tahun){
                  echo 'Rp. 0';
                }else{
                  echo 'Rp. '. number_format($row_keluar_tahun['total_bkt'], 0,",",".").' ('.$row_keluar_tahun['total_ttq'].')';
                }
                ?>
              </div>
              <div class="card-footer text-right">
              <a href="<?php echo base_url().'/laporan/keluar/tahunan' ?>">Lihat selengkapnya &rarr;</a>
              </div>

            </div>
          </div>
        </div>

        <div class="col-12 col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Statistik Summary Barang Keluar</h4>
              <div class="card-header-action">
                     
                      <div class="dropdown">
                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Lihat selengkapnya</a>
                        <div class="dropdown-menu">
                          <a href="<?php echo base_url().'/laporan/summary/tanggal' ?>" class="dropdown-item has-icon"><i class="fas fa-calendar-week"></i>Summary Tanggal</a>
                          <a href="<?php echo base_url().'/laporan/summary/bulan' ?>" class="dropdown-item has-icon"><i class="fas fa-calendar-alt"></i>Summary Bulan</a>
                          <a href="<?php echo base_url().'/laporan/summary/tahun' ?>" class="dropdown-item has-icon"><i class="far fa-calendar-alt"></i>Summary Tahun</a>
                        </div>
                      </div>
                    </div>
            </div>
            
            <div class="card-body">
              <ul class="nav nav-pills" id="myTab3" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                    aria-controls="home" aria-selected="true">Tanggal</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                    aria-controls="profile" aria-selected="false">Bulan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab"
                    aria-controls="contact" aria-selected="false">Tahun</a>
                </li>
              </ul>

              <div class="tab-content" id="myTabContent2">

                <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">

                  <div class="man" style="position: relative; height:40vh; width:auto;">
                    <canvas id="chartKeluarTanggal" height="180"></canvas>
                  </div>
                </div>


                <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                  <div class="man" style="position: relative; height:40vh; width:auto;">
                    <canvas id="chartKeluarBulan" height="180"></canvas>
                  </div>

                </div>


                <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">
                  <div class="man" style="position: relative; height:40vh; width:auto;">
                    <canvas id="chartKeluarTahun" height="180"></canvas>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>





       
        
       













      </div>
  </section>
</div>