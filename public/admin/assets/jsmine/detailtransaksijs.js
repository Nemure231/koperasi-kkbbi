$(document).ready(function () {

    $(function () {
		$('#jumlah').on("input", function () {
			var total = $('#total2').val();
			var jumuang = $('#jumlah').val();
			var hsl = jumuang.replace(/[^\d]/g, "");
			//$('#jumlah_uang2').val(hsl);
			$('#kembali').val(hsl - total);
		})

	});
    
});
