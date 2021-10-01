<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/datatables/Responsive-2.2.1/css/responsive.bootstrap4.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/chocolat/dist/css/chocolat.css' ?>">

<!-- Main Content -->

<style type="text/css">
  #yappa {
    padding-top: 50px;
  }

  #yahaloo {
    padding-top: -100px;
  }

  .select2 {
    width: 100% !important;
  }
</style>


<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_barang')  ?>"></div>
<div id="flash-data-hapus" data-flashdatahapus="<?php echo $session->getFlashdata('hapus_barang');  ?>"></div>
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

            <?php if($barang):  ?>


            <div class="card-header">

              <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahBarang"><i
                  class="fas fa-plus"></i> Tambah barang</a>
            </div>
            <div class="card-body">
              <!-- <div class="table-responsive"> -->
              <table class="table table-striped" style="width: 100%;" id="brbr">
                <thead>
                  <tr>
                    <th data-priority="1" class="text-center">#</th>
                    <th data-priority="2">Nama</th>
                    <th data-priority="3">Kode</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Merek</th>
                    <th>Supplier</th>
                    <th>Harga Pokok</th>
                    <th data-priority="4">Harga Konsumen</th>
                    <th data-priority="5">Harga Anggota</th>
                    <th data-priority="6">Stok</th>



                    <th>Tanggal Input</th>
                    <th>Tanggal Update</th>
                    <th data-priority="7">Opsi</th>
                  </tr>
                </thead>
                <tbody>

                  <?php  $i =1;?>
                  <?php foreach($barang as $b):?>
                  <tr>
                    <td>
                      <?php echo $i; ?>
                    </td>
                    <td>
                      <?php echo $b['nama_barang']; ?>
                    </td>
                    <td>
                      <?php echo $b['kode_barang']; ?>
                    </td>
                    <td>
                      <?php echo $b['nama_kategori']; ?>
                    </td>
                    <td>
                      <?php echo $b['nama_satuan']; ?>
                    </td>
                    <td>
                      <?php echo $b['nama_merek']; ?>
                    </td>
                    <td>
                      <?php echo $b['nama_pengirim_barang']; ?>
                    </td>
                    <td>
                      <?php echo $b['harga_pokok']; ?>
                    </td>
                    <td>
                      <?php echo $b['harga_konsumen']; ?>
                    </td>
                    <td>
                      <?php echo $b['harga_anggota']; ?>
                    </td>
                    <td class="text-center">
                      <?php echo $b['stok_barang']; ?>
                    </td>



                    <td>
                      <?php echo $b['tanggal']; ?>
                    </td>
                    <td>
                      <?php echo $b['tanggal_update']; ?>
                    </td>

                    <td>
                      <a href="javascript:void(0)" id="tombolEditBarang"
                        class="btn mb-3 btn-warning mr-1 tombolEditBarang"
                        data-id_barang="<?php echo $b['id_barang'];?>"
                        data-nama_barang="<?php echo $b['nama_barang'];?>"
                        data-kategori_id="<?php echo $b['kategori_id'];?>"
                        data-satuan_id="<?php echo $b['satuan_id'];?>" data-merek_id="<?php echo $b['merek_id'];?>"
                        data-pengirim_barang_id="<?php echo $b['pengirim_barang_id'];?>"
                        data-stok="<?php echo $b['stok_barang'];?>"
                        data-harga_konsumen="<?php echo $b['harga_konsumen'];?>"
                        data-harga_anggota="<?php echo $b['harga_anggota'];?>"
                        data-deskripsi_barang="<?php echo $b['deskripsi_barang'];?>"
                        data-harga_pokok="<?php echo $b['harga_pokok']; ?>"
                        data-gambar="<?php echo $b['nama_gambar'];?>">
                        <i class="fas fa-pencil-alt"></i></a>
                      <a href="javascript:void(0)" id="tombolHapusBarang" class="btn mb-3 btn-danger tombolHapusBarang"
                        data-id_barang="<?php echo $b['id_barang'];?>">
                        <i class="fas fa-trash"></i>
                      </a>

                      <a href="javascript:void(0)" class="btn mb-3 btn-info tombolLihatGambar"
                        data-gambar="<?php echo $b['nama_gambar']; ?>" data-qr="<?php echo $b['qr']; ?>">
                        <i class="fas fa-qrcode"></i>
                      </a>
                    </td>

                  </tr>
                  <?php $i++; ?>
                  <?php endforeach;?>

                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1">Total: </th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1" class="text-center"></th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>
                    <th colspan="1"></th>


                  </tr>
                </tfoot>
              </table>
              <!-- </div> -->

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
                <h2>Belum ada data yang ditambahkan</h2>
                <p class="lead">
                  Silakan tekan tombol dibawah untuk menambahan data
                </p>
                <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahBarang"><i
                    class="fas fa-plus"></i> Tambah buku</a>
              </div>
            </div>
            <?php endif; ?>


            <div class="invisible create-validation">0
              <?php echo $validation->showError('nama_barang'); ?>
              <?php echo $validation->showError('kategori_id'); ?>
              <?php echo $validation->showError('satuan_id'); ?>
              <?php echo $validation->showError('merek_id'); ?>
              <?php echo $validation->showError('supplier_id'); ?>
              <?php echo $validation->showError('harga_anggota'); ?>
              <?php echo $validation->showError('harga_konsumen'); ?>
              <?php echo $validation->showError('harga_pokok'); ?>
              <?php echo $validation->showError('stok_barang'); ?>
              <?php echo $validation->showError('deskripsi_barang'); ?>
            </div>

            <div class="invisible edit-validation">0
              <?php echo $validation->showError('nama_barangE'); ?>
              <?php echo $validation->showError('kategori_idE'); ?>
              <?php echo $validation->showError('satuan_idE'); ?>
              <?php echo $validation->showError('merek_idE'); ?>
              <?php echo $validation->showError('supplier_idE'); ?>
              <?php echo $validation->showError('harga_anggotaE'); ?>
              <?php echo $validation->showError('harga_konsumenE'); ?>
              <?php echo $validation->showError('harga_pokokE'); ?>
              <?php echo $validation->showError('stok_barangE'); ?>
              <?php echo $validation->showError('deskripsi_barangE'); ?>
            </div>



          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambahBarang" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/suplai/barang/tambah', $form_tambah_barang);    ?>


      <div class="modal-body">
        <div class="row">
          <div class="col-lg-4 text-center">

            <div class="row">
              <div class="col-lg-12 mb-2">
                <img src="<?php echo base_url('admin/assets/barang').'/'. 'default.jpg' ?>"
                  class="img-thumbnail img-prev" id="gambar" style="height: 310px; width: 220px; object-fit:cover;">


              </div>
              <div class="col-sm-12 col-md-8 col-lg-12">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="input_gambar" name="gambar" onchange="previewImg()">

                  <label class="custom-file-label text-left" for="Sampulbuku">Pilih gambar</label>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-4">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" value="<?php echo set_value('nama_barang', ''); ?>" id="nama_barang" class="form-control" autofocus="" />
                <div class="invalid-feedback">
                      <?php echo $validation->showError('nama_barang'); ?>
                </div>
              </div>

              <div class="form-group col-sm-6 col-md-12 col-lg-12">
                <label>Kategori</label>
                <select class="form-control <?php echo ($validation->hasError('kategori_id')) ? 'is-invalid' : ''; ?>" name="kategori_id" id="kategori_id">
                  <option value=""></option>
                  <?php foreach ($kategori as $kt) :?>
                  <option value="<?php echo esc($kt['id_kategori']);?>" <?php echo set_value('kategori_id', '') == $kt['id_kategori'] ? 'selected':''; ?>  >
                    <?php echo esc($kt['nama_kategori']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                      <?php echo $validation->showError('kategori_id'); ?>
                </div>
              </div>



              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Satuan</label>
                <select class="form-control <?php echo ($validation->hasError('satuan_id')) ? 'is-invalid' : ''; ?>" name="satuan_id" id="satuan_id">
                  <option value=""></option>
                  <?php foreach ($satuan as $st) :?>
                  <option value="<?php echo esc($st['id_satuan']);?>" <?php echo set_value('satuan_id', '') == $st['id_satuan'] ? 'selected':''; ?>>
                    <?php echo esc($st['nama_satuan']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                      <?php echo $validation->showError('satuan_id'); ?>
                </div>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Merek</label>
                <select class="form-control <?php echo ($validation->hasError('merek_id')) ? 'is-invalid' : ''; ?>" name="merek_id" id="merek_id">
                  <option value=""></option>
                  <?php foreach ($merek as $mt) :?>
                  <option value="<?php echo esc($mt['id_merek']);?>" <?php echo set_value('merek_id', '') == $mt['id_merek'] ? 'selected':''; ?>>
                    <?php echo esc($mt['nama_merek']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                      <?php echo $validation->showError('merek_id'); ?>
                </div>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Supplier</label>
                <select class="form-control <?php echo ($validation->hasError('supplier_id')) ? 'is-invalid' : ''; ?>" name="supplier_id" id="supplier_id">
                  <option value=""></option>
                  <?php foreach ($supplier as $sp) :?>
                  <option value="<?php echo esc($sp['id_pengirim_barang']);?>" <?php echo set_value('supplier_id', '') == $sp['id_pengirim_barang'] ? 'selected':''; ?>>
                    <?php echo esc($sp['nama_pengirim_barang']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                  <?php echo $validation->showError('supplier_id'); ?>
                </div>
              </div>


            </div>
          </div>

          <div class="col-lg-4">
            <div class="row">
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Konsumen</label>
                <input type="number" name="harga_konsumen" value="<?php echo set_value('harga_konsumen', ''); ?>" id="harga_konsumen" class="form-control <?php echo ($validation->hasError('harga_konsumen')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('harga_konsumen'); ?>
                </div>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Anggota</label>
                <input type="number" name="harga_anggota" value="<?php echo set_value('harga_anggota', ''); ?>" id="harga_anggota" class="form-control <?php echo ($validation->hasError('harga_anggota')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('harga_anggota'); ?>
                </div>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Pokok</label>
                <input type="number" name="harga_pokok" value="<?php echo set_value('harga_pokok', ''); ?>" id="harga_pokok" class="form-control <?php echo ($validation->hasError('harga_pokok')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('harga_pokok'); ?>
                </div>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Stok Barang</label>
                <input type="number" name="stok_barang" value="<?php echo set_value('stok_barang', ''); ?>" id="stok_barang" class="form-control <?php echo ($validation->hasError('stok_barang')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('stok_barang'); ?>
                </div>
              </div>
              <div class="form-group col-sm-12 col-lg-12 col-md-12">
                <label>Deskripsi</label>
                <textarea name="deskripsi_barang" cols="40" rows="10" type="number" id="deskripsi_barang" class="form-control <?php echo ($validation->hasError('deskripsi_barang')) ? 'is-invalid' : ''; ?>" style="min-height:145px;">
                  <?php echo set_value('deskripsi_barang', ''); ?>
                </textarea>
                <div class="invalid-feedback">
                    <?php echo $validation->showError('deskripsi_barang'); ?>
                </div>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
              </div>
            </div>


          </div>
        </div>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalEditBarang" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Edit Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/suplai/barang/ubah', $form_edit_barang);    ?>
      <input type="hidden" name="_method" value="PUT" />
      <?php echo csrf_field(); ?>
      <input type="hidden" name="id_barangE" value="<?php echo set_value('id_barangE', ''); ?>" id="id_barangE" class="form-control" autofocus="" />
      

      <div class="modal-body">
        <div class="row">

          <div class="col-lg-4 text-center">

            <div class="row">
              <div class="col-lg-12 mb-2">
                <img src="<?php echo base_url('admin/assets/barang').'/'.set_value('gambar_lama', 'default.jpg'); ?>"
                  class="img-thumbnail edit_gambar" style="height: 310px; width: 220px; object-fit:cover;">
              </div>
              <div class="col-sm-12 col-md-8 col-lg-12">
                <div class="custom-file">
                  <input type="hidden" id="gambar_lama" value="<?php echo set_value('gambar_lama', 'default.jpg'); ?>" name="gambar_lama">
                  <input type="file" class="custom-file-input" id="input_edit_gambar" name="edit_gambar"
                    onchange="previewImgEdit()" value="<?php echo set_value('gambar_lama', 'default.jpg'); ?>">

                  <label class="custom-file-label text-left edit-label-gambar"><?php echo set_value('gambar_lama', 'default.jpg'); ?></label>
                </div>
              </div>
            </div>


          </div>

          <div class="col-lg-4">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama Barang</label>
                <input type="text" name="nama_barangE" value="<?php echo set_value('nama_barangE', ''); ?>" id="nama_barangE" class="form-control nama_barangE  <?php echo ($validation->hasError('nama_barangE')) ? 'is-invalid' : ''; ?>"/>
                <div class="invalid-feedback">
                    <?php echo $validation->showError('nama_barangE'); ?>
                </div>
              </div>

              <div class="form-group col-sm-6 col-md-12 col-lg-12">
                <label>Kategori</label>
                <select class="form-control  <?php echo ($validation->hasError('kategori_idE')) ? 'is-invalid' : ''; ?>" name="kategori_idE" id="kategori_idE">
                  <option value=""></option>
                  <?php foreach ($kategori as $kt) :?>
                  <option value="<?php echo esc($kt['id_kategori']);?>" <?php echo set_value('kategori_idE', '') == $kt['id_kategori'] ? 'selected':''; ?>>
                    <?php echo esc($kt['nama_kategori']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $validation->showError('kategori_idE'); ?>
                </div>
              </div>



              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Satuan</label>
                <select class="form-control  <?php echo ($validation->hasError('satuan_idE')) ? 'is-invalid' : ''; ?>" name="satuan_idE" id="satuan_idE">
                  <option value=""></option>
                  <?php foreach ($satuan as $st) :?>
                  <option value="<?php echo esc($st['id_satuan']);?>" <?php echo set_value('satuan_idE', '') == $st['id_satuan'] ? 'selected':''; ?>>
                    <?php echo esc($st['nama_satuan']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $validation->showError('satuan_idE'); ?>
                </div>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Merek</label>
                <select class="form-control  <?php echo ($validation->hasError('merek_idE')) ? 'is-invalid' : ''; ?>" name="merek_idE" id="merek_idE">
                  <option value=""></option>
                  <?php foreach ($merek as $mt) :?>
                  <option value="<?php echo esc($mt['id_merek']);?>" <?php echo set_value('merek_idE', '') == $mt['id_merek'] ? 'selected':''; ?>>
                    <?php echo esc($mt['nama_merek']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $validation->showError('merek_idE'); ?>
                </div>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Supplier</label>
                <select class="form-control  <?php echo ($validation->hasError('supplier_idE')) ? 'is-invalid' : ''; ?>" name="supplier_idE" id="supplier_idE">
                  <option value=""></option>
                  <?php foreach ($supplier as $sp) :?>
                  <option value="<?php echo esc($sp['id_pengirim_barang']);?>" <?php echo set_value('supplier_idE', '') == $sp['id_pengirim_barang'] ? 'selected':''; ?>>
                    <?php echo esc($sp['nama_pengirim_barang']);?>
                  </option>
                  <?php endforeach;?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $validation->showError('supplier_idE'); ?>
                </div>
              </div>

            </div>
          </div>

          <div class="col-lg-4">
             <div class="row">
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Konsumen</label>
                <input type="number" name="harga_konsumenE" value="<?php echo set_value('harga_konsumenE', ''); ?>" id="harga_konsumenE" class="form-control  <?php echo ($validation->hasError('harga_konsumenE')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('harga_konsumenE'); ?>
                </div>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Anggota</label>
                <input type="number" name="harga_anggotaE" value="<?php echo set_value('harga_anggotaE', ''); ?>" id="harga_anggotaE" class="form-control  <?php echo ($validation->hasError('harga_anggotaE')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('harga_anggotaE'); ?>
                </div>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Pokok</label>
                <input type="number" name="harga_pokokE" value="<?php echo set_value('harga_anggotaE', ''); ?>" id="harga_pokokE" class="form-control  <?php echo ($validation->hasError('harga_pokokE')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('harga_pokokE'); ?>
                </div>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Stok Barang</label>
                <input type="number" name="stok_barangE" value="<?php echo set_value('stok_barangE', ''); ?>" id="stok_barangE" class="form-control  <?php echo ($validation->hasError('stok_barangE')) ? 'is-invalid' : ''; ?>" />
                <div class="invalid-feedback">
                    <?php echo $validation->showError('stok_barangE'); ?>
                </div>
              </div>
              <div class="form-group col-sm-12 col-lg-12 col-md-12">
                <label>Deskripsi</label>
                <textarea name="deskripsi_barangE" cols="40" rows="10" type="number" id="deskripsi_barangE" class="form-control  <?php echo ($validation->hasError('deskripsi_barangE')) ? 'is-invalid' : ''; ?>" style="min-height:145px;">
                <?php echo set_value('deskripsi_barangE', ''); ?>
                </textarea>
                <div class="invalid-feedback">
                    <?php echo $validation->showError('deskripsi_barangE'); ?>
                </div>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
              </div>
            </div>


          </div>
        </div>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>







<!-- Modal -->
<div class="modal fade" id="modalBarangHapus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light" id="judulBukuHapus"></h5>
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
                  <div class="empty-state-icon bg-danger">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin menghapus?</h2>
                  <p class="lead">
                    Data yang telah dihapus tidak dapat dikembalikan lagi!
                  </p>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer" id="yahaloo">
        <!-- untuk mengirimkan ke database ci otomatis akan mengirimkannya jika typenya kita beri submit -->
        <!-- <a id="btn-simpan-hapus" class="btn btn-block btn-danger"><h6>Ya, hapus</h6></a> -->
        <?php echo form_open(base_url().'/suplai/barang/hapus', $form_hapus_barang);    ?>
        <?php echo csrf_field(); ?>
        <input type="hidden" name="_method" value="DELETE">
        <?php echo form_input($hidden_id_barangH); ?>
        <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLihatGambar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header bg-info">
        <h5 class="modal-title text-dark">Gambar QR</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i style="font-size: 24px;" class="fas fa-10x fa-times"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">


          <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <img class="img-thumbnail" id="tampil-qr" style="height: 340px; width: 320px; object-fit:cover;">


          </div>
        </div>

      </div>

    </div>
  </div>
</div>