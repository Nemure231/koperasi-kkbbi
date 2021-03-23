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
                      <td><?php echo $b['nama_supplier']; ?></td>
                      <td><?php echo $b['harga_pokok']; ?></td>
                      <td><?php echo $b['harga_konsumen']; ?></td>
                      <td><?php echo $b['harga_anggota']; ?></td>
                      <td class="text-center"><?php echo $b['stok_barang']; ?></td>
                    
                      <td><?php echo $b['created_at']; ?></td>
                      <td><?php echo $b['updated_at']; ?></td>
                      
                      <td>
                        <a href="javascript:void(0)" id="tombolEditBarang" class="btn mb-3 btn-warning mr-1 tombolEditBarang"
                          data-id_barang="<?php echo $b['id_barang'];?>"
                          data-nama_barang="<?php echo $b['nama_barang'];?>"
                          data-kategori_id="<?php echo $b['kategori_id'];?>"
                          data-satuan_id="<?php echo $b['satuan_id'];?>"
                          data-merek_id="<?php echo $b['merek_id'];?>"
                          data-pengirim_barang_id="<?php echo $b['supplier_id'];?>"
                          data-stok="<?php echo $b['stok_barang'];?>"
                          data-harga_konsumen="<?php echo $b['harga_konsumen'];?>"
                          data-harga_anggota="<?php echo $b['harga_anggota'];?>"
                          data-harga_pokok="<?php echo $b['harga_pokok']; ?>"
                          >
                          <i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" id="tombolHapusBarang" class="btn mb-3 btn-danger tombolHapusBarang"
                          data-id_barang="<?php echo $b['id_barang'];?>">
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
            <div class="invisible">
              <div class="validasi_tambah">
              0
              <?php $validasi_tambah = $session->getFlashdata('pesan_validasi_tambah_barang');
              
              if($validasi_tambah){
                echo $validasi_tambah['nama_barang']; 
                echo $validasi_tambah['kategori_id']; 
                echo $validasi_tambah['satuan_id']; 
                echo $validasi_tambah['merek_id'];
                echo $validasi_tambah['supplier_id'];
                echo $validasi_tambah['harga_pokok']; 
                echo $validasi_tambah['harga_konsumen'];
                echo $validasi_tambah['harga_anggota'];
                echo $validasi_tambah['stok_barang'];
                 
              }
              
              ?>

              </div>
              <div class="validasi_edit">
              0
              <?php $validasi_edit = $session->getFlashdata('pesan_validasi_edit_barang');
              
              if($validasi_edit){
                echo $validasi_edit['nama_barang']; 
                echo $validasi_edit['kategori_id']; 
                echo $validasi_edit['satuan_id']; 
                echo $validasi_edit['merek_id'];
                echo $validasi_edit['supplier_id'];
                echo $validasi_edit['harga_pokok']; 
                echo $validasi_edit['harga_konsumen'];
                echo $validasi_edit['harga_anggota'];
                echo $validasi_edit['stok_barang'];

              }
              
              ?>
              

              </div>
            </div>



          </div>
        </div>
        
      </div>
    </div>
  </section>
</div>



<!-- Modal -->
<div class="modal fade" data-backdrop="static"  id="modalTambahBarang"  role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/suplai/barang/tambah', $form_tambah);    ?>
      <?php $pesan_tambah = $session->getFlashdata('pesan_validasi_tambah_barang');?>
      <div class="modal-body">
        <div class="row">
    

          <div class="col-lg-6">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama Barang</label>
                <?php
                $class_tambah_nama_barang = ($pesan_tambah['nama_barang'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'name' => "nama_barang",
                  'class' => "form-control "."$class_tambah_nama_barang"."",
                  'value' => set_value('nama_barang', ''),
                  'type' => "text"
                ]); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['nama_barang'].'</div>' : ''; ?>
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-12">
                <label>Kategori</label>
                <select class="form-control <?php echo ($pesan_tambah['kategori_id'] ?? []) ? 'is-invalid' : ''; ?>" name="kategori_id" id="kategori_id">
                	<option value="">--Pilih--</option>
                  <?php foreach ($kategori as $kt) :?>
                  <option value="<?php echo $kt['id_kategori'];?>"><?php echo $kt['nama_kategori'];?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['kategori_id'].'</div>' : ''; ?>
              </div>



              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Satuan</label>
                <select class="form-control <?php echo ($pesan_tambah['satuan_id'] ?? []) ? 'is-invalid' : ''; ?>" name="satuan_id" id="satuan_id">
                  	<option value="">--Pilih--</option>
                  <?php foreach ($satuan as $st) :?>
                  <option value="<?php echo esc($st['id_satuan']);?>"><?php echo esc($st['nama_satuan']);?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['satuan_id'].'</div>' : ''; ?>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Merek</label>
                <select class="form-control <?php echo ($pesan_tambah['merek_id'] ?? []) ? 'is-invalid' : ''; ?>" name="merek_id" id="merek_id">
                	<option value="">--Pilih--</option>
                  <?php foreach ($merek as $mt) :?>
                  <option value="<?php echo esc($mt['id_merek']);?>"><?php echo esc($mt['nama_merek']);?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['merek_id'].'</div>' : ''; ?>
              </div>

  

             
            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Supplier</label>
                <select class="form-control <?php echo ($pesan_tambah['supplier_id'] ?? []) ? 'is-invalid' : ''; ?>" name="supplier_id" id="supplier_id">
                	<option value="">--Pilih--</option>
                  <?php foreach ($supplier as $sp) :?>
                  <option value="<?php echo esc($sp['id_supplier']);?>"><?php echo esc($sp['nama_supplier']);?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['supplier_id'].'</div>' : ''; ?>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Harga Konsumen</label>
                <?php
                $class_tambah_harga_konsumen = ($pesan_tambah['harga_konsumen'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'name' => "harga_konsumen",
                  'class' => "form-control "."$class_tambah_harga_konsumen"."",
                  'value' => set_value('harga_konsumen', ''),
                  'type' => "number"
                ]); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['harga_konsumen'].'</div>' : ''; ?>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Harga Anggota</label>
                <?php
                $class_tambah_harga_anggota = ($pesan_tambah['harga_anggota'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'name' => "harga_anggota",
                  'class' => "form-control "."$class_tambah_harga_anggota"."",
                  'value' => set_value('harga_anggota', ''),
                  'type' => "number"
                ]); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['harga_anggota'].'</div>' : ''; ?>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Harga Pokok</label>
                <?php
                $class_tambah_harga_pokok = ($pesan_tambah['harga_pokok'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'name' => "harga_pokok",
                  'class' => "form-control "."$class_tambah_harga_pokok"."",
                  'value' => set_value('harga_pokok', ''),
                  'type' => "number"
                ]); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['harga_pokok'].'</div>' : ''; ?>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Stok Barang</label>
                <?php
                $class_tambah_stok_barang = ($pesan_tambah['stok_barang'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'name' => "stok_barang",
                  'class' => "form-control "."$class_tambah_stok_barang"."",
                  'value' => set_value('stok_barang', ''),
                  'type' => "number"
                ]); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['stok_barang'].'</div>' : ''; ?>
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
<div class="modal fade" data-backdrop="static"  id="modalEditBarang" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Edit Barang</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/suplai/barang/ubah', $form_edit);    ?>
      <?php $old_data = $session->getFlashdata('old_edit_input');?>
      <input type="hidden" name="_method" value="PUT">
      <?php echo form_input([
          'name' => 'edit_id_barang',
          'id'=>'edit_id_barang',
          'type'=> 'hidden',
          'value' => $old_data['id_barang'] ?? ''
        ]); ?>
        <?php $pesan_edit = $session->getFlashdata('pesan_validasi_edit_barang');?>
     
      <div class="modal-body">
        <div class="row">
        
          <div class="col-lg-6">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama Barang</label>
                <?php
                $class_edit_nama_barang = ($pesan_edit['nama_barang'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'id' => "edit_nama_barang",
                  'name' => "edit_nama_barang",
                  'class' => "form-control hapus-validasi-border "."$class_edit_nama_barang"."",
                  'value' => set_value('edit_nama_barang', ''),
                  'type' => "text"
                ]); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['nama_barang'].'</div>' : ''; ?>
						
              </div>

              <div class="form-group col-sm-6 col-md-12 col-lg-12">
                <label>Kategori</label>
                <input id="old_kategori_id" type="hidden" value="<?php echo $old_data['kategori_id'] ?? ''; ?>" />
                <select class="form-control hapus-validasi-border <?php echo ($pesan_edit['kategori_id'] ?? []) ? 'is-invalid' : ''; ?>" name="edit_kategori_id" id="edit_kategori_id">
                	<option value="">--Pilih--</option>
                  <?php foreach ($kategori as $kt) :?>
                  <option value="<?php echo esc($kt['id_kategori']);?>"><?php echo esc($kt['nama_kategori']);?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['kategori_id'].'</div>' : ''; ?>
              </div>



              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Satuan</label>
                <input id="old_satuan_id" type="hidden" value="<?php echo $old_data['satuan_id'] ?? ''; ?>" />
                <select class="form-control hapus-validasi-border <?php echo ($pesan_edit['satuan_id'] ?? []) ? 'is-invalid' : ''; ?>" name="edit_satuan_id" id="edit_satuan_id">
                  	<option value="">--Pilih--</option>
                  <?php foreach ($satuan as $st) :?>
                  <option value="<?php echo esc($st['id_satuan']);?>"><?php echo esc($st['nama_satuan']);?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['satuan_id'].'</div>' : ''; ?>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Merek</label>
                <input id="old_merek_id" type="hidden" value="<?php echo $old_data['merek_id'] ?? ''; ?>" />
                <select class="form-control hapus-validasi-border <?php echo ($pesan_edit['merek_id'] ?? []) ? 'is-invalid' : ''; ?>" name="edit_merek_id" id="edit_merek_id">
                	<option value="">--Pilih--</option>
                  <?php foreach ($merek as $mt) :?>
                  <option value="<?php echo esc($mt['id_merek']);?>"><?php echo esc($mt['nama_merek']);?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['merek_id'].'</div>' : ''; ?>
              </div>

    

            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Supplier</label>
                <input id="old_supplier_id" type="hidden" value="<?php echo $old_data['supplier_id'] ?? ''; ?>" />
                <select class="form-control hapus-validasi-border <?php echo ($pesan_edit['supplier_id'] ?? []) ? 'is-invalid' : ''; ?>" name="edit_supplier_id" id="edit_supplier_id">
                	<option value="">--Pilih--</option>
                  <?php foreach ($supplier as $sp) :?>
                  <option value="<?php echo esc($sp['id_supplier']);?>"><?php echo esc($sp['nama_supplier']);?></option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['supplier_id'].'</div>' : ''; ?>
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Konsumen</label>
                <?php
                $class_edit_harga_konsumen = ($pesan_edit['harga_konsumen'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'id' => "edit_harga_konsumen",
                  'name' => "edit_harga_konsumen",
                  'class' => "form-control hapus-validasi-border "."$class_edit_harga_konsumen"."",
                  'value' => set_value('edit_harga_konsumen', ''),
                  'type' => "number"
                ]); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['harga_konsumen'].'</div>' : ''; ?>
						
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Anggota</label>
                <?php
                $class_edit_harga_anggota = ($pesan_edit['harga_anggota'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'id' => "edit_harga_anggota",
                  'name' => "edit_harga_anggota",
                  'class' => "form-control hapus-validasi-border "."$class_edit_harga_anggota"."",
                  'value' => set_value('edit_harga_anggota', ''),
                  'type' => "number"
                ]); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['harga_anggota'].'</div>' : ''; ?>
						
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Harga Pokok</label>
                <?php
                $class_edit_harga_pokok = ($pesan_edit['harga_pokok'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'id' => "edit_harga_pokok",
                  'name' => "edit_harga_pokok",
                  'class' => "form-control hapus-validasi-border "."$class_edit_harga_pokok"."",
                  'value' => set_value('edit_harga_pokok', ''),
                  'type' => "number"
                ]); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['harga_pokok'].'</div>' : ''; ?>
						
              </div>
              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Stok Barang</label>
                <?php
                $class_edit_stok_barang = ($pesan_edit['stok_barang'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'id' => "edit_stok_barang",
                  'name' => "edit_stok_barang",
                  'class' => "form-control hapus-validasi-border "."$class_edit_stok_barang"."",
                  'value' => set_value('edit_stok_barang', ''),
                  'type' => "number"
                ]); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['stok_barang'].'</div>' : ''; ?>
						
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
<div class="modal fade" data-backdrop="static"  id="modalBarangHapus" tabindex="-1" role="dialog" aria-hidden="true">
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
        <?php echo form_open(base_url().'/suplai/barang/hapus', $form_hapus);    ?>
          <input type="hidden" name="_method" value="DELETE">
          <?php echo form_input($hapus_id_barang); ?>
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>