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


         <!-- Modal -->
<div class="modal fade" id="modal-logout" tabindex="-1" role="dialog" aria-hidden="true">
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
                  <i class="fa fa-power-off"></i>
                  </div>
                  <h2>Yakin ingin keluar?</h2>
                </div>
              </div>
            </div>
          </div><!--  card end -->
        </div>

      </div>
      <div class="modal-footer">
           <form method="POST" action="<?php echo base_url().'/logout' ?>" accept-charset="utf-8">
           <?php echo csrf_field(); ?>

        <!-- <a href="<//?php echo base_url().'/logout' ?>" class="btn btn-block btn-danger"><h6>Ya!</h6></a> -->
        ,<button type="submit" class="btn btn-block btn-danger">Ya!</button>
          </form>
        
      </div>

    </div>
  </div>
</div>

      