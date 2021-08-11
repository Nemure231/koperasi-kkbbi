<section class="section-margin">
  <div class="container">
    <div class="row">
  


      <div class="col-md-12 col-lg-12 mb-3">
      <?php echo $session->getFlashdata('pesan'); ?>
        <div class="card">
          <div class="card-header">
            <h4>Produk terbaru</h4>
            <div class="card-header-action">
              <a href="<?php echo base_url().'/produk' ?>" class="btn btn-primary">
                Lihat semua
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="owl-carousel owl-theme" id="products-carousel">

              <?php foreach($lima_barang as $b):?>
              <article class="article article-style-b">
                <div class="article-header">
                  <div class="article-image"
                    data-background="<?php echo base_url('admin/assets/barang').'/'. $b['gambar']; ?>">
                  </div>
                </div>
                <div class="article-details">
                  <div class="article-title mb-2">
                    <h2><a class="text-dark" href="#"><?php echo $b['nama']; ?></a></h2>
                  </div>
                  <div class="article-header2 text-justify"></div>
                  <div class="article-cta">
                    <div class="row">

                      <div class="col-lg-12 col-md-12 col-sm-12 align-right">
                        <a class="btn btn-block btn-sm btn-primary"
                          href="<?php echo base_url().'/produk'.'/'. ''.$b['kode'].'' ?>">
                          Lihat
                        </a>
                      </div>
                    </div>

                  </div>
                </div>
              </article>
              <?php endforeach;?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Kategori</h4>
            <div class="card-header-action">
              <a href="<?php echo base_url().'/kategori' ?>" class="btn btn-primary">
                Lihat semua
              </a>
            </div>

          </div>

          <div class="card-body">
            <div class="row">


              <?php foreach($kategori as $k):?>
              <div class="col-md-4 col-lg-3 col-sm-6 mb-4">

                <a href="<?php echo base_url().'/kategori'.'/'. ''.$k['id'].'' ?>" type="button"
                  class="btn btn-block btn-primary btn-icon icon-left">
                  
                  <?php echo $k['nama']; ?>
                  <span class="badge badge-transparent"> <?php echo $k['nom']; ?></span>
                </a>

              </div>
              <?php endforeach;?>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Merek</h4>
            <div class="card-header-action">
              <a href="<?php echo base_url().'/merek' ?>" class="btn btn-primary">
                Lihat semua
              </a>
            </div>

          </div>

          <div class="card-body">
            <div class="row">


              <?php foreach($merek as $m):?>
              <div class="col-md-4 col-lg-3 col-sm-6 mb-4">

                <a href="<?php echo base_url().'/merek'.'/'. ''.$m['id'].'' ?>" type="button"
                  class="btn btn-block btn-primary btn-icon icon-left">
                  
                  <?php echo $m['nama']; ?>
                  <span class="badge badge-transparent"> <?php echo $m['nomer']; ?></span>
                </a>

              </div>
              <?php endforeach;?>
            </div>

          </div>
        </div>
      </div>
    </div>


  </div>
 

</section>

<!-- <div class="fixed-bottom mb-4">
  <div class="btn-group-vertical" role="group" aria-label="Basic example">
    <button style="background:#7676ff;" id="tombolKeranjang" type="button" class="btn btn-md text-light"
      data-toggle="tooltip" data-placement="right" title="Keranjang belanja"><i class="ti-shopping-cart"></i></button>
    <button style="background:#7676ff;" type="button" class="btn btn-md text-light" data-toggle="tooltip"
      data-placement="right" title="Transaksi Anda"><i class="ti-shopping-cart-full"></i></button>

  </div>
</div> -->