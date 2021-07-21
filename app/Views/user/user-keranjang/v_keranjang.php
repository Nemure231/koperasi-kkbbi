<section class="section-margin">
  <div class="container">
    <div class="row">
      <div class="col-lg-12" id="addhtml">
        <?php echo $session->getFlashdata('pesan_keranjang'); ?>
      </div>



      <?php if($keranjang): ?>
      <div class="col-lg-12" id="purgeall">
          <?php echo form_input($kode_hidd); ?>
          <div class="card card-primary">
            <div class="card-header">
              <h4>Daftar Keranjang</h4>
              <div class="card-header-action">
              <a href="javascript:void(0)" id="tombolhapuskall" class="btn btn-danger"
                         >Hapus semua data keranjang</a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              

                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nama Produk</th>
                      <th scope="col">Harga</th>
                      <th scope="col">QTY</th>
                      <th scope="col">Subtotal</th>
                      <th scope="col">Opsi</th>
                    </tr>
                  </thead>
                  <tbody id="hap">
                    <?php  $i =1;?>
                    <?php foreach($keranjang as $k):?>
                    <tr>
                      <th scope="row"><?php echo $i; ?></th>
                      <td><?php echo $k['judul_buku']; ?></td>
                      <td><?php echo $k['harga_buku']; ?></td>
                      <td><?php echo $k['tt_qty']; ?></td>
                      <td><?php echo $k['tt_qty'] * $k['harga_buku'] ?></td>
                      <td>

                        <a href="javascript:void(0)" id="tombolhapusk" class="btn btn-danger"
                          data-kode="<?php echo $k['k_kode_keranjang']; ?>">Hapus</a>

                      </td>
                    </tr>
                    <?php $i++;  ?>
                    <?php endforeach;?>

                  </tbody>
                </table>
              </div>
              <div class="row" id="purge">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Awal</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="ti-time"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" name="ts_awal" id="ts_awal">
                    </div>
                    <div class="text-danger">
                      <?php echo $validation->showError('ts_awal'); ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Sampai</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="ti-time"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" name="ts_sampai" id="ts_sampai">

                    </div>
                    <div class="text-danger">
                      <?php echo $validation->showError('ts_sampai'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right" id="heya">
              <!-- <button type="submit" id="btn-submitt" class="btn btn-primary">Bayar</button> -->
              <a href="javascript:void(0)" class="btn btn-primary btn-submit" data-kodet="<?php echo $kode; ?>"
                id="tbhts">Bayar</a>
            </div>
          </div>
        
      </div>
      <?php else  : ?>

      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Keranjang Kosong</h4>
          </div>
          <div class="card-body">
            <div class="empty-state" data-height="400">
              <div class="empty-state-icon bg-danger"><i class="ti-help"></i></div>
              <h2>Anda tidak memiliki produk di keranjang</h2>
              <p class="lead">Silakan periksa daftar produk yang tersedia</p><a href="<?php echo base_url().'/produk' ?>"
                class="btn btn-icon icon-left btn-primary mt-4">Daftar produk</a>
            </div>
          </div>
        </div>
      </div>

      <?php endif; ?>




    </div>



  </div>

</section>





<!-- Modal -->
<div class="modal fade" id="modalhapusk" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light" id="judulk"></h5>
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
                    <i class="ti-help"></i>
                  </div>
                  <h2>Yakin ingin menghapus?</h2>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">

        <form id="btn-hapus-keranjang" class="btn btn-block" method="post">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Ya, hapus!</button>
        </form>

      </div>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalhapuskall" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light" id="judulk"></h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i style="font-size: 24px;" class="fas fa-10x fa-times"></i></span>
        </button>
      </div>
      <!-- form action adalah tempat di mana fungsinya berasal, misal tambah menu ini berasal dari controler menu di fungsi index -->
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="empty-state" data-height="80">
                  <div class="empty-state-icon bg-danger">
                    <i class="ti-help"></i>
                  </div>
                  <h2>Yakin ingin semua data keranjang?</h2>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">

      <form class="btn btn-block" action="<?php echo base_url().'/kecohhapusallkeranjanguser'.'/'.''.$id_session.'' ?>" method="post" accept-charset="utf-8">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">Hapus keranjang</button>
              </form>

      </div>

    </div>
  </div>
</div>