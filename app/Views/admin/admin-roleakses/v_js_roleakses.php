
<script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/datatables/datatables.min.js'; ?>"></script>
<script type="application/javascript" src="<?php echo base_url().'/admin/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js'; ?>"></script>
<script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/sweet-alert.js'; ?>"></script>
<script type="application/javascript" src="<?php echo base_url().'/admin/assets/jsmine/roleaksesjs.js'; ?>"></script>


<script type="application/javascript">
	$('.custom-switch-input').on('click', function () {

		const menuId = $(this).data('menu');
		const roleId = $(this).data('role');

		$.ajax({
			url: "<?php echo base_url().'/pengaturan/role/akses/ubah'; ?>",
			type: 'post',
			headers: {
               'X-Requested-With': 'XMLHttpRequest'
            },
			data: {
				menuId: menuId,
				roleId: roleId
			},
			success: function () {
				//Swal.fire('Berhasil', 'Akses berhasil diubah!', 'success');
				document.location.href = "<?php echo base_url().'/pengaturan/role/akses/'; ?>" + roleId;
			}

		});

	});

</script>

<script type="application/javascript" src="<?php echo base_url().'/admin/assets/jsmine/roleaksesjs.js'; ?>"></script>



</body>

</html>

