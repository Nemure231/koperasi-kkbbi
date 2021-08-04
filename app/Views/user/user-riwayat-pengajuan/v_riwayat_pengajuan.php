<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<section class="section-margin">
  <div class="container">
    <div class="row">

      <!-- <div class="col-lg-12 mt-5 mb-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb text-white-all" style="background-color:#7676ff;">
            <li class="breadcrumb-item"><a href="<//?php echo base_url().'/' ?>">Beranda</a></li>
            <//?php if($jenis): ?>
              <li class="breadcrumb-item active" aria-current="page">Jenis Produk</li>
            <//?php else  : ?>
              <li class="breadcrumb-item active" aria-current="page">Data Kosong!</li>
            <//?php endif; ?>
          
          </ol>
        </nav>
      </div> -->


      <?php if($pengajuan): ?>

      <div class="col-lg-12 mt-5">

        <div class="card card-primary">
          <div class="card-header">
            <h4>Riwayat Pengajuan</h4>
          </div>
          <div class="card-body">
          <div class="table-responsive">
                <table class="table table-striped" id="tabel-pengajuan">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Kode</th>
                      <th>Status Pengajuan</th>
                      <th>Status Barang</th>
                      <th>Tanggal</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php  $i =1;?>
                    <?php foreach($pengajuan as $p):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $p['kode_pengajuan']; ?></td>
                      
                      <td>
                        <?php if ($p['status_pengajuan'] == 1){
                              echo '<div class="badge badge-success">Sukses</div>';
                            }elseif($p['status_pengajuan'] == 2){
                              echo '<div class="badge badge-warning">Tertunda</div>';
                            }else{
                              echo '<div class="badge badge-danger">Tertolak</div>';
                            }
                        ?>
                      </td>
                      <td>
                        <?php if ($p['status_barang'] == 1){
                              echo '<div class="badge badge-success">Pernah Ada</div>';
                            }elseif($p['status_barang'] == 2){
                              echo '<div class="badge badge-danger">Belum Pernah Ada</div>';
                            }
                        ?>
                      </td>
                      <td><?php echo $p['tanggal_pengajuan']; ?></td>
                      <td>
                        <a href="javascript:void(0)" class="btn btn-info tombol-detail-pengajuan"
                        data-nama_barang="<?php echo $p['nama_barang']; ?>"
                        data-jumlah="<?php echo $p['jumlah']; ?>"
                        data-nama_satuan="<?php echo $p['nama_satuan']; ?>"
                        data-nama_kategori="<?php echo $p['nama_kategori']; ?>"
                        data-nama_merek="<?php echo $p['nama_merek']; ?>"
                        data-harga_pokok="<?php echo 'Rp. '. number_format($p['harga_pokok'], 0,",","."); ?>"
                        data-harga_anggota="<?php echo 'Rp. '. number_format($p['harga_anggota'], 0,",","."); ?>"
                        data-harga_konsumen="<?php echo 'Rp. '. number_format($p['harga_konsumen'], 0,",","."); ?>"
                        data-deskripsi="<?php echo $p['deskripsi']; ?>"
                          
                          >
                          <i class="fas fa-info-circle"></i></a>
                          <?php if($p['status_pengajuan'] == 3): ?>
                          <a href="javascript:void(0)" class="btn btn-info tombol-alasan"
                        data-alasan="<?php echo $p['alasan']; ?>">Alasan</a>
                        <?php endif; ?>
                       
                          
                       

                      </td>
                      
                    </tr>
                    
                    <?php $i++;  ?>
                    <?php endforeach;?>
                   
                  </tbody>
                </table>
              </div>



          </div>
        </div>


      </div>

      <?php else  : ?>

      <div class="col-lg-12">

        <div class="empty-state" data-height="400">
          <div class="empty-state-icon bg-primary">
            <i class="ti-help"></i>
          </div>
          <h2>Data Kosong</h2>
          <p class="lead">
            Riwayat pengajuan kosong, Anda belum pernah pengajukan barang. Silakan tekan tombol dibawah untuk
            menampilkan halaman pengajuan.
          </p>
          <a href="<?php echo base_url().'/pengajuan' ?>" class="btn btn-primary mt-4">Pengajuan</a>
        </div>

      </div>


      <?php endif; ?>






    </div>
  </div>

</section>

<!-- Modal -->
<div class="modal fade" id="modal-detail-pengajuan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Detail Pengajuan</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama</label>
                <input type="text" id="nama_barang" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-3">
                <label>Jumlah</label>
                <input type="text" id="jumlah" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-9">
                <label>Kategori</label>
                <input type="text" id="nama_kategori" class="form-control-plaintext" readonly />
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Satuan</label>
                <input type="text" id="nama_satuan" class="form-control-plaintext" readonly />
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Merek</label>
                <input type="text" id="nama_merek" class="form-control-plaintext" readonly />
              </div>

              
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-6 col-lg-12">
                <label>Harga Pokok</label>
                <input type="text" id="harga_pokok" class="form-control-plaintext" readonly />
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Harga Anggota</label>
                <input type="text" id="harga_anggota" class="form-control-plaintext" readonly />
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Harga Konsumen</label>
                <input type="text" id="harga_konsumen" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Deskripsi</label>
                <textarea rows="5" type="text" id="deskripsi" class="form-control-plaintext" readonly></textarea>
              </div>





            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-alasan" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Alasan</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i style="font-size: 24px;" class="fas fa-10x fa-times"></i></span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->

      
       
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group text-left">
                
                <textarea class="form-control-plaintext text-justify" readonly style="min-height:145px;" id="alasan" value=""></textarea>
              </div>


            </div>
          </div>

        </div>
        <div class="modal-footer">
          
        </div>
       

    </div>
  </div>
</div>
