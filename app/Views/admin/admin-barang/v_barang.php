<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/modules/datatables/Responsive-2.2.1/css/responsive.bootstrap4.min.css' ?>">


<!-- Main Content -->

<style type="text/css">
  #yappa {padding-top: 50px;}
    #yahaloo {padding-top: -100px;}
  .select2 {
width:100%!important;
}
</style>


<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_barang')  ?>"></div>
<div id="flash-data-hapus" data-flashdatahapus="<?php echo $session->getFlashdata('hapus_barang');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
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
                      <!-- <th>Gambar Barang</th> -->
                     
                      <th >Tanggal Input</th>
                      <th>Tanggal Update</th>
                      <th data-priority="7">Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php  $i =1;?>
                    <?php foreach($barang as $b):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $b['nama_barang']; ?></td>
                      <td><?php echo $b['kode_barang']; ?></td>
                      <td><?php echo $b['nama_kategori']; ?></td>
                      <td><?php echo $b['nama_satuan']; ?></td>
                      <td><?php echo $b['nama_merek']; ?></td>
                      <td><?php echo $b['nama_pengirim_barang']; ?></td>
                      <td><?php echo $b['harga_pokok']; ?></td>
                      <td><?php echo $b['harga_konsumen']; ?></td>
                      <td><?php echo $b['harga_anggota']; ?></td>
                      <td class="text-center"><?php echo $b['stok_barang']; ?></td>
                      <!-- <td>
                        <img alt="image" src="< //?php echo base_url('admin/assets/barang').'/'. $b//['gambar_barang']; ?>"
                          style="height: 110px; width: 70px; object-fit:cover;">
                      </td> -->
                      <td><?php echo $b['tanggal']; ?></td>
                      <td><?php echo $b['tanggal_update']; ?></td>
                      
                      <td>
                        <a href="javascript:void(0)" id="tombolEditBarang" class="btn mb-3 btn-warning mr-1 tombolEditBarang"
                          data-id_barang="<?php echo $b['id_barang'];?>"
                          data-nama_barang="<?php echo $b['nama_barang'];?>"
                          data-kategori_id="<?php echo $b['kategori_id'];?>"
                          data-satuan_id="<?php echo $b['satuan_id'];?>"
                          data-merek_id="<?php echo $b['merek_id'];?>"
                          data-pengirim_barang_id="<?php echo $b['pengirim_barang_id'];?>"
                          data-stok="<?php echo $b['stok_barang'];?>"
                          data-harga_konsumen="<?php echo $b['harga_konsumen'];?>"
                          data-harga_anggota="<?php echo $b['harga_anggota'];?>"
                          data-deskripsi_barang="<?php echo $b['deskripsi_barang'];?>"
                          data-gambar_barang="<?php echo $b['gambar_barang'];?>"
                          data-harga_pokok="<?php echo $b['harga_pokok']; ?>"
                          >
                          <i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" id="tombolHapusBarang" class="btn mb-3 btn-danger"
                          data-id_barang="<?php echo $b['id_barang'];?>"
                          data-gambar_barang="<?php echo $b['gambar_barang'];?>">
                          <i class="fas fa-trash"></i>
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
            <div class="invisible"><?php echo $validation->listErrors(); ?></div>



          </div>
        </div>
        
      </div>
    </div>
  </section>
</div>



<!-- Modal -->
<div class="modal fade" id="modalTambahBarang"  role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/barang/tambahbarang', $form_tambah_barang);    ?>
      <?php echo form_input($hidden_kode_barang); ?>
      <?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="row">
          <!-- <div class="col-lg-4">
            <div class="row">
            <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <label>Gambar Barang</label>
                <div class="row">


                  <div class="col-sm-12 col-md-12 col-lg-12 mb-4 pb-3">
                    <img src="< ?php echo base_url('admin/assets/barang').'/'. 'default.jpg' ?>"
                      class="img-thumbnail img-prev" style="height: 260px; width: 180px; object-fit:cover;">
                  </div>
                  
                  <div class="col-sm-12 col-md-8 col-lg-12">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="gambar_barang" name="gambar_barang"
                        onchange="previewImg()">
                      <label class="custom-file-label text-left" for="GambarBarang">Pilih gambar</label>
                    </div>
                  </div>
                </div>
              </div>
              

            </div>
          </div> -->

          <div class="col-lg-6">
            <div class="row">
                <div class="form-group">
                    <!--// name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                    <?php echo form_input($hidden_kode_barang); ?>
                  </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama Barang</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_nama_barang); ?>
              </div>

              <div class="form-group col-sm-6 col-md-12 col-lg-12">
                <label>Kategori</label>
                <select class="form-control" name="kategori_id" id="kategori_id">
                <option value=""></option>
                  <?php foreach ($kategori as $kt) :?>
                  <option value="<?php echo esc($kt['id_kategori']);?>"><?php echo esc($kt['nama_kategori']);?></option>
                  <?php endforeach;?>
                </select>
              </div>



              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Satuan</label>
                <select class="form-control" name="satuan_id" id="satuan_id">
                  <option value=""></option>
                  <?php foreach ($satuan as $st) :?>
                  <option value="<?php echo esc($st['id_satuan']);?>"><?php echo esc($st['nama_satuan']);?></option>
                  <?php endforeach;?>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Merek</label>
                <select class="form-control" name="merek_id" id="merek_id">
                <option value=""></option>
                  <?php foreach ($merek as $mt) :?>
                  <option value="<?php echo esc($mt['id_merek']);?>"><?php echo esc($mt['nama_merek']);?></option>
                  <?php endforeach;?>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Supplier</label>
                <select class="form-control" name="supplier_id" id="supplier_id">
                <option value=""></option>
                  <?php foreach ($supplier as $sp) :?>
                  <option value="<?php echo esc($sp['id_pengirim_barang']);?>"><?php echo esc($sp['nama_pengirim_barang']);?></option>
                  <?php endforeach;?>
                </select>
              </div>

             
            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Konsumen</label>
                <?php echo form_input($input_harga_konsumen); ?>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Anggota</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_harga_anggota); ?>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Pokok</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_harga_pokok); ?>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Stok Barang</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_stok); ?>
              </div>
              <div class="form-group col-sm-12 col-lg-12 col-md-12">
                <label>Deskripsi</label>
                <?php echo form_textarea($input_deskripsi); ?>
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/barang/editbarang', $form_edit_barang);    ?>
      <?php echo csrf_field(); ?>
      <!-- <input type="hidden" name="_method" value="PUT" /> -->
      <?php echo form_input($hidden_id_barangE); ?>
      <?php echo form_input($hidden_gambar_barang_lama); ?>
      <?php echo form_input($hidden_nama_barang_old); ?>
     
      <div class="modal-body">
        <div class="row">
          <!-- <div class="col-lg-4">
            <div class="row">
            <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <label>Gambar Barang</label>
                <div class="row">

                  <div class="col-sm-12 col-md-12 col-lg-12 mb-4 pb-3">
                    <img id="img-edit" 
                      class="img-thumbnail img-prevE" style="height: 260px; width: 180px; object-fit:cover;">
                  </div>
                 
                  <div class="col-sm-12 col-md-8 col-lg-12">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input cuss" id="gambar_barangE" name="gambar_barangE"
                        onchange="previewImg1()">
                      <label id="img-edit-label" class="custom-file-label text-left" for="GambarBarang">Pilih gambar</label>
                    </div>
                  </div>
                </div>
              </div>
              

            </div>
          </div> -->
          
          <div class="col-lg-6">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama Barang</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_nama_barangE); ?>
              </div>

              <div class="form-group col-sm-6 col-md-12 col-lg-12">
                <label>Kategori</label>
                <select class="form-control" name="kategori_idE" id="kategori_idE">
                <option value=""></option>
                  <?php foreach ($kategori as $kt) :?>
                  <option value="<?php echo esc($kt['id_kategori']);?>"><?php echo esc($kt['nama_kategori']);?></option>
                  <?php endforeach;?>
                </select>
              </div>



              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Satuan</label>
                <select class="form-control" name="satuan_idE" id="satuan_idE">
                  <option value=""></option>
                  <?php foreach ($satuan as $st) :?>
                  <option value="<?php echo esc($st['id_satuan']);?>"><?php echo esc($st['nama_satuan']);?></option>
                  <?php endforeach;?>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Merek</label>
                <select class="form-control" name="merek_idE" id="merek_idE">
                <option value=""></option>
                  <?php foreach ($merek as $mt) :?>
                  <option value="<?php echo esc($mt['id_merek']);?>"><?php echo esc($mt['nama_merek']);?></option>
                  <?php endforeach;?>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Supplier</label>
                <select class="form-control" name="supplier_idE" id="supplier_idE">
                <option value=""></option>
                  <?php foreach ($supplier as $sp) :?>
                  <option value="<?php echo esc($sp['id_pengirim_barang']);?>"><?php echo esc($sp['nama_pengirim_barang']);?></option>
                  <?php endforeach;?>
                </select>
              </div>

            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Konsumen</label>
                <?php echo form_input($input_harga_konsumenE); ?>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Anggota</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_harga_anggotaE); ?>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Pokok</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_harga_pokokE); ?>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Stok Barang</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($input_stokE); ?>
              </div>
              <div class="form-group col-sm-12 col-lg-12 col-md-12">
                <label>Deskripsi</label>
                <?php echo form_textarea($input_deskripsiE); ?>
              </div>
              
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
              </div>
            </div>


          </div>
        </div>
      </div>
      <input type="file" class="custom-file-input cuss invisible" id="gambar_barangE" name="gambar_barangE"
        onchange="previewImg1()">

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
        <input type="hidden" value="" name="old_gambar" id="old_gambar">
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
        <form id="btn-simpan-hapus2" class="btn btn-block" method="post">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        </form>

      </div>

    </div>
  </div>
</div>