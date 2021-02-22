
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<style type="text/css">
	#menu-error {
		color: #dc3545;
  }
  
</style>
<!-- Main Content -->
<div class="flashdatat" data-flashdata="<?php echo $session->getFlashdata('pesan_ttt')  ?>"></div>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">


          <?php if($transaksi): ?>
           

            <div class="card-header">
            Transaksi dalam proses
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datr">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Kode Transaksi</th>
                      <th>Nama Pemesan</th>
                      <th>Awal</th>
                      <th>Sampai</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php  $i =1;?>
                    <?php foreach($transaksi as $ts):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $ts['ts_kode_transaksi']; ?></td>
                      <td><?php echo $ts['nama']; ?></td>
                      <td><?php echo $ts['ts_awal']; ?></td>
                      <td><?php echo $ts['ts_sampai']; ?></td>
                      <td>
                        <a href="<?php echo base_url().'/transaksi'.'/'.''.$ts['ts_uri'].'' ?>" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                      </td>
                    </tr>
                    <?php $i++;  ?>
                    <?php endforeach;?>
                   
                  </tbody>
                </table>
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


