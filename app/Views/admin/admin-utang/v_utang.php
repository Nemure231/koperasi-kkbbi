<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">


<!-- Main Content -->

<style type="text/css">
  #yappa {padding-top: 50px;}

  #yahaloo {padding-top: -100px;}
</style>


<!-- <div class="flash-data" data-flashdata="<//?php echo $session->getFlashdata('pesan_kategori')  ?>"></div> -->
<div class="flash-data-invoice-utang-hapus" data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_invoice_utang');  ?>"></div>
<div class="flash-data-invoice-utang-simpan" data-flashdata="<?php echo $session->getFlashdata('pesan_simpan_invoice_utang');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>
    <div class="section-body">
    <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">

            <?php if($utang):  ?>

            <div class="card-header">

              <!-- <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahKategori"><i
                  class="fas fa-plus"></i> Tambah Kategori</a> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="utut">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Kode Transaksi</th>
                      <th>Nama Pengutang</th>
                      <th>Nomor  Telepon</th>
                      <th>Tanggal</th>
                      <th class="text-center">Hari</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  $i =1;?>
                    <?php foreach($utang as $u):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $u['ts_kode_transaksi']; ?></td>
                      <td><?php echo $u['ts_nama_pengutang']; ?></td>
                      <td><?php echo $u['ts_nomor_pengutang']; ?></td>
                      <td><?php echo $u['ts_tanggal_sementara']; ?></td>
                      <td class="text-center"><span class="badge badge-danger"><?php echo $u['waktu']; ?></span></td>
                      <td>
                      <a href="<?php echo base_url().'/kasir/invoice_utang'.'/'.''.$u['ts_uri'].'' ?>" class="btn btn-primary"><i class="fas fa-eye"></i></a>
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
                <div class="empty-state-icon">
                  <i class="fas fa-question"></i>
                </div>
                <h2>Belum ada utang</h2>
                <p class="lead">
                  Silakan periksa lagi lain kali
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

