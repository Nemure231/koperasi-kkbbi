
<link rel="stylesheet"  type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/datatabel-boot4.min.css' ?>">
<style type="text/css">
	#nama_jenis_buku-error {
		color: #dc3545;
  }
  
</style>
<!-- Main Content -->
<div id="hitung" class="<?php echo $hitung; ?>"></div>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo esc($title); ?></h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
          <div class="card card-primary">



          <?php if($jenis_buku):  ?>
          <div id="fdt" data-flashdata="<?php echo $session->getFlashdata('pesan_jenis_buku')  ?>"></div>
            <div class="card-header">
            <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombolTambahJenisBuku"><i class="fas fa-plus"></i> Tambah jenis buku</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="jenjen">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama Jenis Buku</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                    <?php  $i =1;?>
                    <?php foreach($jenis_buku as $jb):?>
                    <tr id="jenis_buku_id_<?php echo $jb['id_jenis_buku'];?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $jb['nama_jenis_buku']; ?></td>
                      <td>
                        <a href="javascript:void(0)" class="edit-jenisbuku btn btn-warning mr-1" data-id="<?php echo $jb['id_jenis_buku'];?>" ><i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" class="hapus-jenisbuku btn btn-danger" data-id="<?php echo $jb['id_jenis_buku'];?>" ><i class="fas fa-trash"></i></a>
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
                    <button id="tombolTambahJenisBukuNol"  class="btn btn-icon icon-left btn-primary mt-4"><i class="fas fa-plus"></i> Tambah jenis buku</button>


                  </div>
                </div>
            <?php endif; ?>



          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalJenisBuku" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-light" id="judulJenisBuku"></h5>
				<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <?php echo form_open('', $attr);    ?>
        <?php echo form_input($hidd); ?>
        <?php echo csrf_field(); ?>
				<div class="modal-body">

					<div class="form-group">
						<!-- name dan id ini berhubungan dengan semua data yang diambil dengan result array $data['menu'] -->
            <?php echo form_input($input_nama_jenis_buku); ?>
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

