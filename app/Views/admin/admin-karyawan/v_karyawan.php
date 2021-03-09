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
                      <td><?php echo $k['nama']; ?></td>
                      <td><?php echo $k['email']; ?></td>
                      <td><?php echo $k['telepon']; ?></td>
                      <td><?php echo $k['alamat']; ?></td>
                      <td><?php echo $k['role']; ?></td>
                      <td>
                        <?php if ($k['is_active'] == 1){
                              echo '<div class="badge badge-success">Aktif</div>';
                            }else{
                              echo '<div class="badge badge-danger">Tidak aktif</div>';
                            }
                            ?>
                      </td>
                      <td>
                        <img alt="image" src="<?php echo base_url('admin/assets/profile').'/'. $k['gambar']; ?>"
                          style="height: 100px; width: 100px; object-fit:cover;">
                      </td>
                      <td>
                        <a href="javascript:void(0)" id="tombolEditUser" class="mb-3 btn btn-warning mr-1 tombolEditUser"
                          data-id_user="<?php echo $k['id_user'];?>" data-nama="<?php echo $k['nama'];?>"
                          data-telepon="<?php echo $k['telepon'];?>" data-alamat="<?php echo $k['alamat'];?>"
                          data-role_id="<?php echo $k['role_id'];?>" data-is_active="<?php echo $k['is_active'];?>"
                          data-gambar="<?php echo $k['gambar'];?>" data-email="<?php echo $k['email'];?>">
                          <i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" id="tombolHapusUser" class="btn btn-danger tombolHapusUser"
                          data-id_user="<?php echo $k['id_user'];?>">
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
            <div class="invisible"><?php echo $validation->listErrors(); ?></div>



          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<!-- Modal -->
<div class="modal fade" id="modalKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header bg-primary">
        <h5 class="modal-title text-light" id="judulKaryawan"></h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/tempat/karyawan/tambah', $formtambah);    ?>
      <!-- < ?php echo form_input($id_hidd); ?> -->
      <?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($nama); ?>
              </div>


              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Nomor Telepon</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($telepon); ?>
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Role</label>
                <select class="custom-select" name="role_id" id="role_id">
                  <option value=""></option>
                  <?php foreach ($role as $r) :?>

                  <option value="<?php echo $r['id_role'];?>"><?php echo $r['role'];?>
                  </option>
                  <?php endforeach;?>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>E-mail</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($email); ?>
              </div>

              

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Sandi</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($sandi); ?>
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Ulangi Sandi</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($ulang_sandi); ?>
              </div>

              

            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Alamat</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_textarea($alamat); ?>
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <label>Foto</label>
                <img src="<?php echo base_url('admin/assets/profile').'/'. 'default.png' ?>" class="img-thumbnail img-prev"
                  style="height: 150px; width: 150px; object-fit:cover;">
              </div>
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
              <div class="form-group col-sm-12 col-md-12 col-lg-12 mt-3 pt-1">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="gambar" name="gambar" onchange="previewImg()">
                  <label class="custom-file-label text-left cass" for="Sampulbuku">Pilih gambar</label>
                </div>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
              <input type="hidden" class="custom-switch-input1" id="is_active1" checked value="2">
                <div class="control-label">Status karyawan</div>
                <label class="custom-switch">
                  <span class="custom-switch-description mr-2">Tidak aktif</span>
                  <input type="checkbox" name="is_active" class="custom-switch-input rum" id="is_active" checked value="1">
                  
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
<div class="modal fade" id="modalKaryawanE" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header bg-primary">
        <h5 class="modal-title text-light" id="judulKaryawanE"></h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open_multipart(base_url().'/tempat/karyawan/ubah', $formedit);    ?>
      <!-- <input type="hidden" name="_method" value="PUT"> -->
      <?php echo csrf_field(); ?>
      <?php echo form_input($hiddenIdKaryawan); ?>
      <input type="hidden" id="gambarE_lama" name="gambarE_lama">
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($namaE); ?>
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Role</label>
                <select class="custom-select" name="role_idE" id="role_idE">
                  <option value=""></option>
                  <?php foreach ($role as $r) :?>

                  <option value="<?php echo $r['id_role'];?>"><?php echo $r['role'];?>
                  </option>
                  <?php endforeach;?>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Nomor Telepon</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($teleponE); ?>
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>E-mail</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_input($emailE); ?>
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Alamat</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <?php echo form_textarea($alamatE); ?>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">

              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <label>Foto</label>
                <img id="imgE" class="img-thumbnail img-prev1" style="height: 150px; width: 150px; object-fit:cover;">
              </div>
              <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="gambarE" name="gambarE" onchange="previewImg1()">
                  <label class="custom-file-label cuss text-left" id="img-labelE" for="Sampulbuku">Pilih gambar</label>
                </div>
              </div>
              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
              <input type="hidden" class="custom-switch-input cekE" id="is_activeE1" checked value="2">
                <div class="control-label">Status karyawan</div>
                <label class="custom-switch">
                  <span class="custom-switch-description mr-2">Tidak aktif</span>
                  <input type="checkbox" class="custom-switch-input cekE" id="is_activeE" value="1">
                  
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
<div class="modal fade" id="modalUserHapus" tabindex="-1" role="dialog" aria-hidden="true">
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
        <?php echo form_input($hidden_id_user); ?>
        <?php echo csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        <?php echo form_close(); ?>

      </div>

    </div>
  </div>
</div>