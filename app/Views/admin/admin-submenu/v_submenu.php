
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
                      <th>Menu Utama</th>
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
                      <td><?php echo $sm['nama_submenu']; ?></td>
                      <td><?php echo $sm['nama_menu']; ?></td>
                      <td><?php echo $sm['nama_menu_utama']; ?></td>
                      <td><?php echo $sm['url_submenu']; ?></td>
                      <td><?php echo $sm['ikon_submenu']; ?></td>
                      <td class="text-center">
                        <?php if ($sm['status_submenu'] == 1){
                              echo '<div class="badge badge-success">Aktif</div>';
                            }else{
                              echo '<div class="badge badge-danger">Tidak aktif</div>';
                            }
                            ?>
                      </td>
                      <td>
                        <a href="javascript:void(0)" class="edit-submenu btn btn-warning mr-1"
						data-id="<?php echo $sm['id_submenu'];?>"
						data-judul="<?php echo $sm['nama_submenu'];?>"
						data-menu_id="<?php echo $sm['menu_id'];?>"
						data-url="<?php echo $sm['url_submenu'];?>"
						data-icon="<?php echo $sm['ikon_submenu'];?>"
						data-is_active="<?php echo $sm['status_submenu'];?>"
            data-menu_utama_id="<?php echo $sm['menu_utama_id'];?>"
						
						
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
              <div class="validasi_tambah">
              0
              <?php $validasi_tambah = $session->getFlashdata('pesan_validasi_tambah_submenu');
              
              if($validasi_tambah){
                echo $validasi_tambah['nama_submenu']; 
                echo $validasi_tambah['menu_id']; 
                echo $validasi_tambah['menu_utama_id']; 
                echo $validasi_tambah['ikon_submenu']; 
                echo $validasi_tambah['url_submenu'];

              }
              
              ?>
              

              </div>
              <div class="validasi_edit">
              0
              <?php $validasi_edit = $session->getFlashdata('pesan_validasi_edit_submenu');
              
              if($validasi_edit){
                echo $validasi_edit['nama_submenu']; 
                echo $validasi_edit['menu_id']; 
                echo $validasi_edit['menu_utama_id']; 
                echo $validasi_edit['ikon_submenu']; 
                echo $validasi_edit['url_submenu'];

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
<div class="modal fade" data-backdrop="static" id="modalSubMenu" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light">Tambah Submenu</h5>
				<button type="button" class="close tutup-modal text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">X</span>
				</button>
			</div>

      
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
			<?php echo form_open(base_url().'/pengaturan/submenu/tambah', $form_tambah); ?>
        <?php $pesan_tambah = $session->getFlashdata('pesan_validasi_tambah_submenu');?>
				<div class="modal-body">

					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<label>Nama submenu</label>
              <?php echo tambah_input_helper('nama_submenu', 'text', $pesan_tambah['nama_submenu'] ?? []); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['nama_submenu'].'</div>' : ''; ?>
						</div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12">
							<label>Menu Utama</label>
							<select class="custom-select <?php echo ($pesan_tambah['menu_utama_id'] ?? []) ? 'is-invalid' : ''; ?>" name="menu_utama_id" id="menu_utama_id">

								<option value="">--Pilih--</option>
								<?php foreach ($menu_utama as $mu):?>
								<option value="<?php echo $mu['id_menu_utama']; ?>"><?php echo $mu['nama_menu_utama']; ?></option>
								<?php endforeach;  ?>

							</select>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['menu_utama_id'].'</div>' : ''; ?>
						</div>
              
						<div class="form-group col-lg-6 col-md-6 col-sm-12" id="yumi">
							<label>Menu</label>
							<select class="custom-select <?php echo ($pesan_tambah['menu_id'] ?? []) ? 'is-invalid' : ''; ?>" name="menu_id" id="menu_id">

									<option value="">--Pilih--</option>
								<?php foreach ($mmenu as $m):?>
								<option value="<?php echo $m['id_menu']; ?>"><?php echo $m['nama_menu']; ?></option>
								<?php endforeach;  ?>

							</select>
              <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['menu_id'].'</div>' : ''; ?>
						</div>


						<div class="form-group col-lg-6 col-md-6 col-sm-12">
							<label>Url</label>
              <?php echo tambah_input_helper('url_submenu', 'text', $pesan_tambah['url_submenu'] ?? []); ?>
              <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['url_submenu'].'</div>' : ''; ?>
						</div>
						<div class="form-group col-lg-6 col-md-6 col-sm-6">
            <label>Ikon</label>
            <?php echo tambah_input_helper('ikon_submenu', 'text', $pesan_tambah['ikon_submenu'] ?? []); ?>
              <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['ikon_submenu'].'</div>' : ''; ?>
						</div>

						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<div class="form-check">
                <?php echo form_input([
                  'id' => 'status_submenu',
                  'name' => 'status_submenu',
                  'type'=> 'checkbox',
                  'value'=> '1',
                  'class'=> 'form-check-input status_submenu',
                  'checked' => ''
                ]); ?>
								<label class="form-check-label" for="status_submenu">
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
<div class="modal fade" id="modalEditSubMenu" data-backdrop="static" class="modalEditSubMenu" role="dialog" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light">Edit Submenu</h5>
				<button type="button" class="close tutup-modal text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">X</span>
				</button>
			</div>

      
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
			<?php echo form_open(base_url().'/pengaturan/submenu/ubah', $form_edit); ?>
      <?php $old_data = $session->getFlashdata('old_edit_input');?>
      <input type="hidden" name="_method" value="PUT">
      <?php echo edit_input_id_helper('edit_id_submenu', 'edit_id_submenu', $old_data['id_submenu'] ?? '', 'hidden'); ?>
        <?php $pesan_edit = $session->getFlashdata('pesan_validasi_edit_submenu');?>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<label>Nama submenu</label>
						
              <?php echo edit_input_helper('edit_nama_submenu', 'edit_nama_submenu', 'text', $pesan_edit['nama_submenu'] ?? []); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['nama_submenu'].'</div>' : ''; ?>
						
						</div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12">
							<label>Menu Utama</label>
              <input id="old_menu_utama_id" type="hidden" value="<?php echo $old_data['menu_utama_id'] ?? ''; ?>" />
							<select class="custom-select hapus-validasi-border <?php echo ($pesan_edit['menu_utama_id'] ?? []) ? 'is-invalid' : ''; ?>" name="edit_menu_utama_id" id="edit_menu_utama_id">
									<option value="">--Pilih--</option>
								<?php foreach ($menu_utama as $mu):?>
								<option value="<?php echo $mu['id_menu_utama']; ?>"><?php echo $mu['nama_menu_utama']; ?></option>
								<?php endforeach;  ?>

							</select>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['menu_utama_id'].'</div>' : ''; ?>
						</div>
              
						<div class="form-group col-lg-6 col-md-6 col-sm-12">
							<label>Menu</label>
              <input id="old_menu_id" type="hidden" value="<?php echo $old_data['menu_id'] ?? ''; ?>" />
							<select class="custom-select hapus-validasi-border <?php echo ($pesan_edit['menu_id'] ?? []) ? 'is-invalid' : ''; ?>" name="edit_menu_id" id="edit_menu_id">

									<option value="">--Pilih--</option>
								<?php foreach ($mmenu as $m):?>
								<option value="<?php echo $m['id_menu']; ?>"><?php echo $m['nama_menu']; ?></option>
								<?php endforeach;  ?>

							</select>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['menu_id'].'</div>' : ''; ?>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-sm-12">
							<label>Url</label>
              <?php echo edit_input_helper('edit_url_submenu', 'edit_url_submenu', 'text', $pesan_edit['url_submenu'] ?? []); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['url_submenu'].'</div>' : ''; ?>
						
						</div>
						<div class="form-group col-lg-6 col-md-6 col-sm-12">
							<label>Ikon</label>
              <?php echo edit_input_helper('edit_ikon_submenu', 'edit_ikon_submenu', 'text', $pesan_edit['ikon_submenu'] ?? []); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['ikon_submenu'].'</div>' : ''; ?>
						
						</div>


						<div class="form-group col-lg-12 col-md-12 col-sm-12">
							<div class="form-check">
              <?php echo form_input([
                  'id' => 'edit_status_submenu',
                  'name' => 'edit_status_submenu',
                  'type'=> 'checkbox',
                  'value'=> '1',
                  'class'=> 'form-check-input',
                  'checked' => ''
                ]); ?>
								<label class="form-check-label" for="edit_status_submenu">
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
<div class="modal fade" data-backdrop="static" id="modalHapusSubMenu" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light"></h5>
        <button type="button" class="close tutup-modal text-danger" data-dismiss="modal" aria-label="Close">
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
        <?php echo form_open(base_url().'/pengaturan/submenu/hapus', $form_hapus);    ?>
          <?php echo form_input($hapus_id_submenu); ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger">Ya, hapus!</button>
          <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

