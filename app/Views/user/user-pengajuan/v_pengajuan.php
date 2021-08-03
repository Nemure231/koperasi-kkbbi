<section class="section-margin">
<link rel="stylesheet" type="text/css"
    href="<?php echo base_url().'/admin/assets/modules/izitoast/css/iziToast.min.css' ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/select2.min.css' ?>">
  
  <link rel="stylesheet" type="text/css"
    href="<?php echo base_url().'/admin/assets/modules/bootstrap-datepicker/datepicker.min.css' ?>">
    <style>
      .select2 {
width:100%!important;
}
.select2-container.select2-container-disabled .select2-choice {
  background-color: #ddd;
  border-color: #a8a8a8;
}
    </style>
    <div class="flash-data" id="pesan-pengajuan" data-flashdata="<?php echo $session->getFlashdata('pesan_sukses')  ?>">
  
  
  </div>
  <div class="container">
    <div class="row">


      <input type="hidden" id="csrf_barang" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
      <div class="col-lg-12" id="purgeall">
        <form action="<?php echo base_url().'/pengajuan/tambah' ?>"  enctype="multipart/form-data" method="post" accept-charset="utf-8">
        
          <input type="hidden" id="csrf_pengajuan" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
          <div class="card card-primary">
          <div class="card-header">
                    <h4>Pengajuan Barang</h4>
                    <div class="card-header-action">
                      <a href="<?php echo base_url('pengajuan/riwayat');?>" class="btn btn-primary">
                        Lihat riwayat pengajuan Anda
                      </a>
                    </div>
                  </div>


            <div class="card-body">

              <div class="row">


                <div class="col-lg-3 text-center">
                  <div class="row">
                    <div class="col-lg-12 mb-2">
                    <img src="<?php echo base_url('admin/assets/barang').'/'. 'default.jpg' ?>"
                      class="img-thumbnail img-prev" id="gambar" style="height: 310px; width: 220px; object-fit:cover;">
                    
                  
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-12">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input <?php echo ($validation->hasError('input_gambar')) ? 'is-invalid' : ''; ?>" id="input_gambar" name="input_gambar"
                          onchange="previewImg()">
                          <div class="invalid-feedback">
                        <?php echo $validation->showError('input_gambar'); ?>
                      </div>
                        <label class="custom-file-label text-left" for="Sampulbuku">Pilih gambar</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-5">

                  <div class="row">
                    <div class="form-group col-lg-12 col-md-12">
                      <label>Nama</label>
                      <select
                        class="form-control mb-2 <?php echo ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>"
                        name="nama" id="nama"  aria-describedby="teks-pembantu-barang">
                        <option value="">--Pilih / Isi--</option>
                        <?php foreach ($barang as $b) :?>

                        <option value="<?php echo $b['id'];?>">
                          <?php echo $b['nama'];?>
                        </option>
                        <?php endforeach;?>
                      </select>
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('nama'); ?>
                      </div>
                      <small id="tekt-pembantu-barang" class="form-text text-muted">
                          Pilihan ini memuat barang yang pernah Anda ajukan, jika barang belum pernah ada, silakan isi kolom dengan nama barang.
                      </small>

                    </div>

                    <!-- <input type="hidden" name="kategori_id" value="2">
                    <input type="hidden" name="satuan_id" value="2">
                    <input type="hidden" name="merek_id" value="2"> -->




                    <div class="form-group col-lg-12 col-md-6">
                      <label>Kategori</label>
                      <select
                        class="form-control mb-2 <?php echo ($validation->hasError('kategori_id')) ? 'is-invalid' : ''; ?>"
                        name="kategori_id" id="kategori_id">
                        <option value="">--Pilih / Isi--</option>
                        <?php foreach ($kategori as $k) :?>

                        <option value="<?php echo $k['id'];?>">
                          <?php echo $k['nama'];?>
                        </option>
                        <?php endforeach;?>
                      </select>
                      
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('kategori_id'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6">
                      <label>Satuan</label>
                      <select class="form-control mb-2 <?php echo ($validation->hasError('satuan_id')) ? 'is-invalid' : ''; ?>"
                        name="satuan_id" id="satuan_id">
                        <option value="">--Pilih / Isi--</option>
                        <?php foreach ($satuan as $s) :?>

                        <option value="<?php echo $s['id'];?>">
                          <?php echo $s['nama'];?>
                        </option>
                        <?php endforeach;?>
                      </select>
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('satuan_id'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6">
                      <label>Merek</label>
                      <select
                        class="form-control mb-2 <?php echo ($validation->hasError('merek_id')) ? 'is-invalid' : ''; ?>"
                        name="merek_id" id="merek_id">
                        <option value="">--Pilih / Isi--</option>
                        <?php foreach ($merek as $m) :?>

                        <option value="<?php echo $m['id'];?>">
                          <?php echo $m['nama'];?>
                        </option>
                        <?php endforeach;?>
                      </select>
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('merek_id'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6">
                      <label>Jumlah</label>
                      <input type="number" name="stok" id="stok"
                        class="form-control <?php echo ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>"
                        value="">

                      <div class="invalid-feedback">
                        <?php echo $validation->showError('stok'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6">
                      <label>Stok Sebelumnya</label>
                      <input type="number" id="stok_sebelum"
                        class="form-control"
                        value="" disabled>

                      
                    </div>

                    











                  </div>



                </div>

                <div class="col-lg-4">

                  <div class="row">
                    <!-- <div class="form-group col-lg-6 col-md-6">
                      <label>Pekerjaan</label>
                      <input type="text" name="pekerjaan" id="pekerjaan"
                        class="form-control <//?php echo ($validation->hasError('pekerjaan')) ? 'is-invalid' : ''; ?>"
                        value="<//?php echo set_value('pekerjaan', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <//?php echo $validation->showError('pekerjaan'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6">
                      <label>No KTP</label>
                      <input type="text" name="no_ktp" id="no_ktp"
                        class="form-control <//?php echo ($validation->hasError('no_ktp')) ? 'is-invalid' : ''; ?>"
                        value="<//?php echo set_value('no_ktp', '', TRUE); ?>">
                      <div class="invalid-feedback">
                        <//?php echo $validation->showError('no_ktp'); ?>
                      </div>
                    </div> -->

                   

                    <div class="form-group col-lg-12 col-md-4">
                      <label>Harga Pokok</label>
                      <input type="number" name="harga_pokok" id="harga_pokok"
                        class="form-control <?php echo ($validation->hasError('harga_pokok')) ? 'is-invalid' : ''; ?>"
                        value="">

                      <div class="invalid-feedback">
                        <?php echo $validation->showError('harga_pokok'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6">
                      <label>Harga Konsumen</label>
                      <input type="number" name="harga_konsumen" id="harga_konsumen"
                        class="form-control <?php echo ($validation->hasError('harga_konsumen')) ? 'is-invalid' : ''; ?>"
                        value="">

                      <div class="invalid-feedback">
                        <?php echo $validation->showError('harga_konsumen'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6">
                      <label>Harga Anggota</label>
                      <input type="number" name="harga_anggota" id="harga_anggota"
                        class="form-control <?php echo ($validation->hasError('harga_anggota')) ? 'is-invalid' : ''; ?>"
                        value="">

                      <div class="invalid-feedback">
                        <?php echo $validation->showError('harga_anggota'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-12">
                      <label>Deskripsi<small class="text-info"> (Opsional)</small></label>
                      <textarea name="deskripsi" rows="3" id="deskripsi"
                        class="form-control <?php echo ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>"></textarea>
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('deskripsi'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-12">
                    <button type="submit" id="tombol-pendaftaran" class="btn btn-block btn-primary">Simpan</button>
                    </div>

                    <!-- <div class="form-group col-lg-4 col-md-4">
                      <label>Tanggal</label>
                      <input type="text" name="tanggal" id="tanggal" class="form-control <//?php echo ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('tanggal', '', TRUE); ?>" aria-describedby="bantuan-tanggal">
                    
                      <small id="bantuan-tanggal" class="form-text text-muted">
                        Tanggal Konfirmasi Pendaftaran yang Anda inginkan.
                      </small>
                      <div class="invalid-feedback">
                        <//?php echo $validation->showError('tanggal'); ?>
                      </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-4">
                        <label>Dari</label>
                        
                          <input type="text" value="" class="form-control <//?php echo ($validation->hasError('waktu_awal')) ? 'is-invalid' : ''; ?>" name="waktu_awal" id="ts_awal" aria-describedby="bantuan-waktu-awal" >
                          <small id="bantuan-waktu-awal" class="form-text text-muted">
                        Waktu awal konfirmasi pendaftaran.
                      </small>
                        <div class="invalid-feedback">
                          <//?php echo $validation->showError('waktu_awal'); ?>
                        </div>
                      </div>
                    
                    
                      <div class="form-group col-lg-4 col-md-4">
                        <label>Sampai</label>
                        
                          <input type="text" value="" class="form-control <//?php echo ($validation->hasError('waktu_akhir')) ? 'is-invalid' : ''; ?>" name="waktu_akhir" id="ts_sampai" aria-describedby="bantuan-waktu-akhir">
                          <small id="bantuan-waktu-akhir" class="form-text text-muted">
                          Waktu awal konfirmasi pendaftaran.
                      </small>
                        
                        <div class="invalid-feedback">
                          <//?php echo $validation->showError('waktu_akhir'); ?>
                        </div>
                      </div>-->

                  </div>




                </div>

               





              </div>

            </div>
            <div class="card-footer text-right" id="heya">
             
              <!-- <a href="javascript:void(0)" class="btn btn-primary btn-submit" data-kodet=""
                id="tbhts">Bayar</a> -->
            </div>
          </div>
        </form>

      </div>





    </div>



  </div>

</section>