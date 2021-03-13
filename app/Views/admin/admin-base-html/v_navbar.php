<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?php echo base_url('admin/assets/profile').'/'. $user['gambar']; ?>" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block namo"><?php echo $user['nama'];  ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="<?php echo base_url().'/akun/profil' ?>" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profil
              </a>
              
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item has-icon text-danger" id="tombol-logout"> <i class="fas fa-sign-out-alt"></i> Keluar</a>
            </div>
          </li>
        </ul>
      </nav>

      <div class="modal fade" id="modal-logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="text-center text-danger"><i class="fa fa-power-off mr-3"></i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="empty-state" data-height="100">
                  <div class="empty-state-icon bg-danger">
                    <i class="fas fa-question"></i>
                  </div>
                  <h2>Yakin ingin keluar?</h2>
            
              </div>
            </div>
            <div class="modal-footer">
              <form action="<?php echo base_url().'/logout' ?>" class="btn btn-block" method="post" accept-charset="utf-8">
              <?php echo csrf_field(); ?>
              <button type="submit" class="btn btn-danger">Ya!</button>
              </form>  
            </div>
          </div>
        </div>
      </div>

      