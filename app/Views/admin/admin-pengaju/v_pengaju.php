<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">

<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/chocolat/dist/css/chocolat.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/izitoast/css/iziToast.min.css' ?>">


<!-- Main Content -->

<style type="text/css">
  #yappa {
    padding-top: 50px;
  }

  #yahaloo {
    padding-top: -100px;
  }
</style>



<div id="pengajuan-sukses" data-flashdata="<?php echo $session->getFlashdata('pesan_sukses');  ?>"> </div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>
        <?php echo esc($title); ?>
      </h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">

            <?php if($pengaju):  ?>
            <!-- <//?php echo $session->getFlashdata('pesan_sukses');  ?> -->

            <div class="card-header">

              <!-- <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahKategori"><i
                  class="fas fa-plus"></i> Tambah Kategori</a> -->
            </div>
            <div class="card-body">

              <?php if($validation->hasError('alasan')):  ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>
                  <?php echo $validation->showError('alasan'); ?>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php endif;  ?>


              <div class="table-responsive">
                <table class="table table-striped" id="utut">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>

                      <th>Kode</th>
                      <th>Pengaju</th>
                      <th>Gambar Barang</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                      <th>Opsi</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php  $i =1;?>
                    <?php foreach($pengaju as $p):?>
                    <tr>
                      <td>
                        <?php echo $i; ?>
                      </td>

                      <td>
                        <?php echo $p['kode_pengajuan']; ?>
                      </td>
                      <td>
                        <?php echo $p['nama_pengaju']; ?>
                      </td>
                      <td>
                        <div class="chocolat-parent">
                          <a href="<?php echo base_url().'/admin/assets/barang/'. $p['nama_gambar'] ?>"
                            class="chocolat-image" title="Pratinjau foto">
                            <div class="text-center">
                              <img alt="Foto kosong"
                                src="<?php echo base_url().'/admin/assets/barang/'. $p['nama_gambar'] ?>"
                                class="img-fluid" style="width: 80x; height: 80px; object-fit: cover;">
                            </div>
                          </a>
                        </div>
                        </td>
                      <td>
                        <?php 
                        if($p['status_pengajuan'] == 1){
                          echo '<div class="badge badge-success">Menunggu barang</div>';
                        }else{
                          echo '<div class="badge badge-warning">Pending</div>';
                        }
                      
                      ?>
                      </td>
                      <td>
                        <?php echo $p['tanggal_pengajuan']; ?>
                      </td>


                      <td>
                      <?php if($p['status_pengajuan'] >= 2 ): ?>
                        <a href="javascript:void(0)" class="btn btn-primary tombol-terima"
                       
                          data-id_pengajuan="<?php echo $p['id_pengajuan']; ?>"
                          data-kode_pengajuan="<?php echo $p['kode_pengajuan']; ?>"
                          data-id_penyuplai="<?php echo $p['id_penyuplai']; ?>" 
                          >Terima</a>
                        
                        
                          <a href="javascript:void(0)" class="btn btn-danger tombol-tolak"
                        data-id_pengajuan=" <?php echo $p['id_pengajuan']; ?>"
                        data-kode_pengajuan="<?php echo $p['kode_pengajuan']; ?>"
                        data-alasan="Pastikan untuk memberikan alasan yang logis, sopan, dan tidak menyinggung"
                        data-id_penyuplai="<?php echo $p['id_penyuplai']; ?>"
                        >Tolak</a>
                          
                        <?php else: ?>

                          <a href="javascript:void(0)" class="btn btn-primary tombol-konfirm"
                          data-id_barang=" <?php echo $p['id_barang']; ?>" 
                          data-kode_pengajuan="<?php echo $p['kode_pengajuan']; ?>"
                          data-id_barang_masuk="<?php echo $p['id_barang_masuk']; ?>"
                          data-stok=" <?php echo $p['jumlah']; ?>"
                          data-id_pengajuan="<?php echo $p['id_pengajuan']; ?>"
                          data-id_penyuplai="<?php echo $p['id_penyuplai']; ?>" 
                          >Konfirm</a>
                        
                        
                          <a href="javascript:void(0)" class="btn btn-danger tombol-tolak"
                        data-id_pengajuan="<?php echo $p['id_pengajuan']; ?>"
                        data-kode_pengajuan="<?php echo $p['kode_pengajuan']; ?>"
                        data-alasan="Jika pengajuan sudah disetujui, tetapi barang belum dikirim lebih dari seminggu, Anda dapat menolaknya. Pastikan untuk memberikan alasan yang logis, sopan, dan tidak menyinggung"
                        data-id_penyuplai="<?php echo $p['id_penyuplai']; ?>" 
                        >Tolak</a>
                        
          
                       
                        <?php endif; ?>



                      </td>




                      <td>
                        <a href="javascript:void(0)" class="btn btn-info tombol-detail"
                          data-nama_barang="<?php echo $p['nama_barang']; ?>"
                          data-nama_kategori="<?php echo $p['nama_kategori']; ?>"
                          data-nama_satuan="<?php echo $p['nama_satuan']; ?>"
                          data-nama_merek="<?php echo $p['nama_merek']; ?>"
                          data-jumlah="<?php echo $p['jumlah']; ?>"
                          data-harga_pokok="<?php echo 'Rp. '. number_format($p['harga_pokok'], 0,",","."); ?>"
                        data-harga_anggota="<?php echo 'Rp. '. number_format($p['harga_anggota'], 0,",","."); ?>"
                        data-harga_konsumen="<?php echo 'Rp. '. number_format($p['harga_konsumen'], 0,",","."); ?>"
                          data-deskripsi="<?php echo $p['deskripsi']; ?>"
                          data-nama_gambar="<?php echo $p['nama_gambar']; ?>"
                          
                          > <i class="fas fa-info-circle"></i></a>

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
                <h2>Belum ada pendaftar</h2>
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

<!-- Modal -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Detail Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">


          

          <div class="col-lg-6">

            <div class="row">
              <div class="form-group col-lg-12 col-md-12">
                <label>Nama</label>
                <input type="text" id="nama_barang" class="form-control-plaintext" readonly />
              </div>


              <div class="form-group col-lg-12 col-md-6">
                <label>Kategori</label>
                <input type="text" id="nama_kategori" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-lg-6 col-md-6">
                <label>Satuan</label>
                <input type="text" id="nama_satuan" class="form-control-plaintext" readonly />
              </div>
              <div class="form-group col-lg-6 col-md-6">
                <label>Merek</label>
                <input type="text" id="nama_merek" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-lg-6 col-md-6">
                <label>Jumlah</label>
                <input type="text" id="jumlah" class="form-control-plaintext" readonly />
              </div>
            </div>



          </div>

          <div class="col-lg-6">

            <div class="row">

              <div class="form-group col-lg-12 col-md-4">
                <label>Harga Pokok</label>
                <input type="text" id="harga_pokok" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-lg-6 col-md-6">
                <label>Harga Konsumen</label>
                <input type="text" id="harga_konsumen" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-lg-6 col-md-6">
                <label>Harga Anggota</label>
                <input type="text" id="harga_anggota" class="form-control-plaintext" readonly />
              </div>

              <div class="form-group col-lg-12">
                <label>Deskripsi</label>
                <textarea rows="3" id="deskripsi" class="form-control-plaintext" readonly></textarea>
              </div>

  
            </div>




          </div>







        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-terima" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light"></h5>
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
                <div class="empty-state" data-height="80">
                  <div class="empty-state-icon bg-primary">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin menyetujui pengajuan ini?</h2>
                  <p class="lead">
                    
                  </p>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">
      <form action="<?php echo base_url().'/fitur/pengaju/terima' ?>" class="btn btn-block" method="post"
        accept-charset="utf-8">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="">
        <input type="hidden" name="kode_pengajuan_terima" id="kode_pengajuan_terima" value="">
        <input type="hidden" name="id_penyuplai_terima" id="id_penyuplai_terima" value="">
     
          <input type="hidden" name="_method" value="PUT">
          <button type="submit" class="btn btn-primary">Ya!</button>
            </form>

      </div>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-tolak" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Penolakan Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i style="font-size: 24px;" class="fas fa-10x fa-times"></i></span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <form action="<?php echo base_url().'/fitur/pengaju/tolak' ?>" class="btn btn-block" method="post"
        accept-charset="utf-8">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="kode_pengajuan_tolak" id="kode_pengajuan_tolak" value="">
        <input type="hidden" name="id_pengajuan_tolak" id="id_pengajuan_tolak" value="">
        <input type="hidden" name="id_penyuplai_tolak" id="id_penyuplai_tolak" value="">
        <input type="hidden" name="_method" value="PUT">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group text-left">
                <label>Alasan</label>
                <textarea class="form-control" style="min-height:145px;" id="alasan" name="alasan" value="" aria-describedby="teks-pembantu-tolak"></textarea>
                <small id="tekt-pembantu-tolak" class="form-text text-muted teks-alasan"></small>
              </div>


            </div>
          </div>

        </div>
        <div class="modal-footer">
          <!-- untuk mengirimkan ke database ci otomatis akan mengirimkannya jika typenya kita beri submit -->
          <!-- <a id="btn-simpan-hapus" class="btn btn-block btn-danger"><h6>Ya, hapus</h6></a> -->
          <button type="submit" class="btn btn-block btn-primary">Kirim</button>


        </div>
        <?php echo form_close(); ?>

    </div>
  </div>
</div>


<div class="modal fade" id="modal-konfirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light"></h5>
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
                <div class="empty-state" data-height="80">
                  <div class="empty-state-icon bg-primary">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin mengkonfirmasi pengajuan ini?</h2>
                  <p class="lead">
                    Pastikan barang sudah diterima dan detail barangnya sesuai.
                  </p>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">
      <form action="<?php echo base_url().'/fitur/pengaju/konfirm' ?>" class="btn btn-block" method="post"
        accept-charset="utf-8">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="kode_pengajuan_konfirm" id="kode_pengajuan_konfirm" value="">
        <input type="hidden" name="id_pengajuan_konfirm" id="id_pengajuan_konfirm" value="">
        <input type="hidden" name="id_barang" id="id_barang" value="">
        <input type="hidden" name="id_barang_masuk" id="id_barang_masuk" value="">
        <input type="hidden" name="id_penyuplai_konfirm" id="id_penyuplai_konfirm" value="">
        <input type="hidden" name="stok" id="stok" value="">
          <input type="hidden" name="_method" value="PUT">
          <button type="submit" class="btn btn-primary">Ya!</button>
            </form>

      </div>

    </div>
  </div>
</div>
