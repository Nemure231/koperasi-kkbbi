<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container box_1620">
          <a class="navbar-brand logo_h" href="<?php echo base_url().'/' ?>"><img style="width: 80px; height: 80px; object-fit: cover;" src="<?php echo base_url('user/assets/logo').'/'. 'kkbbi.png' ?>" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav justify-content-end">
              <li class="nav-item <?php echo ($title == 'Beranda') ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url().'/' ?>">Beranda</a></li> 
              
              <li class="nav-item submenu dropdown 
                <?php 
                  if($title == 'Produk'){
                    echo 'active';
                  }elseif($title == 'Daftar Produk'){
                    echo 'active';
                  }elseif($title == 'Detail Produk'){
                    echo 'active';
                  }elseif($title == 'Jenis Produk'){
                    echo 'active';
                  }elseif($title == 'Detail Jenis Produk'){
                    echo 'active';
                  }elseif($title == 'Daftar Penerbit'){
                    echo 'active';
                  }elseif($title == 'Detail Penerbit'){
                    echo 'active';
                  }elseif($title == 'Daftar Genre'){
                    echo 'active';
                  }elseif($title == 'Detail Genre'){
                    echo 'active';
                  }elseif($title == 'Daftar Penulis'){
                    echo 'active';
                  }elseif($title == 'Detail Penulis'){
                    echo 'active';
                  }
                
                
                ?> 
              
              ">
                <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Produk</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/produk' ?>">Daftar Produk</a>                 
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/jenis' ?>">Jenis Produk</a>
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/penulis' ?>">Daftar Penulis</a>
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/genre' ?>">Daftar Genre</a>
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/penerbit' ?>">Daftar Penerbit</a>                    
                </ul>
							</li>

              <li class="nav-item submenu dropdown 
                <?php 
                  if($title == 'Informasi'){
                    echo 'active';
                  }elseif($title == 'Tentang Kami'){
                    echo 'active';
                  }elseif($title == 'Lokasi'){
                    echo 'active';
                  }?> 
              ">
                <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Informasi</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/tantang-kami' ?>">Tantang Kami</a>                 
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/lokasi' ?>">Lokasi</a>
                </ul>
							</li>
              
              
              
              
              
              <!-- <li class="nav-item"><a class="nav-link" href="pricing.html">Tentang Kami</a> -->
              <!-- <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Pages</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="blog.html">Single Blog</a>                 
                  <li class="nav-item"><a class="nav-link" href="blog-details.html">Blog Details</a>                 
                </ul>
							</li> -->
              <?php if(!$role_log): ?>
              <li class="nav-item <?php echo ($title == 'Pendaftaran') ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url().'/pendaftaran' ?>">Pendaftaran</a></li>
              <?php endif; ?>

              <?php if($konfirmasi == '2'): ?>
              <li class="nav-item <?php echo ($title == 'Konfirmasi') ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url().'/konfirmasi' ?>">Konfirmasi</a></li>  
              <?php endif; ?>
              

            </ul>

            <div class="nav-right text-center text-lg-right py-4 py-lg-0">

              <?php if(!$role_log): ?>
              <a class="button button-outline button-small" href="<?php echo base_url().'/login' ?>">Login</a>
          
              <?php endif; ?>

            </div>
            <?php if($role_log): ?>
              <div class="pr-5">
            <ul class="nav navbar-nav">
              
                <li class="nav-item submenu dropdown
                
                  <?php 
                      if($title == 'Profil'){
                        echo 'active';
                      }elseif($title == 'Keranjang'){
                        echo 'active';
                      }
                    
                    ?> 
                  
                  ">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                      aria-expanded="false"><img alt="image" src="<?php echo base_url('admin/assets/profile').'/'. $user['gambar']; ?>" style="height: 45px; width: 45px;" class="rounded-circle mr-1"></a>
                    
                    <ul class="dropdown-menu">
                      <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/profil'?>"><i class="ti-user"></i> <?php echo $user['nama']; ?></a>
                      <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'/keranjang'?>"><i class="ti-shopping-cart"></i> Keranjang</a>                                  
                      <li class="nav-item"><a class="nav-link" href="javascript:void(0)" id="logout-button"><i class="ti-power-off"></i> Keluar</a>                 
                    </ul>
                </li>
                
            </ul>
            </div>
            <?php endif; ?>
            
          </div> 
        </div>
      </nav>
    </div>
    
  </header>

   <!-- Modal -->
<div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="judbuk" class="modal-header">
        <h5 class="modal-title text-light" id="judulBukuHapus"></h5>
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
                  <i class="ti-power-off"></i>
                  </div>
                  <h2>Yakin ingin keluar?</h2>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">
        
        <a href="<?php echo base_url().'/logout' ?>" class="btn btn-block btn-danger"><h6>Ya!</h6></a>
        
      </div>

    </div>
  </div>
</div>