<section class="section-margin">
  <div class="container">
    <div class="row">
     

      <!-- <//?php if($user && !$user['telepon'] && !$user['alamat']): ?>
      <div class="col-12 mb-4 mt-5">
        <div class="hero text-white hero-bg-image hero-bg-parallax"
          style="background-image: url('<//?php echo base_url('user/assets1/hero/andre-benz-1214056-unsplash.jpg'); ?>');">
          <div class="hero-inner">
            <h2 class="text-light">Halo, <//?php echo $user['nama']; ?></h2>
            <p class="lead">Terima kasih telah mendaftar, pastikan data diri anda lengkap sebelum mengakses situs ini.
            </p>
            <div class="mt-4">
              <a href="<//?php echo base_url().'/profil'?>" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i> Atur data
                diri</a>
            </div>
          </div>
        </div>
      </div>
      <//?php endif; ?> -->


      <div class="col-md-12 col-lg-12 mb-3">
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
                          Detail
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
            <h4>Jenis buku</h4>

          </div>

          <div class="card-body">
            <div class="row">


              <?php foreach($kategori as $k):?>
              <div class="col-md-4 col-lg-3 col-sm-6 mb-4">

                <a href="<?php echo base_url().'/kategori'.'/'. ''.$k['id'].'' ?>" type="button"
                  class="btn btn-block btn-primary btn-icon icon-left">
                  <i class="ti-book"></i>
                  <?php echo $k['nama']; ?>
                  <span class="badge badge-transparent"> <?php echo $k['nom']; ?></span>
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