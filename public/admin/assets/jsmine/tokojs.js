function previewImg() {
    const sampul = document.querySelector('#logo_toko');
    const sampulLabel = document.querySelector('.custom-file-label');
    const imgPrev = document.querySelector('.img-prev');
 
    sampulLabel.textContent = sampul.files[0].name;
 
    const fileSampul = new FileReader();
 
    fileSampul.readAsDataURL(sampul.files[0]);
 
    fileSampul.onload = function (e) {
       imgPrev.src = e.target.result;
    }
 }

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



$(document).ready(function () {
    if ($("#buka_toko").length) {
        $("#buka_toko").timepicker({
            defaultTime: 'value',
            minuteStep: 1,
            showMeridian: false,
            //template: 'dropdown',
            icons: {
                up: 'fas fa-angle-up',
                down: 'fas fa-angle-down'
            }
        });
    }


    if ($("#tutup_toko").length) {
        $("#tutup_toko").timepicker({
            defaultTime: 'value',
            minuteStep: 1,
            showMeridian: false,
            //template: 'dropdown',
            icons: {
                up: 'fas fa-angle-up',
                down: 'fas fa-angle-down'
            }
        });
    }


});


