<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">



<!-- Main Content -->

<style type="text/css">
  #yappa {padding-top: 50px;}#yahaloo {padding-top: -100px;}
  .select2 {
width:100%!important;
}
</style>


<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan')  ?>"></div>
<div id="flash-data-hapus" data-flashdatahapus="<?php echo $session->getFlashdata('hapus_karyawan');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">
           

            <?php if($karyawan):   ?>

            <div class="card-header">

              <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahUser"><i
                  class="fas fa-plus"></i> Tambah karyawan</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="usus">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama</th>
                      <th>E-mail</th>
                      <th>Telepon</th>
                      <th>Alamat</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th>Foto</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($karyawan): ?>
                    <?php  $i =1;?>
                    <?php foreach($karyawan as $k):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $k['name']; ?></td>
                      <td><?php echo $k['email']; ?></td>
                      <td><?php echo $k['telepon']; ?></td>
                      <td><?php echo $k['alamat']; ?></td>
                      <td><?php echo $k['nama_role']; ?></td>
                      <td>
                        <?php if ($k['status'] == 1){
                              echo '<div class="badge badge-success">Aktif</div>';
                            }else{
                              echo '<div class="badge badge-danger">Tidak aktif</div>';
                            }
                            ?>
                      </td>
                      <td>
                  
                        <img src="<?php echo gambar_karyawan($k['id']); ?>" id="tampil_gambar" style="height: 100px; width: 100px; object-fit:cover;"/>
                      </td>
                      <td>
                        <a href="javascript:void(0)" id="tombolEditUser" class="btn btn-warning tombolEditUser"
                          data-id_user="<?php echo $k['id'];?>" data-nama="<?php echo $k['name'];?>"
                          data-telepon="<?php echo $k['telepon'];?>" data-alamat="<?php echo $k['alamat'];?>"
                          data-role_id="<?php echo $k['role_id'];?>" data-is_active="<?php echo $k['status'];?>"
                          data-gambar="<?php echo $k['gambar'];?>" data-email="<?php echo $k['email'];?>"
                          data-tampil-gambar="<?php echo gambar_karyawan($k['id']); ?>">
                          <i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" id="tombolHapusUser" class="btn btn-danger tombolHapusUser"
                          data-id_user="<?php echo $k['id'];?>"
                          data-gambar="<?php echo $k['gambar'];?>">
                          <i class="fas fa-trash"></i>
                        </a>
                        
                      </td>
                    </tr>
                    <?php $i++;  ?>
                    <?php endforeach;?>
                    <?php endif; ?>
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
                <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahBuku"><i
                    class="fas fa-plus"></i> Tambah karyawan</a>
              </div>
            </div>
            <?php endif; ?>
            <div class="invisible">
              <div class="validasi_tambah">
              0
              <?php $validasi_tambah = $session->getFlashdata('pesan_validasi_tambah_karyawan');
              // $validasi_gambar_tambah = $session->getFlashdata('pesan_validasi_tambah_karyawan_gambar');


              if($validasi_tambah){
                echo $validasi_tambah['name']; 
                echo $validasi_tambah['email']; 
                echo $validasi_tambah['password'];
                echo $validasi_tambah['telepon'];
                echo $validasi_tambah['alamat'];
                echo $validasi_tambah['gambar'];
                echo $validasi_tambah['role_id'];
              }

              // if($validasi_gambar_tambah){
              //   echo $validasi_gambar_tambah;
              // }
              
              
              ?>
              

              </div>
              <div class="validasi_edit">
              0
              <?php $validasi_edit = $session->getFlashdata('pesan_validasi_edit_karyawan');
              // $validasi_gambar_edit = $session->getFlashdata('pesan_validasi_edit_karyawan_gambar');
              
              if($validasi_edit){
                echo $validasi_edit['name']; 
                echo $validasi_edit['email']; 
                echo $validasi_edit['telepon'];
                echo $validasi_edit['alamat'];
                echo $validasi_edit['gambar'];
                echo $validasi_edit['role_id'];

              }

              // if($validasi_gambar_edit){
              //   echo $validasi_gambar_edit;
              // }

              // echo $validation->showError('gambarE');
              
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
<div class="modal fade" data-backdrop="static" id="modalKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Karyawan</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/tempat/karyawan/tambah', $form_tambah);    ?>
      <?php $pesan_tambah = $session->getFlashdata('pesan_validasi_tambah_karyawan');?>
      <!-- <//?php $pesan_tambah_gambar = $session->getFlashdata('pesan_validasi_tambah_karyawan_gambar');?> -->
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama</label>
                <?php echo tambah_input_helper('name', 'text', $pesan_tambah['name'] ?? []); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['name'].'</div>' : ''; ?>
              </div>


              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Nomor Telepon</label>
                <?php echo tambah_input_helper('telepon', 'number', $pesan_tambah['telepon'] ?? []); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['telepon'].'</div>' : ''; ?>
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Role</label>
                <select class="custom-select <?php echo ($pesan_tambah['role_id'] ?? []) ? 'is-invalid' : ''; ?>" name="role_id" id="role_id">
                  <option value="">--Pilih--</option>
                  <?php foreach ($role as $r) :?>

                  <option value="<?php echo $r['id_role'];?>"><?php echo $r['nama_role'];?>
                  </option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['role_id'].'</div>' : ''; ?>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>E-mail</label>
                <?php echo tambah_input_helper('email', 'text', $pesan_tambah['email'] ?? []); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['email'].'</div>' : ''; ?>
              </div>

              

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Sandi</label>
                <?php echo tambah_input_password_helper('password', 'password', $pesan_tambah['password'] ?? []); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['password'].'</div>' : ''; ?>
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Ulangi Sandi</label>
                <?php echo tambah_input_password_helper('password_confirmation', 'password', $pesan_tambah['password'] ?? []); ?>
              </div>

              

            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Alamat</label>
                <?php echo tambah_textarea_helper('alamat', 'text', $pesan_tambah['alamat'] ?? []); ?>
                <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['alamat'].'</div>' : ''; ?>
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <label>Foto</label>
                <img src="<?php echo base_url('admin/assets/profile').'/'. 'default.png' ?>" class="img-thumbnail img-prev"
                  style="height: 150px; width: 150px; object-fit:cover;">
                  
              </div>
    
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
              <div class="form-group col-sm-12 col-md-12 col-lg-12 mt-3 pt-1">
                <div class="custom-file">
                  <input type="file" class="custom-file-input <?php echo ($pesan_tambah['gambar'] ?? []) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImg()">
                  <?php echo ($pesan_tambah ?? []) ? '<div class="invalid-feedback">'.$pesan_tambah['gambar'].'</div>' : ''; ?>
              
                  <label class="custom-file-label text-left cass" for="Sampulbuku">Pilih gambar</label>
                </div>

               
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="control-label">Status karyawan</div>
                <label class="custom-switch">
                  <span class="custom-switch-description mr-2">Tidak aktif</span>
                  <input type="hidden" name="status" value="2">
                  <input type="checkbox" name="status" class="custom-switch-input" id="status" checked value="1">
                  
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Aktif</span>
                </label>
              </div>



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
<div class="modal fade" data-backdrop="static" id="modalKaryawanE" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Edit Karyawan</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/tempat/karyawan/ubah', $form_edit);    ?>
      <?php $pesan_edit_gambar = $session->getFlashdata('pesan_validasi_edit_karyawan_gambar');?>
      <?php $old_data = $session->getFlashdata('old_edit_input');?>
      <?php echo edit_input_id_helper('edit_id_karyawan', 'edit_id_karyawan', $old_data['id'] ?? '', 'hidden'); ?>
      <?php $pesan_edit = $session->getFlashdata('pesan_validasi_edit_karyawan');?>
      
      <input type="hidden" id="edit_gambar_lama" name="edit_gambar_lama" value="<?php echo  $old_data['gambar'] ?? ''; ?> ">
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama</label>
                <?php echo edit_input_helper('edit_name', 'edit_name', 'text', $pesan_edit['name'] ?? []); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['name'].'</div>' : ''; ?>
						
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Role</label>
                <input id="old_role_id" type="hidden" value="<?php echo $old_data['role_id'] ?? ''; ?>" />
                <select class="custom-select hapus-validasi-border <?php echo ($pesan_edit['role_id'] ?? []) ? 'is-invalid' : ''; ?>" name="edit_role_id" id="edit_role_id">
                  <option value=""></option>
                  <?php foreach ($role as $r) :?>

                  <option value="<?php echo $r['id_role'];?>"><?php echo $r['nama_role'];?>
                  </option>
                  <?php endforeach;?>
                </select>
                <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['role_id'].'</div>' : ''; ?>
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Nomor Telepon</label>
                <?php echo edit_input_helper('edit_telepon', 'edit_telepon', 'number', $pesan_edit['telepon'] ?? []); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['telepon'].'</div>' : ''; ?>
						
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>E-mail</label>
                <?php echo edit_input_helper('edit_email', 'edit_email', 'text', $pesan_edit['email'] ?? []); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['email'].'</div>' : ''; ?>
						
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Alamat</label>
                <?php echo edit_textarea_helper('edit_alamat', 'edit_alamat', 'text', $pesan_edit['alamat'] ?? []); ?>
              <?php echo ($pesan_edit ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit['alamat'].'</div>' : ''; ?>
						
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <label>Foto</label>
                <input id="old_gambar" type="hidden" value="<?php echo $old_data['gambar'] ?? ''; ?>" />
                <img id="imgE" class="img-thumbnail img-prev1 edit_tampil_gambar" style="height: 150px; width: 150px; object-fit:cover;">
              </div>
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <div class="custom-file">
                  <input type="file" class="custom-file-input hapus-validasi-border <?php echo ($pesan_edit_gambar ?? []) ? 'is-invalid' : ''; ?>" value="<?php echo set_value('edit_gambar', '') ?>" id="edit_gambar" name="edit_gambar" onchange="previewImg1()">
                  <label class="custom-file-label cuss text-left" id="img-labelE" for="Sampulbuku">Pilih gambar</label>
                
                  <?php echo ($pesan_edit_gambar ?? []) ? '<div class="invalid-feedback hapus-validasi">'.$pesan_edit_gambar.'</div>' : ''; ?>
              
                </div>
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="control-label">Status karyawan</div>
                <label class="custom-switch">
                  <span class="custom-switch-description mr-2">Tidak aktif</span>
                  <input type="hidden" name="edit_status" value="2">
                  <input type="checkbox" class="custom-switch-input" name="edit_status" id="edit_status" value="1">
                  
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Aktif</span>
                </label>
              </div>
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
<div class="modal fade" data-backdrop="static" id="modalUserHapus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light" id="judulUserHapus"></h5>
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


        <?php echo form_open(base_url().'/tempat/karyawan/hapus', $form_hapus);    ?>
        <?php echo form_input($hapus_id_karyawan); ?>
        <?php echo form_input($hapus_gambar); ?>
        
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>