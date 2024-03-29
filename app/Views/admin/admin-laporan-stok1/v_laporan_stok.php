<link rel="stylesheet" type="text/css" href="<?php echo base_url().'/admin/assets/css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css"
  href="<?php echo base_url().'/admin/assets/modules/bootstrap-datepicker/datepicker.min.css' ?>">
<!-- Main Content -->

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>
        <?php echo esc($title); ?>
      </h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">

<!-- 
          <//?php echo $session->getFlashdata('pesan_data')['pesan'] ??''; ?>

          <//?php echo $session->getFlashdata('pesan_sukses'); ?> -->


        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4></h4>
              <div class="card-header-action">
                <a href="javascript:void(0)" id="print" class="btn btn-primary">
                  Print
                </a>
              </div>
            </div>

            <div class="card-body">


              <div class="row">
                <div class="col-lg-6">
                  <a href="javascript:void(0)" class="btn btn-icon icon-left btn-primary" id="tombol-tambah"><i
                      class="fas fa-plus"></i> Tambah pengeluaran</a>


                </div>

                <div class="col-lg-6">
                  <?php echo form_open(base_url().'/laporan/keuangan-bulanan/cari', $form_bulan);    ?>
                  <?php echo csrf_field(); ?>
                  <div class="form-group">
                    <label>Form pencarian</label>
                    <div class="input-group">

                      <input type="text" name="cari_bulan" id="cari_bulan" placeholder="Cari cari bulan...."
                        class="form-control <?php echo ($validation->hasError('cari_bulan')) ? 'is-invalid' : ''; ?>"
                        required />
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('cari_bulan'); ?>
                      </div>
                      <input type="text" name="cari_tahun" id="cari_tahun" placeholder="Cari cari tahun...."
                        class="form-control <?php echo ($validation->hasError('cari_tahun')) ? 'is-invalid' : ''; ?>"
                        required />
                      <div class="invalid-feedback">
                        <?php echo $validation->showError('cari_tahun'); ?>
                      </div>






                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Cari</button>
                      </div>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>


              </div>

              <div class="row" id="area-1">

                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-2">
                      <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_koperasi_inter']); ?>"
                        style="width:150px; height: 150px; object-fit:cover;">
                    </div>
                    <div class="col-8">
                      <h3 class="text-center">Laporan Stok</h3>
                      <h3 class="text-center">
                        <?php echo $toko['nama_toko']; ?>
                      </h3>
                      <h5 class="text-center">
                        <?php echo $toko['alamat_toko']; ?>
                      </h5>
                      <h5 class="text-center mb-5">HP:
                        <?php echo $toko['telepon_toko']; ?>
                      </h5>
                      <!-- <h5 class="text-right">
                        <//?php  echo  $bulan_tahun; ?>
                      </h5> -->
                    </div>
                    <div class="col-2">
                      <img src="<?php echo base_url('admin/assets/toko').'/' . esc($toko['logo_toko']); ?>"
                        style="width:130px; height: 130px; object-fit:cover;">
                    </div>
                  </div>
                  <div class="row">
                    <!-- <//?php if($validation->hasError('nama_pengeluaran')):  ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>
                        <//?php echo $validation->showError('nama_pengeluaran'); ?>
                      </strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <//?php endif;  ?>-->
                    


                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Stok Sebelum</th>
                          <th scope="col">Stok Terjual</th>
                          <th scope="col">Sisa</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;?>
                        <?php foreach($stok as $s):?>
                        <tr>
                          <th scope="row">
                          <?php  echo $i;?>
                          </th>
                          <td><?php  echo $s['nama'];?></td>
                          <td><?php  echo $s['stok_sebelum'];?></td>
                          <td><?php  echo $s['stok_terjual'];?></td>
                          <td><?php  echo $s['stok_sebelum'] - $s['stok_terjual'];?></td>

                        </tr>
                        <?php $i++;  ?>
                        <?php endforeach;?>
                      </tbody>
                    </table>











                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>



!-- Modal -->
<div class="modal fade" id="modal-muncul" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light">Tambah Pengeluaran</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->

      <form method="POST" action="<?php echo base_url('laporan/keuangan-bulanan/tambah') ?>" accept-charset="utf-8">
        <?php echo csrf_field(); ?>
        <div class="modal-body">


          <div class="alert alert-info">
            Pengeluaran yang diisi akan sesuai dengan bulan dan tahun sekarang. Anda dapat mendambahkan kolom inputan
            dengan menekan tombol di bawah.
          </div>


          <a href="javascript:void(0)" class="btn btn-primary mb-3" id="tambah-input">Tambah input</a>

          <div class="row" id="tampil-input">



            <div class="form-group col-lg-6">
              <label>Nama Pengeluaran</label>
              <input type="text" name="nama_pengeluaran[]" class="form-control"></input>
            </div>
            <div class="form-group col-lg-6">
              <label>Total Pengeluaran</label>
              <input type="number" name="total_pengeluaran[]" class="form-control"></input>
            </div>



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