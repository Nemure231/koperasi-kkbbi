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
              <i class="fas fa-book-open"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Barang masuk hari ini</h4>
              </div>
              <div class="card-body">

                <?php 
                
                if(!$row_masuk_hari){
                  echo 'Rp. 0';
                }else{
                  echo 'Rp. '. number_format($row_masuk_hari['total_bmh'], 0,",",".").' ('.$row_masuk_hari['total_jbm'].')';
                }
                ?>

              </div>
              <div class="card-footer text-right">
                <a href="<?php echo base_url().'/laporan/masuk' ?>">Lihat selengkapnya &rarr;</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-people-carry"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Barang masuk bulan ini</h4>
              </div>
              <div class="card-body">
                <?php 
                  
                  if(!$row_masuk_bulan){
                    echo 'Rp. 0';
                  }else{
                    echo 'Rp. '. number_format($row_masuk_bulan['total_bmb'], 0,",",".").' ('.$row_masuk_bulan['total_jbm'].')';
                  }
                  ?>
              </div>
              <div class="card-footer text-right">
                <a href="<?php echo base_url().'/laporan/masuk' ?>">Lihat selengkapnya &rarr;</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-truck-loading"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Barang masuk tahun ini</h4>
              </div>
              <div class="card-body">

                <?php 
                
                if(!$row_masuk_tahun){
                  echo 'Rp. 0';
                }else{
                  echo 'Rp. '. number_format($row_masuk_tahun['total_bmt'], 0,",",".").' ('.$row_masuk_tahun['total_jbm'].')';
                }
                ?>
              </div>
              <div class="card-footer text-right">
                <a href="<?php echo base_url().'/laporan/masuk' ?>">Lihat selengkapnya &rarr;</a>
              </div>

            </div>
          </div>
        </div>

        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Statistik Summary Barang Masuk</h4>
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
                    <canvas id="chartMasukTanggal" height="180"></canvas>
                  </div>
                </div>


                <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                  <div class="man" style="position: relative; height:40vh; width:auto;">
                    <canvas id="chartMasukBulan" height="180"></canvas>
                  </div>

                </div>


                <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">
                  <div class="man" style="position: relative; height:40vh; width:auto;">
                    <canvas id="chartMasukTahun" height="180"></canvas>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>





       
       













      </div>
  </section>
</div>