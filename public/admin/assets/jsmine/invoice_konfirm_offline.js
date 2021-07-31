const sukses = $('#invoice-sukses').data('flashdata');
if (sukses) {

   iziToast.success({
      title: 'Berhasil!',
      message: '' + sukses,
      position: 'topRight',
      toastOnce: true
   });
}



$(document).ready(function () {

	// $('#tombolhapusinvoice').click(function () {

	// 	$('#modalhapusinvoice').modal('show');
	 
	//  });

    $(function () {
		$('#jumlah').on("input keyup change", function () {
			var total = $('#total2').val();
			var jumuang = $('#jumlah').val();
			var hsl = jumuang.replace(/[^\d]/g, "");
			//$('#jumlah_uang2').val(hsl);
			$('#kembali').val(hsl - total);

			var kembalian = $('#kembali').val();

			if(kembalian < 0){
				$('#notif-kembalian').text('Kembalian kurang ' + (total - hsl));
			}else{
				$('#notif-kembalian').text('');
			}
		})

	});
    
});
