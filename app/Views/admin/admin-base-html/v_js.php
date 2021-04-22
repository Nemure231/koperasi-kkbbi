<!-- General JS Scripts -->
<script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/jquery.min.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/popper.js'; ?>"></script>
  <!-- <script type="application/javascript" src="<//?php echo base_url().'/admin/assets/modules/tooltip.js'; ?>"></script> -->
  
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/bootstrap/js/bootstrap.min.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/nicescroll/jquery.nicescroll.min.js'; ?>"></script>
  <!-- <script type="application/javascript" src="<//?php echo base_url().'/admin/assets/modules/moment.min.js'; ?>"></script> -->
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/stisla.js'; ?>"></script>
  
  <!-- JS Libraies -->
 
  <!-- Template JS File -->
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/scripts.js'; ?>"></script>
  <script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/custom.js'; ?>"></script>

  <script>
    // $("#modal-2").fireModal({
    //   body: `<form
    //         <a href="<//?php echo base_url().'/logout' ?>" class="btn btn-block btn-danger">Ya!</a>
            
    //         `,
    //   title: `<h5 class="text-center text-danger"><i class="fa fa-power-off mr-3"></i> Keluar?</h5>`, 
    //   center: true});
    

    $('#tombol-logout').click(function () {
      //$('#btn-simpan').val("tambah-menu");
      //var ded = 'dude';
      //$('#judulBuku').html("Tambah Buku");
      $('#modal-logout').modal('show');


   });
    var nama = $('.namo').text();
    $('.nama_Profil_sidebar').text(nama);
  
  </script>