
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<style type="text/css">
	#judul-error, #url-error, #icon-error, #menu_id-error {
    color: #dc3545;}
    .select2 {
width:100%!important;
}
</style>
<div  class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_submenu')  ?>"></div>
              <div  class="flash-data-edit" data-flashdata="<?php echo $session->getFlashdata('pesan_edit_submenu')  ?>"></div>
              <div  class="flash-data-hapus" data-flashdata="<?php echo $session->getFlashdata('pesan_hapus_submenu')  ?>"></div>
            
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">



            <?php if($submenu): ?>
              
            <div class="card-header">
        		<a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahSubMenu"><i class="fas fa-plus"></i> Tambah submenu</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Submenu</th>
                      <th>Menu</th>
                      <th>Url</th>
                      <th>Ikon</th>
                      <th class="text-center">Status</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                    <?php  $i =1;?>
                    <?php foreach($submenu as $sm):?>
                    <tr id="id_sub_menu_<?php echo $sm['id_submenu'];?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $sm['judul']; ?></td>
                      <td><?php echo $sm['menu']; ?></td>
                      <td><?php echo $sm['url']; ?></td>
                      <td><?php echo $sm['icon']; ?></td>
                      <td class="text-center">
                        <?php if ($sm['is_active'] == 1){
                              echo '<div class="badge badge-success">Aktif</div>';
                            }else{
                              echo '<div class="badge badge-danger">Tidak aktif</div>';
                            }
                            ?>
                      </td>
                      <td>
                        <a href="javascript:void(0)" class="edit-submenu btn btn-warning mr-1"
						data-id="<?php echo $sm['id_submenu'];?>"
						data-judul="<?php echo $sm['judul'];?>"
						data-menu_id="<?php echo $sm['menu_id'];?>"
						data-url="<?php echo $sm['url'];?>"
						data-icon="<?php echo $sm['icon'];?>"
						data-is_active="<?php echo $sm['is_active'];?>"
						
						
						><i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" class="hapus-submenu btn btn-danger" data-id="<?php echo $sm['id_submenu'];?>" ><i class="fas fa-trash"></i></a>
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
                    <button id="tombolTambahSubMenu"  class="btn btn-icon icon-left btn-primary mt-4"><i class="fas fa-plus"></i> Tambah submenu</button>


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
<div class="modal fade" id="modalSubMenu" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light">Tambah Submenu</h5>
				<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">X</span>
				</button>
			</div>

      
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
			<?php echo form_open(base_url().'/menu/tambahsubmenu', $attr); ?>
      <?php echo csrf_field(); ?>
				<div class="modal-body">

        <!-- <a href="javascript:void(0)" class="tbhs btn btn-icon icon-left btn-primary" ><i class="fas fa-plus"></i> Tambah menu</a> -->
        


					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<label>Nama submenu</label>
						
              <?php echo form_input($judul); ?>
						</div>
              
						<div class="form-group col-lg-6 col-md-6 col-sm-12" id="yumi">
							<label>Menu</label>
							<select class="custom-select" name="menu_id" id="menu_id">

								<option></option>
								<?php foreach ($mmenu as $m):?>
								<option value="<?php echo $m['id_menu']; ?>"><?php echo $m['menu']; ?></option>
								<?php endforeach;  ?>

							</select>
						</div>

           
            


						<div class="form-group col-lg-6 col-md-6">
							<label>Url</label>
							<?php echo form_input($url); ?>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<label>Ikon</label>
							<?php echo form_input($icon); ?>
						</div>


						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<div class="form-check">
                  <?php echo form_input($cecc); ?>
                  <!-- <//?php echo form_input($cecc); ?> -->
								<!-- <input class="form-check-input" type="checkbox" value="1" name="is_active"
									id="is_active" checked> -->
								<label class="form-check-label" for="is_active">
									Aktif?
								</label>
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
<div class="modal fade" id="modalEditSubMenu" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light">Edit Submenu</h5>
				<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">X</span>
				</button>
			</div>

      
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
			<?php echo form_open(base_url().'/menu/editsubmenu', $attr); ?>
      <input type="hidden" name="_method" value="PUT">
		<?php echo csrf_field(); ?>
		<?php echo form_input($hidden_submenu_id); ?>
		<?php echo form_input($hidden_judul_old); ?>
		<?php echo form_input($hidden_url_old); ?>

				<div class="modal-body">

        <!-- <a href="javascript:void(0)" class="tbhs btn btn-icon icon-left btn-primary" ><i class="fas fa-plus"></i> Tambah menu</a> -->
        


					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<label>Nama submenu</label>
						
              <?php echo form_input($judulE); ?>
						</div>
              
						<div class="form-group col-lg-6 col-md-6 col-sm-12" id="yumi">
							<label>Menu</label>
							<select class="custom-select" name="menu_idE" id="menu_idE">

								<option></option>
								<?php foreach ($mmenu as $m):?>
								<option value="<?php echo $m['id_menu']; ?>"><?php echo $m['menu']; ?></option>
								<?php endforeach;  ?>

							</select>
						</div>

           
            


						<div class="form-group col-lg-6 col-md-6">
							<label>Url</label>
							<?php echo form_input($urlE); ?>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<label>Ikon</label>
							<?php echo form_input($iconE); ?>
						</div>


						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<div class="form-check">
                  <?php echo form_input($ceccE); ?>
                  <!-- <//?php echo form_input($cecc); ?> -->
								<!-- <input class="form-check-input" type="checkbox" value="1" name="is_active"
									id="is_active" checked> -->
								<label class="form-check-label" for="is_active">
									Aktif?
								</label>
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
<div class="modal fade" id="modalHapusSubMenu" role="dialog" aria-hidden="true">
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
        <form id="btn-simpan-hapus" class="btn btn-block" method="post">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        </form>

      </div>

    </div>
  </div>
</div>

