
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<style type="text/css">
	#role-error {
		color: #dc3545;}
  
</style>
<!-- Main Content -->
<div  class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_role');  ?>"></div>
<div  class="flash-data-edit" data-flashdata="<?php echo $session->getFlashdata('pesan_edit_role');  ?>"></div>
<div  class="flash-data-hapus" data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_role');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card">
            

            <?php if($role): ?>
            
            <div class="card-header">
            <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahRole"><i class="fas fa-plus"></i> Tambah role</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="roro">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Role</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                    <?php  $i =1;?>
                    <?php foreach($role as $r):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $r['role']; ?></td>
                      <td>
                        <a href="javascript:void(0)" class="edit-role btn btn-warning mr-1" data-id="<?php echo $r['id_role'];?>" data-role="<?php echo $r['role'];?>" ><i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" class="hapus-role btn btn-danger mr-1" data-id="<?php echo $r['id_role'];?>" ><i class="fas fa-trash"></i></a>
                        <a href="<?php echo base_url().'/pengaturan/role/akses/'. $r['id_role']; ?>" class="btn btn-info"><i class="fas fa-cogs"></i></a>

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
                      <button id="tombolTambahRole"  class="btn btn-icon icon-left btn-primary mt-4"><i class="fas fa-plus"></i> Tambah role</button>

      
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
<div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light" id="judulRole">Tambah Role</h5>
				<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">X</span>
				</button>
			</div>
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah role ini berasal dari controler role di fungsi index -->
      <?php echo form_open(base_url().'/pengaturan/role/tambah', $attr);    ?>
      <?php echo csrf_field(); ?>
				<div class="modal-body">

					<div class="form-group">
          <?php echo form_input($nama_role); ?>
					</div>

				</div>
				<div class="modal-footer">

					<!-- untuk mengirimkan ke database ci otomatis akan mengirimkannya jika typenya kita beri submit -->
					<button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalEditRole" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light" id="judulRole">Edit Role</h5>
				<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">X</span>
				</button>
			</div>
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah role ini berasal dari controler role di fungsi index -->
      <?php echo form_open(base_url().'/pengaturan/role/ubah', $attr);    ?>
      <?php echo csrf_field(); ?>
      <input type="hidden" name="_method" value="PUT">
      <?php echo form_input($hidden_role_id); ?>
      <?php echo form_input($hidden_old_role); ?>
				<div class="modal-body">

					<div class="form-group">
          <?php echo form_input($roleE); ?>
					</div>

				</div>
				<div class="modal-footer">

					<!-- untuk mengirimkan ke database ci otomatis akan mengirimkannya jika typenya kita beri submit -->
					<button type="submit" id="btn-simpan" class="btn btn-block btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalHapusRole" tabindex="-1" role="dialog" aria-hidden="true">
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
        <?php echo form_open(base_url().'/pengaturan/role/hapus', $form_hapus_role);    ?>
        <?php echo form_input($hidden_role_id_hapus); ?>
        <?php echo csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>

