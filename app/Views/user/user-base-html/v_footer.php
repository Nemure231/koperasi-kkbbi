<footer class="footer-area section-gap">
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-sm-6 mb-4 mb-xl-0 single-footer-widget">
				<h4>Tentang Kami</h4>
				<p>Koperasi Konsumen Berkah Bersama Indonesia (KKBBI) merupakan sebuah perserikatan yang bergerak dalam jual beli sembako atau kebutuhan pokok sehari-hari.</p>
				<a class="navbar-brand logo_h d-none d-xl-block" href="<?php echo base_url().'/' ?>"><img style="width: 100px; height: 100px; object-fit: cover;"  src="<?php echo base_url('admin/assets/toko').'/'. $toko['logo_toko'] ?>" alt=""></a>
			</div>
			<div class="col-xl-3 col-sm-6 mb-4 mb-xl-0 single-footer-widget">
				<h4>Contact Info</h4>
				<ul>
					<li>Alamat	:<?php echo $toko['alamat_toko']; ?></li>
					<li>Telepon	:<?php echo $toko['telepon_toko']; ?></li>
					<li>Surel	:<?php echo $toko['email_toko']; ?></li>
				</ul>
			</div>
		</div>
		<div class="footer-bottom row align-items-center text-center text-lg-left">
			<p class="footer-text m-0 col-lg-8 col-md-12">
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				Copyright &copy;<script>
					document.write(new Date().getFullYear());
				</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i>
				by <a href="https://colorlib.com" target="_blank">Colorlib</a>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			</p>
			<div class="col-lg-4 col-md-12 text-center text-lg-right footer-social">
				<!-- <a href="#"><i class="ti-facebook"></i></a>
				<a href="#"><i class="ti-twitter-alt"></i></a>
				<a href="#"><i class="ti-dribbble"></i></a>
				<a href="#"><i class="ti-linkedin"></i></a> -->
			</div>
		</div>
	</div>
</footer>