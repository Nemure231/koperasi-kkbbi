<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/chocolat/dist/css/chocolat.css' ?>">
<style type="text/css">
  #qty_buku-error {
    color: #dc3545;
  }
</style>
<div  class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_pro')  ?>"></div>
<section class="section-margin">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 mt-5">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-4">
                <div class="row">
                  <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="display-4 mb-3" style="font-size: 23px;" id="judulD" name="juduld">
                      <?php echo $barang['nama_barang'] ?>
                    </div>
                    <div class="row">

                      <div class="form-group col-sm-12 col-md-12 col-lg-12 mb-4 pb-1">

                      <div class="chocolat-parent">
                          <a href="<?php echo base_url().'/admin/assets/barang/'. $barang['nama_gambar'] ?>"
                            class="chocolat-image" title="Pratinjau foto">
                            <div class="text-center">
                              <img alt="Foto kosong"
                                src="<?php echo base_url().'/admin/assets/barang/'. $barang['nama_gambar'] ?>"
                                class="img-fluid" style="height: 260px; width: 180px; object-fit:cover;">
                            </div>
                          </a>
                        </div>

                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="row">
                  <div class="form-group col-sm-12 col-md-12 col-lg-6">
                    <strong>Kategori</strong>
                    <!-- < ?php echo form_input//($input_genre); ?> -->
                    <p class="detail-buku text-dark" id="genred" name="genred">
                    
                      <a href="<?php echo base_url().'/kategori'.'/'. ''.$barang['kategori_id'].'' ?>"
                        class="badge badge-primary"><?php echo $barang['nama_kategori'] ?></a>
                      
                    </p>

                  </div>


                  <div class="form-group col-sm-12 col-md-12 col-lg-6">
                    <strong>Satuan</strong>
                    <!-- < ?php echo form_input//($input_penulis); ?> -->
                    <p class="detail-buku text-dark" id="penulisd" name="penulisd">
                  
                      <a href="<?php echo base_url().'/satuan'.'/'. ''.$barang['satuan_id'].'' ?>"
                        class="badge badge-primary"><?php echo $barang['nama_satuan'] ?></a>
                    
                    </p>

                  </div>

                  <div class="form-group col-sm-12 col-md-12 col-lg-6">
                    <strong>Merek</strong>
                    <!-- < ?php echo form_input//($input_penerbit); ?> -->
                    <p class="detail-buku text-dark" id="penerbitd" name="penerbitd">
                      
                      <a href="<?php echo base_url().'/merek'.'/'. ''.$barang['merek_id'].'' ?>"
                        class="badge badge-primary"><?php echo $barang['nama_merek'] ?></a>
                      
                    </p>


                  </div>
                  <div class="form-group col-sm-12 col-md-6 col-lg-6">
                    <strong>Penyuplai</strong>
                    <!-- < ?php echo form_input//($input_jenis_buku); ?> -->
                    <p class="detail-buku text-dark" id="jenis_bukud" name="jenis_bukud">
                      <a href="<?php echo base_url().'/penyuplai'.'/'. ''.$barang['penyuplai_id'].'' ?>"
                        class="badge badge-primary"><?php echo $barang['nama_penyuplai']; ?></a>
                    </p>

                  </div>

                  <div class="form-group col-sm-12 col-md-6 col-lg-6">
                    <strong>Harga Konsumen</strong>
                    <!-- < ?php echo form_input//($input_jenis_buku); ?> -->
                    <p class="detail-buku text-dark" id="harga_bukud" name="harga_bukud">
                      <?php echo 'Rp '. number_format($barang['harga_konsumen'], 0,",","."); ?>
                    </p>
                  </div>

                  <div class="form-group col-sm-12 col-md-6 col-lg-6">
                    <strong>Harga Anggota</strong>
                    <!-- < ?php echo form_input//($input_jenis_buku); ?> -->
                    <p class="detail-buku text-dark" id="harga_bukud" name="harga_bukud">
                      <?php echo 'Rp '. number_format($barang['harga_anggota'], 0,",","."); ?>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="row">

                  <div class="form-group col-sm-12 col-lg-12 col-md-12">
                    <strong>Deskripsi</strong>
                    <textarea class="form-control-plaintext" id="blurbd" readonly="" style="min-height:240px;"><?php echo $barang['deskripsi'] ?>
                    </textarea>
                  </div>

                
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>



    </div>

  </div>

</section>