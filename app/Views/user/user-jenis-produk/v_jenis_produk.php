<section class="section-margin">
  <div class="container">
    <div class="row">

    <div class="col-lg-12 mt-5 mb-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb text-white-all" style="background-color:#7676ff;">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'/' ?>">Beranda</a></li>
            <?php if($jenis): ?>
              <li class="breadcrumb-item active" aria-current="page">Jenis Produk</li>
            <?php else  : ?>
              <li class="breadcrumb-item active" aria-current="page">Data Kosong!</li>
            <?php endif; ?>
          
          </ol>
        </nav>
      </div>


      <?php if($jenis): ?>

      <div class="col-lg-12 mt-5">
        <div class="row">

        <?php foreach($jenis as $jb):?>
            <div class="col-md-3 col-lg-3 col-sm-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4><?php echo $jb['nama_jenis_buku']; ?></h4>
                  <div class="card-header-action">
                    <a href="<?php echo base_url().'/jenis'.'/'. ''.$jb['uri_jenis_buku'].'' ?>" class="btn btn-primary">
                      View All
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <p>gggg</p>
                </div>
              </div>
            </div>
            <?php endforeach;?>
        
      
      </div>  
    
    </div>

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
  </div>

</section>