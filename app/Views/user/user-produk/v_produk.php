<section class="section-margin">
  <div class="container">
    <div class="row">

    <div class="col-lg-12 mt-5 mb-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb text-white-all" style="background-color:#7676ff;">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'/' ?>">Beranda</a></li>
            <?php if($barang): ?>
              <li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
            <?php else  : ?>
              <li class="breadcrumb-item active" aria-current="page">Data Kosong!</li>
            <?php endif; ?>
          
          </ol>
        </nav>
      </div>

      <?php if($barang): ?>

        <div class="col-lg-12">
    <div class="row">
      <div class="col-md-3 col-lg-2 text-center text-md-left mb-3 mb-md-0">
          <h3>Cari produk!</h3>
        </div>
        <div class="col-md-9 col-lg-10 pl-2 pl-xl-5 mb-3">
          <?php echo form_open(base_url().'/produk', $form_cari); ?>
            <div class="form-group">
              <label for="staticDomainSearch" class="sr-only text-dark">Cari produk</label>
              <input type="text" name="kunci" class="form-control" id="staticDomainSearch" placeholder="Masukan pencarianmu ....">
            </div>
            <button type="submit" name="submit" class="button rounded-0">Search</button>
          <?php echo form_close(); ?>
          

        </div>
        </div>
        </div>
      
      <?php foreach($barang as $b):?>

      <div class="col-12 col-sm-6 col-md-6 col-lg-3 post">
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
            
                <div class="col-lg-12 col-md-12 col-sm-12">
                <a class="btn btn-block btn-sm btn-primary" href="<?php echo base_url().'/produk'.'/'. ''.$b['kode'].'' ?>">
              Lihat
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
              <a href="<?php echo base_url().'/produk' ?>" class="btn btn-warning mt-4">Kembali</a>
            </div>

          </div>

    
      <?php endif; ?>

    </div>
    <?php echo $pager->links('beranda', 'beranda_pagination'); ?>
  </div>

</section>
