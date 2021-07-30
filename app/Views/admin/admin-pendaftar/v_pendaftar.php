<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/modules/izitoast/css/iziToast.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/chocolat/dist/css/chocolat.css' ?>">


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

            <?php if($pendaftar):  ?>

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
                      <th>Nama</th>
                      <th>Jenis</th>
                      <th>Tanggal</th>


                    
                      <th>Bukti</th>
                      <th>Konfirm</th>
                    
                  


                      <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>
                
                    <?php  $i =1;?>
                    <?php foreach($pendaftar as $p):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $p['nama']; ?></td>
                      <td><?php 
                        if($p['status_konfirmasi'] == 1){
                          echo '<div class="badge badge-success">Online</div>';
                        }else{
                          echo '<div class="badge badge-danger">Offline</div>';
                        }
                      
                      ?>
                      </td>
                      <td><?php echo $p['tanggal']; ?></td>

                      <?php if($p['status_konfirmasi'] == 2): ?>
                      <td class="text-center">
                      
                        
                              <input type="hidden" name="id_penyuplai" value="<?php echo $p['id_penyuplai']; ?>" class="form-control" placeholder="" aria-label="">
                              <input placeholder="Kode konfirmasi ...." type="text" name="kode" class="form-control <?php echo ($validation->hasError('kode')) ? 'is-invalid' : ''; ?>" placeholder="" aria-label="">
                    
                              <div class="invalid-feedback">
                                <?php echo $validation->showError('kode'); ?>
                              </div>
                        
                        </form>
                      </td>
                      <?php endif; ?>
                      <?php if($p['status_konfirmasi'] == 1): ?>
                        <td>
                      

                          <div class="chocolat-parent">
               
                  <a href="<?php echo base_url().'/admin/assets/bukti_transfer/'. $p['bukti'] ?>" class="chocolat-image bukti-href"
                    title="Pratinjau foto">
                    <div class="text-center">
                      <img alt="image" src="<?php echo base_url().'/admin/assets/bukti_transfer/'. $p['bukti'] ?>"
                        class="img-fluid bukti-img" style="width: 100x; height: 100px; object-fit: cover;">
                    </div>
                  </a>
                </div>
                        </td>
                      <?php endif; ?>
                      
                      <?php if($p['status_konfirmasi'] == 1): ?>
                        
                      <td>
                      <form action="<?php echo base_url().'/pendaftaran/konfirmasi-online' ?>" method="post" accept-charset="utf-8">
                      <button type="submit" class="btn btn-primary">Konfirm</button>
                      </form>
                        
                      </td>
                      <?php endif; ?>
                      <?php if($p['status_konfirmasi'] == 2): ?>
                        <td>
                        <form action="<?php echo base_url().'/pendaftaran/konfirmasi-offline' ?>" method="post" accept-charset="utf-8">
                        <button type="submit" class="btn btn-primary">Konfirm</button>
                        </form>
                        
                        </td>
                        <?php endif; ?>
                     
                      <td>
                      <a href="javascript:void(0)" class="btn btn-info tombol-pendaftar"
                          data-nama="<?php echo $p['nama']; ?>"
                          data-telepon="<?php echo $p['telepon']; ?>"
                          data-no_ktp="<?php echo $p['no_ktp']; ?>"
                          data-surel="<?php echo $p['surel']; ?>"
                          data-pekerjaan="<?php echo $p['pekerjaan']; ?>"
                          data-no_rekening="<?php echo $p['no_rekening']; ?>"
                          data-bank="<?php echo $p['bank']; ?>"
                          data-atas_nama="<?php echo $p['atas_nama']; ?>"
                          data-alamat="<?php echo $p['alamat']; ?>"
                          >
                          <i class="fas fa-info-circle"></i></a>
              
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
<div class="modal fade" id="modal-pendaftar" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light">Detail Pendaftar</h5>
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
                <input type="text" id="nama" class="form-control-plaintext" readonly/>
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Nomor Telepon</label>
                <input type="text" id="telepon" class="form-control-plaintext" readonly/>
               
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Nomor KTP</label>
                <input type="text" id="no_ktp" class="form-control-plaintext" readonly/>
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Surel</label>
                <input type="text" id="surel" class="form-control-plaintext" readonly/>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-12">
                <label>Pekerjaan</label>
                <input type="text" id="pekerjaan" class="form-control-plaintext" readonly/>
              </div>
             
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>No Rekening</label>
                <input type="text" id="no_rekening" class="form-control-plaintext" readonly/>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Bank</label>
                <input type="text" id="bank" class="form-control-plaintext" readonly/>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-12">
                <label>Atas Nama</label>
                <input type="text" id="atas_nama" class="form-control-plaintext" readonly/>
              </div>
             

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Alamat</label>
                <textarea rows="5" type="text" id="alamat" class="form-control-plaintext" readonly></textarea>
              </div>

             

            
             
            </div>

          </div>
        </div>

        </div>
		</div>
	</div>
</div>

