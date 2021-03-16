
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<!-- <style type="text/css">
	#menu-error {
		color: #dc3545;
  //}
  
</style> -->
<!-- Main Content -->
<div  class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_menu')  ?>"></div>
            <div  class="flash-data-edit" data-flashdata="<?php echo $session->getFlashdata('pesan_edit_menu')  ?>"></div>
            <div  class="flash-data-hapus" data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_menu')  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">


          <?php if($mmenu): ?>


            <div class="card-header">
            <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahMenu"><i class="fas fa-plus"></i> Tambah menu</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="meme">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Menu</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php  $i =1;?>
                    <?php foreach($mmenu as $m):?>
                    <tr id="menu_id_<?php echo $m['id_menu'];?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $m['nama_menu']; ?></td>
                      <td>
                        <a href="javascript:void(0)" class="edit-menu btn btn-warning mr-1" data-id="<?php echo $m['id_menu'];?>" data-menu="<?php echo $m['nama_menu'];?>" ><i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" class="hapus-menu btn btn-danger" data-id="<?php echo $m['id_menu'];?>" ><i class="fas fa-trash"></i></a>
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
                    <button id="tombolTambahMenu"  class="btn btn-icon icon-left btn-primary mt-4"><i class="fas fa-plus"></i> Tambah menu</button>


                  </div>
                </div>
                    <?php endif; ?>
                    <div class="invisible">
                 
                 <?php echo $session->getFlashdata('pesan_validasi_menu');  ?>
                
                </div>



          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<!-- Modal -->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light">Tambah Menu</h5>
				<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/pengaturan/menu/tambah', $attr);    ?>
        <?php echo csrf_field(); ?>
				<div class="modal-body">

					<div class="form-group">
						<!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['nama_menu'] -->
            <?php echo form_input($menunu); ?>
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
<div class="modal fade" id="modalEditMenu" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Edit Menu</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/pengaturan/menu/ubah', $form_edit_menu);    ?>
      <input type="hidden" name="_method" value="PUT">
      <?php echo form_input($hidden_menu_id); ?>
      <?php echo form_input($hidden_old_menu); ?>
      <?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
              <label>Nama kategori</label>
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['nama_menu'] -->
              <?php echo form_input($menuE); ?>
              <div class="invalid-feedback">
              </div>
            </div>
          </div>
        </div>


      </div>
      <div class="modal-footer">

        <!-- untuk mengirimkan ke database ci otomatis akan mengirimkannya jika typenya kita beri submit -->
        <button type="submit" class="btn btn-block btn-primary">Simpan</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalHapusMenu" tabindex="-1" role="dialog" aria-hidden="true">
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
        <?php echo form_open(base_url().'/pengaturan/menu/hapus', $form_hapus_menu);    ?>
        <?php echo form_input($hidden_hapus_menu_id); ?>
        <?php echo csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>


