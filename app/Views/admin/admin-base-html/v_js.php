<!-- General JS Scripts -->
<script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/jquery.min.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/popper.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/tooltip.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/bootstrap/js/bootstrap.min.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/nicescroll/jquery.nicescroll.min.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/moment.min.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/stisla.js'; ?>"></script>
  
  <!-- JS Libraies -->
  
  <!-- Template JS File -->
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/scripts.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/custom.js'; ?>"></script>

  <script>
    
    $('#modal-2').click(function () {
      $('#modal-logout').modal('show');
      // $('#role_id').select2({dropdownParent: $('#modalKaryawan')});
   });
    
    var nama = $('.namo').text();
    $('.nama_Profil_sidebar').text(nama);
  </script>