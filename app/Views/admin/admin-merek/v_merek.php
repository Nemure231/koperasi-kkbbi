<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">


<!-- Main Content -->

<style type="text/css">
  #yappa {padding-top: 50px;}

  #yahaloo {padding-top: -100px;}

  #edit_nama_merek-error {
    color: #dc3545;}
</style>


<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_merek')  ?>"></div>
<div id="flash-data-hapus" data-flashdatahapus="<?php echo $session->getFlashdata('pesan_hapus_merek');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">

            <?php if($merek):  ?>

            <div class="card-header">

              <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahMerek"><i
                  class="fas fa-plus"></i> Tambah Merek</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="mermer">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama Merek</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  $i =1;?>
                    <?php foreach($merek as $m):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $m['nama_merek'] ?></td>
                      <td>
                        <a href="javascript:void(0)" id="tombolEditMerek" class="btn btn-warning mr-1 tombolEditMerek"
                          data-id_merek="<?php echo $m['id_merek'];?>"
                          data-nama_merek="<?php echo $m['nama_merek'];?>">
                          <i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" id="tombolHapusMerek" class="btn btn-danger tombolHapusMerek"
                          data-id_merek="<?php echo $m['id_merek'];?>">
                          <i class="fas fa-trash"></i>
                        </a>

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
                <h2>Belum ada data yang ditambahkan</h2>
                <p class="lead">
                  Silakan tekan tombol dibawah untuk menambahan data
                </p>
                <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahMerek"><i
                    class="fas fa-plus"></i> Tambah merek</a>
              </div>
            </div>
            <?php endif; ?>
            <div class="invisible">
                <div class="validasi_tambah">
                0
                <?php $validasi_tambah = $session->getFlashdata('pesan_validasi_tambah_merek');
                
                if($validasi_tambah){
                  echo $validasi_tambah['nama_merek']; 

                }?>
                </div>
                <div class="validasi_edit">
                0
                <?php $validasi_edit = $session->getFlashdata('pesan_validasi_edit_merek');
                
                if($validasi_edit){
                  echo $validasi_edit['nama_merek']; 
                }?>
                

                </div>        
              </div>



          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<!-- Modal -->
<div class="modal fade" data-backdrop="static"  id="modalTambahMerek" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah merek</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/suplai/merek/tambah', $form_tambah); ?>
      <?php $pesan_tambah = $session->getFlashdata('pesan_validasi_tambah_merek');?>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
              <label>Nama merek</label>
              <?php
                $class_tambah_nama_merek = ($pesan_tambah['nama_merek'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'name' => "nama_merek",
                  'class' => "form-control "."$class_tambah_nama_merek"."",
                  'value' => set_value('nama_merek', ''),
                  'type' => "text"
                ]); ?>
              <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['nama_merek'].'</div>' : ''; ?>
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



<!-- Modal -->
<div class="modal fade" data-backdrop="static"  id="modalEditMerek" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Edit merek</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/suplai/merek/ubah', $form_edit);    ?>
      <?php $old_data = $session->getFlashdata('old_edit_input');?>
      <?php echo form_input([
          'name' => 'edit_id_merek',
          'id'=> 'edit_id_merek',
          'type'=> 'hidden',
          'value' => $old_data['id_merek'] ?? ''
        ]); ?>
      <?php $pesan_edit = $session->getFlashdata('pesan_validasi_edit_merek');?>
      <input type="hidden" name="_method" value="PUT">
      
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
              <label>Nama Merek</label>
              <?php
                $class_edit_nama_merek = ($pesan_edit['nama_merek'] ?? []) ? 'is-invalid' : '';
                echo form_input([
                  'id' => "edit_nama_merek",
                  'name' => "edit_nama_merek",
                  'class' => "form-control hapus-validasi-border "."$class_edit_nama_merek"."",
                  'value' => set_value('edit_nama_merek', ''),
                  'type' => "text"
                ]); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['nama_merek'].'</div>' : ''; ?>
              
            </div>
          </div>

        </div>


      </div>
      <div class="modal-footer">

        <!-- untuk mengirimkan ke database ci otomatis akan mengirimkannya jika typenya kita beri submit -->
        <button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" data-backdrop="static"  id="modalMerekHapus" tabindex="-1" role="dialog" aria-hidden="true">
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
        <?php echo form_open(base_url().'/suplai/merek/hapus', $form_hapus);    ?>
        <input type="hidden" name="_method" value="PUT">
        <?php echo form_input($hapus_id_merek); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>