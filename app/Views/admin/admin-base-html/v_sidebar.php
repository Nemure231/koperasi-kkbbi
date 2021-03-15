<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?php echo base_url().'/dashboard' ?>">KKBBI</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo base_url().'/dashboard' ?>">KKBBI</a>
          </div>
          <ul class="sidebar-menu" id="tambah">


            <?php foreach ($menu as $m): ?>
              <li class="menu-header"><?php echo $m['nama_menu']; ?></li>
              <?php  
              
                $menuId = $m['id_menu'];
                $escape = main_menu_conex($menuId);
              ?>
            
              <?php foreach ($escape as $sub): ?>
              <?php $mainId = $sub['id_menu_utama']?>

                <?php if($nama_menu_utama == $sub['nama_menu_utama']):  ?>
              
                <li class="active dropdown">
                    <?php else  : ?>
                <li class="dropdown">

                  <?php endif; ?>

                  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="<?php echo $sub['ikon_menu_utama']; ?>"></i> <span class="nama_<?php echo $sub['nama_menu_utama']; ?>_sidebar"><?php echo $sub['nama_menu_utama']; ?></span></a>
                  <ul class="dropdown-menu">


                  <?php $escape2 = sub_menu_conex($menuId, $mainId);?>

                  <?php foreach ($escape2 as $sub2): ?>
                    <?php if($title == $sub2['judul']):  ?>
              
                    <li class="active">
                        <?php else  : ?>
                    <li>

                    <?php endif; ?>
                    
                    
                    <a class="nav-link" href="<?php echo base_url($sub2['url']);  ?>"><i class="<?php echo $sub2['icon']; ?>"></i><?php echo $sub2['judul']; ?></a></li>
                  <?php endforeach; ?>


                  </ul>
                </li>
              
                <!-- <a class="nav-link" href="<//?php echo base_url($sub/['url']); ?>"><i class="<//?php echo $sub/['icon']; ?>"></i> <span><//?php echo $sub['judul']; ?></span></a>
              
                </li> -->
          
              <?php endforeach; ?>

            <?php endforeach; ?>
            
  
          </ul>     
        </aside>
      </div>
