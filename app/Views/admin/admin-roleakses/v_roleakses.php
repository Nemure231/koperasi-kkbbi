<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<div class="flash-data" data-flashdata="<?php echo $session->getFlashdata('pesan_akses');  ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title).' - '.''.$idrole['role'].'' ?> </h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card card-primary">


          <?php if($menurole):  ?>
            <div class="card-header">
              <h4></h4>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="rlrl">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Role</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  $i =1;?>
                    <?php foreach($menurole as $mr):?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $mr['menu'];  ?></td>
                      <td>
                      <div class="form-group">
                          <div class="control-label"></div>
                          <label class="custom-switch">
                            <span class="custom-switch-description mr-2">Tidak aktif</span>
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                            <?php echo check_akses($idrole['id_role'], $mr['id_menu']);?>
                            data-role="<?php echo $idrole['id_role']; ?>"
												    data-menu="<?php echo $mr['id_menu']; ?>">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Aktif</span>
                          </label>
                        </div>
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
                      <a href="<?php echo base_url().'/pengaturan/menu' ?>"  class="btn btn-icon icon-left btn-primary mt-4"><i class="fas fa-plus"></i> Tambah menu</a>

      
                    </div>
                  </div>



            
            <?php endif; ?>







          </div>
        </div>
      </div>
    </div>
  </section>
</div>