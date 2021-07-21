
<script type="application/javascript" src="<?php echo base_url().'/admin/assets/js/sweet-alert.js'; ?>"></script>

<script type="application/javascript">



$(document).ready(function () {

   const flashData = $('.flash-data').data('flashdata');

if (flashData) {
   Swal.fire({
      title: 'Berhasil',
      hideClass: {
         popup: 'animate__animated animate__fadeOutUp animate__fast'
      },
      text: ' ' + flashData,
      icon: 'success'
   });

}

$('.add_cart').click(function () {

   

      var buku_id = $(this).data("buku_id");
      var qty = $('#qty_buku').val();
      var stok = $(this).data("stok_buku");
    
   
   if (qty == '') {
      Swal.fire({
         title: 'Gagal',
         hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__fast'
         },
         text: 'Kuantitas tidak boleh kosong!',
         icon: 'error'
      });

   }else 
   if (qty >= stok) {
      Swal.fire({
         title: 'Peringatan',
         hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__fast'
         },
         text: 'Jumlah yang dimasukkan melebihi stok!',
         icon: 'warning'
      });

   }
   else if (qty == 0) {
      Swal.fire({
         title: 'Gagal',
         hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__fast'
         },
         text: 'Kuantitas yang dimasukkan tidak boleh nol!',
         icon: 'error'
      });

   } 
   else {
      $.ajax({
         url: '<?php echo base_url().'/tambahkeranjang' ?>',
         //method: "POST",
         //yang sebelah kiri adalah data yang diambil lewat get codeigniter,
         //yang kemuidan di kanannya harus disamakan dengan data yang diambil dari data- jquery
         //bergitulah caranya agar dapat menjaalankan fungsi di controller
         data: {
            k_buku_id: buku_id,
            k_qty: qty
            
         },
         headers:{'X-Requested-With': 'XMLHttpRequest'},
         type: "POST",
         dataType: 'json',
         success: function (res) {
            //Swal.fire('Berhasil', 'Barang berhasil dimasukkan ke keranjang!' + res.data.k_qty, 'success');
           
            //var = st $('#stok_bukuk').text();
            location.reload();
           

            // var menu = '<tr id="keranjang_id_' + data.id_buku + '"><td>' + data.id_buku + '</td><td>' + data.menu + '</td>';

            // menu += '<td><a href="javascript:void(0)" data-id="' + data.id_menu + '" class="btn btn-warning btn-action mr-1 edit-menu"><i class="fas fa-pencil-alt"></i></a> <a href="javascript:void(0)" data-id="' + data.id_menu + '" class="btn btn-danger btn-action hapus-menu"><i class="fas fa-trash"></i></a></td></tr>';


            //$('#modalKeranjang').modal('show');

         }
      });
   }
});


});

</script>

</body>
</html>