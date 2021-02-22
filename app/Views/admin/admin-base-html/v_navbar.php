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
              <a href="<?php echo base_url().'/pengguna' ?>" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profil
              </a>
              
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item has-icon text-danger" id="modal-2"> <i class="fas fa-sign-out-alt"></i> Keluar</a>
            </div>
          </li>
        </ul>
      </nav>

      