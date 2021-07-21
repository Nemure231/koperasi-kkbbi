<section class="section-margin">
  <div class="container">
    <div class="row">

      <div class="col-lg-12 mt-5 mb-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb text-white-all" style="background-color:#7676ff;">
          <li class="breadcrumb-item"><a href="<?php echo base_url().'/' ?>">Beranda</a></li>
      
            <li class="breadcrumb-item"><a href="<?php echo base_url().'/genre' ?>">Genre</a></li>
            <?php if($judul): ?>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $judul['nama_genre']; ?></li>
            <?php else  : ?>
              <li class="breadcrumb-item active" aria-current="page">Data Kosong!</li>
            <?php endif; ?>
          
          </ol>
        </nav>
      </div>

      <div class="col-lg-12">
        <div class="row">

          <?php if($genreuri): ?>

            <?php foreach($genreuri as $gu):?>
          <div class="col-12 col-sm-6 col-md-6 col-lg-3 post">
            <article class="article article-style-b">
              <div class="article-header">
                <div class="article-image"
                  data-background="<?php echo base_url('admin/assets/buku').'/'. $gu['sampul_buku']; ?>">
                </div>

              </div>
              <div class="article-details">
                <div class="article-title mb-2">
                  <h2><a class="text-dark" href="#"><?php echo $gu['judul_buku']; ?></a></h2>
                </div>
                <div class="article-header2 text-justify">Hai halo adios gracisa</div>
                <div class="article-cta">
                  <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 align-right">
                      <a class="btn btn-block btn-sm btn-primary"
                        href="<?php echo base_url().'/produk'.'/'. ''.$gu['uri_buku'].'' ?>">
                        Detail
                      </a>
                    </div>
                  </div>




                </div>
              </div>
            </article>
          </div>
          <?php endforeach;?>
          

          <?php else  : ?>

            <div class="col-lg-12">

            <div class="empty-state" data-height="400">
              <div class="empty-state-icon bg-danger">
                <i class="ti-help"></i>
              </div>
              <h2>Data Kosong</h2>
              <p class="lead">
                Maaf, data yang anda cari tidak ada. Silakan kembali, dan periksa lain kali, terima kasih.
              </p>
              <a href="<?php echo base_url().'/jenis' ?>" class="btn btn-warning mt-4">Kembali</a>
            </div>

          </div>

          

          <?php endif; ?>




        </div>

      </div>



    </div>
  </div>

</section>