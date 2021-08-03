const flashdata = $('#pesan-pengajuan').data('flashdata');
if (flashdata) {
    iziToast.success({
        title: 'Berhasil!',
        message: ''+ flashdata,
        position: 'topRight',
        
     });
}



function previewImg() {
    const sampul = document.querySelector('#input_gambar');
    const sampulLabel = document.querySelector('.custom-file-label');
    const imgPrev = document.querySelector('.img-prev');
 
    sampulLabel.textContent = sampul.files[0].name;
 
    const fileSampul = new FileReader();
 
    fileSampul.readAsDataURL(sampul.files[0]);
 
    fileSampul.onload = function (e) {
       imgPrev.src = e.target.result;
    }
 }


$(document).ready(function () {

    $('#nama').select2({tags: true});
    $('#satuan_id').select2({tags: true});
    $('#merek_id').select2({tags: true});
    $('#kategori_id').select2({tags: true});

    $('#satuan_id option:not(:selected)').prop('disabled', false);
    $('#merek_id option:not(:selected)').prop('disabled', false);
    $('#kategori_id option:not(:selected)').prop('disabled', false);


    $('#nama').on("change", function () {

        var data = $(this).select2('data');
        var data_text = data[0].text;

        if($.isNumeric(data_text) == false){
            $('#satuan_id').select2({tags: true});
    $('#merek_id').select2({tags: true});
    $('#kategori_id').select2({tags: true});
        $('#satuan_id').val('').select2({disabled: false});
        $('#merek_id').val('').select2({disabled: false});
        $('#kategori_id').val('').select2({disabled: false});
        $('#harga_pokok').val('').prop('readonly', false);
        $('#harga_konsumen').val('').prop('readonly', false);
        $('#harga_anggota').val('').prop('readonly', false);
        $('#deskripsi').val('').prop('readonly', false);
        $('#input_gambar').prop('disabled', false);
        // $('#input_gambar').val('');
        $('#input_gambar').text('');
        $('#stok_sebelum').val('');
        $('#gambar').attr("src", "admin/assets/barang/default.jpg");
        // if ($('#qode_barang').val() == '') {
        //    iziToast.error({
        //       title: 'Gagal!',
        //       message: 'Kode barang tidak boleh kosong!',
        //       position: 'topRight'
        //    });
        // } else {
           var id_barang = $(this).val();
           var csrfName = $('#csrf_barang').attr('name'); // CSRF Token name
           var csrfHash = $('#csrf_barang').val(); // CSRF hash
     
           $.ajax({
              url: 'pengajuan/ambil_barang',
              data: {
                 [csrfName]: csrfHash,
                 nama: id_barang
     
              },
              headers: {
                 'X-Requested-With': 'XMLHttpRequest'
              },
              method: "POST",
              dataType: 'json',
              success: function (res) {
     
                 if (res.data) {
                    // $('#satuan_id').select2({tags: true});
                    // $('#merek_id').select2({tags: true});
                    // $('#kategori_id').select2({tags: true});
                    // $('#satuan_id').val(res.data.satuan_id).select2('destroy');
                    // $('#merek_id').val(res.data.merek_id).select2('destroy');
                    // $('#kategori_id').val(res.data.kategori_id).select2('destroy');

                    $('#satuan_id').val(res.data.satuan_id).select2('destroy');
                    $('#merek_id').val(res.data.merek_id).select2('destroy');
                    $('#kategori_id').val(res.data.kategori_id).select2('destroy');

                    $('#harga_pokok').val(res.data.harga_pokok).prop('readonly', true);
                    $('#harga_konsumen').val(res.data.harga_konsumen).prop('readonly', true);
                    $('#harga_anggota').val(res.data.harga_anggota).prop('readonly', true);
                    $('#stok_sebelum').val(res.data.stok);
                    $('#input_gambar').prop('disabled', true);
                    $('.custom-file-label').text(res.data.gambar);
                    // document.getElementById('#gambar').
                    $('#deskripsi').val(res.data.deskripsi);
                    $('#gambar').attr("src", "admin/assets/barang/" + res.data.gambar);
                    $('#csrf_barang').val(res.csrf_hash);
                    $('#csrf_pengajuan').val(res.csrf_hash);
                    // $('#satuan_id').select2({tags: true});
                    // $('#merek_id').select2({tags: true});
                    // $('#kategori_id').select2({tags: true});
                    $('#satuan_id').attr('readonly', 'readonly');
                    $('#merek_id').attr('readonly', 'readonly');
                    $('#kategori_id').attr('readonly', 'readonly');
                    $('#satuan_id option:not(:selected)').prop('disabled', 'disabled');
                    $('#merek_id option:not(:selected)').prop('disabled', 'disabled');
                    $('#kategori_id option:not(:selected)').prop('disabled', 'disabled');
    
                    iziToast.success({
                       title: 'Berhasil!',
                       message: 'Barang berhasil ditemukan!',
                       position: 'topRight',
                       // toastOnce: true
                       
                    });
                 } else {
                    $('#satuan_id').select2({tags: true});
                    $('#merek_id').select2({tags: true});
                    $('#kategori_id').select2({tags: true});
                    $('#csrf_barang').val(res.csrf_hash);
                    $('#csrf_pengajuan').val(res.csrf_hash);
                    // $('#satuan_id').val('').select2({disabled: false});
                    // $('#merek_id').val('').select2({disabled: false});
                    // $('#kategori_id').val('').select2({disabled: false});
                    $('#harga_pokok').val('').prop('readonly', false);
                    $('#harga_konsumen').val('').prop('readonly', false);
                    $('#harga_anggota').val('').prop('readonly', false);
                    $('#deskripsi').val('').prop('readonly', false);
                    $('#stok_sebelum').val('');
                    $('#input_gambar').text('');
                    $('#gambar').attr("src", "admin/assets/barang/default.jpg");
                    $('#input_gambar').prop('disabled', false);
                    
                    $('#satuan_id option:not(:selected)').prop('disabled', false);
                    $('#merek_id option:not(:selected)').prop('disabled', false);
                    $('#kategori_id option:not(:selected)').prop('disabled', false);
                
                 }
     
              }
           });
           
  
        }else{
            $('#satuan_id').select2({tags: true});
    $('#merek_id').select2({tags: true});
    $('#kategori_id').select2({tags: true});

        // $('#satuan_id').val('').select2({disabled: false});
        // $('#merek_id').val('').select2({disabled: false});
        // $('#kategori_id').val('').select2({disabled: false});
        $('#harga_pokok').val('').prop('readonly', false);
        $('#harga_konsumen').val('').prop('readonly', false);
        $('#harga_anggota').val('').prop('readonly', false);
        $('#deskripsi').val('').prop('readonly', false);
        $('#stok_sebelum').val('');
        $('#input_gambar').text('');
        $('#input_gambar').prop('disabled', false);
        $('#gambar').attr("src", "admin/assets/barang/default.jpg");
        // $('#input_gambar').val('');

        $('#satuan_id option:not(:selected)').prop('disabled', false);
        $('#merek_id option:not(:selected)').prop('disabled', false);
        $('#kategori_id option:not(:selected)').prop('disabled', false);

        }
  
     });


   

});