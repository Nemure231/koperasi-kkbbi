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
            <li class="menu-header"><?php echo $m['menu']; ?></li>
            <?php  
             
              $menuId = $m['id_menu'];
              $escape = sub_menu_conex($menuId);
            ?>
            
            <?php foreach ($escape as $sub): ?>
			      <?php if($title == $sub['judul']):  ?>
          
            <li class="active">
            <?php else  : ?>
            <li>
            <?php endif; ?>
            
            <a class="nav-link" href="<?php echo base_url($sub['url']); ?>"><i class="<?php echo $sub['icon']; ?>"></i> <span><?php echo $sub['judul']; ?></span></a>
            
            </li>
          
            <?php endforeach; ?>

            <?php endforeach; ?>
            
  
          </ul>     
        </aside>
      </div>
