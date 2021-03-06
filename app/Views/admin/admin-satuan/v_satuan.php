<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">


<!-- Main Content -->

<style type="text/css">
  #yappa {padding-top: 50px;}#yahaloo {padding-top: -100px;}
/* 
  #edit_nama_satuan-error {
    color: #dc3545;
  } */
</style>


<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_satuan')  ?>"></div>
<div id="flash-data-hapus" data-flashdatahapus="<?php echo $session->getFlashdata('pesan_hapus_satuan');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">

            <?php if($satuan):  ?>

            <div class="card-header">

              <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahSatuan"><i
                  class="fas fa-plus"></i> Tambah Satuan</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="satsat">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama Satuan</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  $i =1;?>
                    <?php foreach($satuan as $s):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $s['nama_satuan'] ?></td>
                      <td>
                        <a href="javascript:void(0)" id="tombolEditSatuan" class="btn btn-warning mr-1 tombolEditSatuan"
                          data-id_satuan="<?php echo $s['id_satuan'];?>"
                          data-nama_satuan="<?php echo $s['nama_satuan'];?>">
                          <i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" id="tombolHapusSatuan" class="btn btn-danger tombolHapusSatuan"
                          data-id_satuan="<?php echo $s['id_satuan'];?>">
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
                <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahSatuan"><i
                    class="fas fa-plus"></i> Tambah satuan</a>
              </div>
            </div>
            <?php endif; ?>
            <div class="invisible">
                <?php echo $validation->listErrors(); ?>
              </div>



          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<!-- Modal -->
<div class="modal fade" id="modalTambahSatuan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Satuan</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/suplai/satuan/tambah', $form_tambah_satuan);    ?>

      <?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
              <label>Nama Satuan</label>
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
          
              <?php echo form_input($input_satuan); ?>
              
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
<div class="modal fade" id="modalEditSatuan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Edit Satuan</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/suplai/satuan/ubah', $form_edit_satuan);    ?>
      <input type="hidden" name="_method" value="PUT">
      <?php echo csrf_field(); ?>
      <?php echo form_input($hidden_id_satuan); ?>
      <?php echo form_input($hidden_old_nama_satuan); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
              <label>Nama Satuan</label>
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
              <?php echo form_input($input_satuanE); ?>
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
<div class="modal fade" id="modalSatuanHapus" tabindex="-1" role="dialog" aria-hidden="true">
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
        <!-- <form id="btn-simpan-hapus" class="btn btn-block" method="post"> -->
        <?php echo form_open(base_url().'/suplai/satuan/hapus', $form_hapus_satuan);    ?>
        <?php echo form_input($hidden_id_satuanH); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>
        <!-- </form> -->

      </div>

    </div>
  </div>
</div>