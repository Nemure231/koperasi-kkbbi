<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/jquery-ui/jquery-ui.min.css' ?>">
<style type="text/css">
  #nama_pengirim_barang-error {
    color: #dc3545;
  }

  .select2 {
    width: 100% !important;
  }
</style>
<div class="flash-data-barang" data-flashdata="<?php echo $session->getFlashdata('pesan_barangL');  ?>"></div>
<div class="flash-data-pengirim" data-flashdata="<?php echo $session->getFlashdata('pesan_pengirim');  ?>"></div>
<div class="flash-data-barang-masuk" data-flashdata="<?php echo $session->getFlashdata('pesan_barang_masuk');  ?>">
</div>
<!-- Main Content -->

<div class="main-content">

  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary mr-3" id="tombol-modal-barang"><i
                  class="fas fa-plus"></i> Tambah barang</a>
              <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombol-modal-supplier"><i
                  class="fas fa-plus"></i> Tambah Supplier</a>

            </div>

            <div class="col-lg-12 vom">
              <div class="card">
                <div class="card-header">
                  <h4>Tambah barang masuk</h4>
                  <div class="card-header-action">
                    <a class="btn btn-icon btn-primary" id="tambah_input" href="javascript:void(0)">Tambah Input</a>
                  </div>
                </div>
                <?php echo form_open(base_url().'/fitur/barang_masuk/tambah_barang', $form_tambah_barang_masuk);    ?>
                <div class="card-body vim" id="tampil_input">
                  <div class="row par">
                    <div class="col-lg-11 col-md-11 col-sm-10 cil1">
                      <div class="row cil2">

                        <div class="form-group col-lg-4 col-md-5 col-sm-12">
  
                          <label>Barang</label>

                          <select required="" class="custom-select barang_id" placeholder="Barang ...."
                            name="barang_id[]" id="inputGroupSelect05">
                            <option value=""></option>
                            <?php foreach ($barang as $b):?>
                            <option value="<?php echo $b['id_barang']; ?>"><?php echo $b['nama_barang']; ?>
                            </option>
                            <?php endforeach;  ?>
                          </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-5 col-sm-8">
                          <label>Pengirim</label>
                          <select required="" class="custom-select pengirim_barang_id" id="pengirim_barang_id"
                            data-uniq="1" name="pengirim_barang_id[]">

                            <option value=""></option>
                            <?php foreach ($supplier as $p):?>
                            <option value="<?php echo $p['id_supplier']; ?>">
                              <?php echo $p['nama_supplier']; ?>
                            </option>
                            <?php endforeach;  ?>

                          </select>
                        </div>

                        <div class="form-group col-lg-2 col-md-2 col-sm-4">
                          <label>Jumlah</label>
                          <?php echo form_input($input_jumlah_barang_masuk); ?>
                        </div>

                        <div class="form-group col-lg-3 col-md-12 col-sm-12 cilp3">
                          <label>Harga Pokok</label>
                          <div class="input-group mb-2 cilp4">
                            <div class="input-group-prepend cilp5">
                              <div class="input-group-text cilp6">

                                <div class="control-label"></div>
                                <label class="custom-switch cilp7">

                                  <input type="checkbox" name="custom-switch-checkbox"
                                    class="custom-switch-input ubah-pokok gembok-pokok">
                                  <span class="custom-switch-indicator"></span>

                                </label>


                              </div>
                            </div>
                            <?php echo form_input($input_harga_pokok); ?>
                          </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6 cilg3">
                          <label>Persen Anggota</label>
                          <div class="input-group mb-2 cilg4">
                            <div class="input-group-prepend cilg5">
                              <div class="input-group-text cilg6">

                                <div class="control-label"></div>
                                <label class="custom-switch cilg7">

                                  <input type="checkbox" name="custom-switch-checkbox"
                                    class="custom-switch-input ubah-persen gembok-persen">
                                  <span class="custom-switch-indicator"></span>

                                </label>


                              </div>
                            </div>
                            <?php echo form_input($input_persen); ?>
                            <div class="input-group-append">
                              <div class="input-group-text">%</div>
                            </div>
                          </div>
                        </div>


                        <div class="form-group col-lg-3 col-md-6 col-sm-6 clic3">
                          <label>Harga Anggota</label>
                          <div class="input-group mb-2 clic4">
                            <div class="input-group-prepend clic5">
                              <div class="input-group-text clic6">

                                <div class="control-label"></div>
                                <label class="custom-switch clic7">

                                  <input type="checkbox" name="custom-switch-checkbox"
                                    class="custom-switch-input gembok-anggota ubah-anggota">
                                  <span class="custom-switch-indicator"></span>

                                </label>


                              </div>
                            </div>
                            <?php echo form_input($input_harga_anggota); ?>
                          </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-6 cilk3">
                          <label>Persen Konsumen</label>
                          <div class="input-group mb-2 cilk4">
                            <div class="input-group-prepend cilk5">
                              <div class="input-group-text cilk6">

                                <div class="control-label"></div>
                                <label class="custom-switch cilk7">
                                  <input type="checkbox" name="custom-switch-checkbox"
                                    class="custom-switch-input ubah-persen-konsumen gembok-persen-konsumen">
                                  <span class="custom-switch-indicator"></span>
                                </label>
                              </div>
                            </div>
                            <?php echo form_input($input_persen_konsumen); ?>
                            <div class="input-group-append">
                              <div class="input-group-text">%</div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-6 cil3">
                          <label>Harga Konsumen</label>
                          <div class="input-group mb-2 cil4">
                            <div class="input-group-prepend cil5">
                              <div class="input-group-text cil6">

                                <div class="control-label"></div>
                                <label class="custom-switch cil7">

                                  <input type="checkbox" name="custom-switch-checkbox"
                                    class="custom-switch-input gembok-konsumen ubah-konsumen">
                                  <span class="custom-switch-indicator"></span>
                                </label>
                              </div>
                            </div>
                            <?php echo form_input($input_harga_konsumen); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2 cil">

                      <div class="row">

                        <div class="col-lg-12 mb-2 col-md-3">
                          <div class="badges text-center">
                            <a href="javascript:void(0)" class="del-row"> <span
                                class="badge badge-danger">Hapus</span></a>
                          </div>
                        </div>

                      </div>
                    </div>
                
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12  text-right">

                      <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>

                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="invisible">
  <div class="validasi_tambah_barang">
    0
    <?php $validasi_tambah_barang = $session->getFlashdata('pesan_validasi_tambah_barang');
                
      if($validasi_tambah_barang){
        echo $validasi_tambah_barang['nama_barang']; 
        echo $validasi_tambah_barang['kategori_id']; 
        echo $validasi_tambah_barang['satuan_id']; 
        echo $validasi_tambah_barang['merek_id'];          
      }?>

  </div>
  <div class="validasi_tambah_supplier">
    0
    <?php $validasi_tambah_supplier = $session->getFlashdata('pesan_validasi_tambah_supplier');

      if($validasi_tambah_supplier){
        echo $validasi_tambah_supplier['nama_supplier']; 
      }?>

  </div>
</div>

<div class="modal fade" data-backdrop="static" id="modal-barang" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/fitur/barang_masuk/tambah_barang', $form_tambah_barang);    ?>
      <?php $pesan_tambah = $session->getFlashdata('pesan_validasi_tambah_barang');?>
      <div class="modal-body">
        <div class="row">

          <div class="form-group col-sm-12 col-md-12 col-lg-12">
            <label>Nama Barang</label>
            <?php echo tambah_input_helper('nama_barang', 'text', $pesan_tambah['nama_barang'] ?? []); ?>
            <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['nama_barang'].'</div>' : ''; ?>
          </div>

          <div class="form-group col-sm-12 col-md-6 col-lg-6">
            <label>Kategori</label>
            <select class="form-control <?php echo ($pesan_tambah['kategori_id'] ?? []) ? 'is-invalid' : ''; ?>"
              name="kategori_id" id="kategori_id">
              <option value="">--Pilih--</option>
              <?php foreach ($kategori as $kt) :?>
              <option value="<?php echo $kt['id_kategori'];?>"><?php echo $kt['nama_kategori'];?>
              </option>
              <?php endforeach;?>
            </select>
            <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['kategori_id'].'</div>' : ''; ?>
          </div>



          <div class="form-group col-sm-12 col-md-6 col-lg-6">
            <label>Satuan</label>
            <select class="form-control <?php echo ($pesan_tambah['satuan_id'] ?? []) ? 'is-invalid' : ''; ?>"
              name="satuan_id" id="satuan_id">
              <option value="">--Pilih--</option>
              <?php foreach ($satuan as $st) :?>
              <option value="<?php echo esc($st['id_satuan']);?>"><?php echo esc($st['nama_satuan']);?>
              </option>
              <?php endforeach;?>
            </select>
            <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['satuan_id'].'</div>' : ''; ?>
          </div>

          <div class="form-group col-sm-12 col-md-12 col-lg-12">
            <label>Merek</label>
            <select class="form-control <?php echo ($pesan_tambah['merek_id'] ?? []) ? 'is-invalid' : ''; ?>"
              name="merek_id" id="merek_id">
              <option value="">--Pilih--</option>
              <?php foreach ($merek as $mt) :?>
              <option value="<?php echo esc($mt['id_merek']);?>"><?php echo esc($mt['nama_merek']);?>
              </option>
              <?php endforeach;?>
            </select>
            <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['merek_id'].'</div>' : ''; ?>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="modal-supplier" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Supplier</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/fitur/barang_masuk/tambah_supplier', $form_tambah_supplier);    ?>
      <?php $pesan_tambah_supplier = $session->getFlashdata('pesan_validasi_tambah_supplier');?>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
              <label>Nama Supplier</label>
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
              <?php echo tambah_input_helper('nama_supplier', 'text', $pesan_tambah_supplier['nama_supplier'] ?? []); ?>
              <?php echo ($pesan_tambah_supplier ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah_supplier['nama_supplier'].'</div>' : ''; ?>
            </div>
          </div>

        </div>


      </div>
      <div class="modal-footer">

        <!-- untuk mengirimkan ke database ci otomatis akan mengirimkannya jika typenya kita beri submit -->
        <button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>