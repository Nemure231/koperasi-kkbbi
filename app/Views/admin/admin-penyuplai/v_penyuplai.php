<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">


<!-- Main Content -->

<style type="text/css">
  #yappa {
    padding-top: 50px;
  }

  #yahaloo {
    padding-top: -100px;
  }
</style>


<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_supplier')  ?>"></div>
<div id="flash-data-hapus" data-flashdatahapus="<?php echo $session->getFlashdata('pesan_hapus_supplier');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>
        <?php echo esc($title); ?>
      </h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">

            <?php if($supplier):  ?>

            <div class="card-header">

              <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahSupplier"><i
                  class="fas fa-plus"></i> Tambah Supplier</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="supsup">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama Supplier</th>
                      <th>Surel</th>
                      <th>Telepon</th>
                      <th>Status</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  $i =1;?>
                    <?php foreach($supplier as $s):?>
                    <tr>
                      <!-- echo substr_replace($your_text, "...", 20); -->
                      <td>
                        <?php echo $i; ?>
                      </td>
                      <td>
                        <?php echo $s['nama_pengirim_barang'] ?>
                      </td>
                      <td>
                        <?php echo $s['surel']; ?>
                      </td>
                      <td>
                        <?php echo $s['telepon']; ?>
                      </td>
                      <td>
                        <?php if ($s['status'] == 1){
                              echo '<div class="badge badge-success">Aktif</div>';
                            }else{
                              echo '<div class="badge badge-danger">Tidak aktif</div>';
                            }
                            ?>
                      </td>
                      <td>
                        <a href="javascript:void(0)" id="tombolEditSupplier"
                          class="btn btn-warning mr-1 tombolEditSupplier"
                          data-id_user="<?php echo $s['id_user'];?>"
                          data-id_supplier="<?php echo $s['id_pengirim_barang'];?>"
                          data-nama_supplier="<?php echo $s['nama_pengirim_barang'];?>"
                          data-telepon="<?php echo $s['telepon'];?>"
                          data-surel="<?php echo $s['surel'];?>"
                          data-status="<?php echo $s['status'];?>"
                          data-no_ktp="<?php echo $s['no_ktp'];?>"
                          data-pekerjaan="<?php echo $s['pekerjaan'];?>"
                          data-alamat="<?php echo $s['alamat'];?>"
                          data-no_rekening="<?php echo $s['no_rekening'];?>"
                          data-atas_nama="<?php echo $s['atas_nama'];?>"
                          data-bank="<?php echo $s['bank'];?>"
                          
                          
                          
                          
                          >
                          <i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" id="tombolHapusSupplier" class="btn btn-danger tombolHapusSupplier"
                          data-id_supplier="<?php echo $s['id_pengirim_barang'];?>"
                          data-id_user="<?php echo $s['id_user'];?>">
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
                <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahSupplier"><i
                    class="fas fa-plus"></i> Tambah supplier</a>
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
<div class="modal fade" id="modalTambahSupplier" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Supplier</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open(base_url().'/suplai/penyuplai/tambah', $form_tambah_supplier);    ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama', ''); ?>">
              </div>


              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Nomor Telepon</label>
                <input type="number" class="form-control" name="telepon"
                  value="<?php echo set_value('telepon', ''); ?>">
              </div>



              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Surel</label>
                <!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
                <input type="text" class="form-control" name="surel" value="<?php echo set_value('surel', ''); ?>">
              </div>



              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Sandi</label>
                <input type="password" class="form-control" name="sandi">
              </div>

              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Ulangi Sandi</label>
                <input type="password" class="form-control" name="ulang_sandi">
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>NIK</label>
                <input type="number" class="form-control" name="no_ktp" value="<?php echo set_value('no_ktp', ''); ?>">
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Pekerjaan</label>
                <input type="text" class="form-control" name="pekerjaan"
                  value="<?php echo set_value('pekerjaan', ''); ?>">
              </div>



            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">




              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>No Rekening</label>
                <input type="number" class="form-control" name="no_rekening"
                  value="<?php echo set_value('no_rekening', ''); ?>">
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Bank</label>
                <select class="custom-select" name="bank" value="<?php echo set_value('bank', ''); ?>">
                  <option value="">--Pilih--</option>
                  <option value="BCA">BCA</option>
                  <option value="BRI">BRI</option>
                  <option value="MANDIRI">MANDIRI</option>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Atas Nama</label>
                <input type="text" class="form-control" name="atas_nama"
                  value="<?php echo set_value('atas_nama', ''); ?>">
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"><?php echo set_value('alamat', ''); ?></textarea>
              </div>



              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <input type="hidden" name="status" value="2">
                <div class="control-label">Status</div>
                <label class="custom-switch">
                  <span class="custom-switch-description mr-2">Tidak aktif</span>
                  <input type="checkbox" name="status" class="custom-switch-input" checked value="1">

                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Aktif</span>
                </label>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-12 d-flex justify-content-center">

                <button type="submit" id="btn-simpan" class="btn btn-primary ">Simpan</button>

              </div>





            </div>

          </div>


        </div>
        <div class="modal-footer">
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditSupplier" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Supplier</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open(base_url().'/suplai/penyuplai/ubah', $form_edit_supplier);    ?>
      <input type="hidden" name="_method" value="PUT">
      <?php echo form_input($hidden_id_supplier); ?>
      <?php echo form_input($hidden_old_nama_supplier); ?>
      <input type="hidden" id="edit_id_user" name="edit_id_user">
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Nama</label>
                <input type="text" class="form-control" name="edit_nama" id="edit_nama">
              </div>


              <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label>Nomor Telepon</label>
                <input type="number" class="form-control" name="edit_telepon" id="edit_telepon">
              </div>



              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Surel</label>
                <input type="text" class="form-control" name="edit_surel" id="edit_surel">
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>NIK</label>
                <input type="number" class="form-control" name="edit_no_ktp" id="edit_no_ktp" >
              </div>

              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <label>Pekerjaan</label>
                <input type="text" class="form-control" name="edit_pekerjaan" id="edit_pekerjaan">
              </div>



            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">




              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>No Rekening</label>
                <input type="number" class="form-control" name="edit_no_rekening" id="edit_no_rekening">
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label>Bank</label>
                <select class="custom-select" name="edit_bank" id="edit_bank">
                  <option value="">--Pilih--</option>
                  <option value="BCA">BCA</option>
                  <option value="BRI">BRI</option>
                  <option value="MANDIRI">MANDIRI</option>
                </select>
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Atas Nama</label>
                <input type="text" class="form-control" id="edit_atas_nama" name="edit_atas_nama">
              </div>

              <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label>Alamat</label>
                <textarea name="edit_alamat" id="edit_alamat" class="form-control"></textarea>
              </div>



              <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                <input type="hidden" name="edit_status" value="2">
                <div class="control-label">Status</div>
                <label class="custom-switch">
                  <span class="custom-switch-description mr-2">Tidak aktif</span>
                  <input type="checkbox" name="edit_status" id="edit_status" class="custom-switch-input" value="1">

                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Aktif</span>
                </label>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-12 d-flex justify-content-center">

                <button type="submit" id="btn-simpan" class="btn btn-primary ">Simpan</button>

              </div>





            </div>

          </div>


        </div>
        <div class="modal-footer">
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>              




  <!-- Modal -->
  <div class="modal fade" id="modalSupplierHapus" tabindex="-1" role="dialog" aria-hidden="true">
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
          <?php echo form_open(base_url().'/suplai/penyuplai/hapus', $form_hapus_supplier);    ?>
          <?php echo form_input($hidden_id_supplierH); ?>
          <?php echo csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
          <?php echo form_close(); ?>

        </div>

      </div>
    </div>
  </div>
