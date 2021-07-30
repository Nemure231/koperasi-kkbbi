

 function previewImg() {
    const sampul = document.querySelector('#bukti');
    const sampulLabel = document.querySelector('.bukti-label');
    const imgPrev = document.querySelector('.bukti-img');
    const imgPrevHref = document.querySelector('.bukti-href');
 
    sampulLabel.textContent = sampul.files[0].name;
 
    const fileSampul = new FileReader();
 
    fileSampul.readAsDataURL(sampul.files[0]);
 
    fileSampul.onload = function (e) {
       imgPrev.src = e.target.result;
       imgPrevHref.href = e.target.result;
    }
 }

$(document).ready(function () {
    $('#tombol-rekening').click(function () {
        $('#modal-rekening').modal('show');
     });

    previewImg();

});


