<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/chocolat/dist/css/chocolat.css' ?>">
<section class="section-margin">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php echo $session->getFlashdata('pesan')  ?>
      </div>

      <?php if($status_pendaftaran['status'] == 0): ?>
      <div class="col-12 col-md-6 col-lg-6">
        <div class="pricing">
          <div class="pricing-title">
            Konfirmasi
          </div>
          <div class="pricing-padding">
            <div class="pricing-price">
              <div>Offline</div>
            </div>
            <div class="pricing-details">
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Datang ke koperasi</div>
              </div>
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Pembayaran tunai</div>
              </div>
            </div>
          </div>
          <div class="pricing-cta">
            <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">
              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="status" value="2" />
              <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i
                  class="fas fa-arrow-right"></i></a>
            </form>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-6">
        <div class="pricing">
          <div class="pricing-title">
            Konfirmasi
          </div>
          <div class="pricing-padding">
            <div class="pricing-price">
              <div>Online</div>
            </div>
            <div class="pricing-details">

              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Mengunggah bukti transfer</div>
              </div>
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Pembayaran transfer</div>
              </div>



            </div>
          </div>
          <div class="pricing-cta">
            <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">

              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="status" value="1" />
              <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i
                  class="fas fa-arrow-right"></i></a>
            </form>
          </div>
        </div>
      </div>

      <?php endif; ?>

      <?php if($status_pendaftaran['status'] == 1): ?>
      <div class="col-12 col-md-8 col-lg-8">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Unggah foto bukti transfer</h4>
          </div>
          <div class="card-body">
            <div class="row d-flex justify-content-center">
              <div class="col-12 mb-3">
              <?php if($status_pendaftaran['bukti'] == NULL): ?>
              Setelah Anda berhasil mengunggah bukti transfer, Anda tidak dapat mengganti pilihan konfirmasi.
              <?php endif; ?>
                <div class="text-muted text-center">Pratinjau foto</div>
                <div class="chocolat-parent">
                  <?php $bukti_tf =  $status_pendaftaran['bukti'] ? $status_pendaftaran['bukti'] : 'default.jpg'; ?>
                  <a href="<?php echo base_url().'/admin/assets/bukti_transfer/'. $bukti_tf ?>" class="chocolat-image bukti-href"
                    title="Pratinjau foto">
                    <div class="text-center">
                      <img alt="image" src="<?php echo base_url().'/admin/assets/bukti_transfer/'. $bukti_tf ?>"
                        class="img-fluid bukti-img" style="width: 250px; height: 200px; object-fit: cover;">
                    </div>
                  </a>
                </div>
              </div>
              
             
              <div class="col-6">
                <form action="<?php echo base_url().'/konfirmasi/unggah-bukti' ?>" class="mb-2" enctype="multipart/form-data" method="post"
                accept-charset="utf-8">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="bukti_lama" value="<?php echo esc($status_pendaftaran['bukti']); ?>" />
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id_pendaftaran" value="<?php echo esc($status_pendaftaran['id_pendaftaran']); ?>" />
                  <div class="custom-file mb-3">
                    <input type="file" name="bukti" class="custom-file-input <?php echo ($validation->hasError('bukti')) ? 'is-invalid' : ''; ?>" id="bukti" onchange="previewImg()">
                    <div class="invalid-feedback">
                        <?php echo $validation->showError('bukti'); ?>
                      </div>
                    <label class="custom-file-label bukti-label" for="customFile">Pilih foto</label>
                  </div>
                  <button type="submit" class="btn btn-block btn-primary">Simpan</button>
              

                </form>
                <button id="tombol-rekening" class="btn btn-block btn-info">Daftar Rekening</button>
              </div>
                            <!-- Modal -->
              <div class="modal fade" id="modal-rekening" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-primary">
                      <h5 class="modal-title text-light">Daftar Rekening</h5>
                      <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
              
                      <div class="modal-body">
                        <table class="table">
                          
                          
                          <tbody>
                            <tr>
                              <th scope="row">BCA</th>
                              <td>0000000000000</td>
                             
                            </tr>
                            <tr>
                              <th scope="row">BRI</th>
                              <td>0000000000000</td>
                              
                            </tr>
                            <tr>
                              <th scope="row">MANDIRI</th>
                              <td>0000000000000</td>
                             
                            </tr>
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
      <?php if($status_pendaftaran['bukti'] == NULL): ?>
      <div class="col-md-4 col-lg-4">
        <div class="card card-primary">
          <div class="card-header">
            <h4 class="text-right">Ganti pilihan konfirmasi
            </h4>
          </div>
          <div class="card-body">
            <div class="pricing">
              <div class="pricing-title">
                Konfirmasi
              </div>
              <div class="pricing-padding">
                <div class="pricing-price">
                  <div>Offline</div>
                </div>
                <div class="pricing-details">
                  <div class="pricing-item">
                    <div class="pricing-item-icon bg-primary text-white">></i></div>
                    <div class="pricing-item-label">Datang ke koperasi</div>
                  </div>
                  <div class="pricing-item">
                    <div class="pricing-item-icon bg-primary text-white">></i></div>
                    <div class="pricing-item-label">Pembayaran tunai</div>
                  </div>
                </div>
              </div>
              <div class="pricing-cta">
                <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">
                  <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="status" value="2" />
                  <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i
                      class="fas fa-arrow-right"></i></a>
                </form>
              </div>
            </div>
          </div>
        </div>


      </div>
      <?php else: ?>
      <div class="col-lg-4 col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h4 class="text-right">Informasi
            </h4>
          </div>
          <div class="card-body text-justify">
            Foto bukti transfer Anda berhasil diunggah, sekarang Anda hanya perlu menunggu surel konfirmasi.
            Pemeriksaan bukti transfer dilakukan oleh sekretaris, oleh karena itu membutuhkan waktu paling lambat satu hari.
            <br><br>
            Setelah Anda berhasil mengunggah bukti transfer, Anda tidak dapat mengganti pilihan konfirmasi.
            <br><br>
            Namun, Anda masih dapat mengganti bukti transfer, jika foto tersebut salah.
          </div>
        </div>
      </div>

      <?php endif; ?>


      <?php endif; ?>

      <?php if($status_pendaftaran['status'] == 2): ?>
      <div class="col-12 col-md-6 col-lg-8">


        <div class="card card-primary">
          <div class="card-header">
            <h2 class="text-right">KODE KONFIRMASI:
              <?php echo $status_pendaftaran['kode']; ?>
            </h2>
          </div>
          <div class="card-body">
            <p>Anda memilih konfirmasi offline, pastikan Anda mengikuti langkah-langkah berikut:</p>
            <ol>
              <li>Datang ke koperasi KKBBI dan menyerahkan kode konfirmasi kepada Sekretaris</li>
              <li>Membayar uang sebesar Rp.100.000 kepada Sekretaris</li>
            </ol>
          </div>
        </div>

      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="card card-primary">
          <div class="card-header">
            <h4 class="text-right">Ganti pilihan konfirmasi
            </h4>
          </div>
          <div class="card-body">
            <div class="pricing">
              <div class="pricing-title">
                Konfirmasi
              </div>
              <div class="pricing-padding">
                <div class="pricing-price">
                  <div>Online</div>
                </div>
                <div class="pricing-details">

                  <div class="pricing-item">
                    <div class="pricing-item-icon bg-primary text-white">></i></div>
                    <div class="pricing-item-label">Mengunggah bukti transfer</div>
                  </div>
                  <div class="pricing-item">
                    <div class="pricing-item-icon bg-primary text-white">></i></div>
                    <div class="pricing-item-label">Pembayaran transfer</div>
                  </div>



                </div>
              </div>
              <div class="pricing-cta">
                <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">

                  <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="status" value="1" />
                  <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i
                      class="fas fa-arrow-right"></i></a>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>


      <?php endif; ?>







    </div>
  </div>

</section>