const flashData = $('.flash-data').data('flashdata');
var nam = $('.namo').text();


if (flashData) {

  Swal.fire({
    title: 'Selamat datang kembali, ' + nam,
    showClass: {
      popup: 'animate__animated animate__fadeInDown animate__fast'
    },
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp animate__fast'
    },
    icon: 'info',
    text: ' ' + flashData,

    focusConfirm: false,
    confirmButtonText: '<i class="fas fa-laugh-wink"</i> Ya!',
    confirmButtonAriaLabel: 'Terima kasih',
  });
}

// $(document).ready(function () {

//   $('#myTab3 a').on('click', function (e) {
//     e.preventDefault()
//     $(this).tab('show');
  
//  });

//   // $('#myTab3 li:first-child a').tab('show');
//   // $('#myTab3 li:last-child a').tab('show');
//   // $('#myTab3 li:nth-child(3) a').tab('show');


// });









// var ctx = document.getElementById("chartMasukBulan").getContext('2d');
// var myChart2 = new Chart(ctx, {
//   type: 'line',
//   data: {
//     labels: ["Sundap", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
//     datasets: [{
//       label: 'Statistics',
//       data: [460, 458, 330, 502, 430, 610, 488],
//       borderWidth: 2,
//       backgroundColor: 'rgba(63,82,227,.8)',
//       borderWidth: 0,
//       borderColor: 'transparent',
//       pointBorderWidth: 0,
//       pointRadius: 3.5,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
//     }, {
//       label: 'Statistics',
//       data: [390, 600, 390, 280, 600, 430, 638],
//       borderWidth: 2,
//       backgroundColor: 'rgba(254,86,83,.7)',
//       borderWidth: 0,
//       borderColor: 'transparent',
//       pointBorderWidth: 0,
//       pointRadius: 3.5,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
//     }]
//   },
//   options: {
//     legend: {
//       display: false
//     },
//     scales: {
//       yAxes: [{
//         gridLines: {
//           drawBorder: false,
//           color: '#f2f2f2',
//         },
//         ticks: {
//           beginAtZero: true,
//           stepSize: 200,
//           callback: function (value, index, values) {
//             return '$' + value;
//           }
//         }
//       }],
//       xAxes: [{
//         gridLines: {
//           display: false,
//           tickMarkLength: 15,
//         }
//       }]
//     },
//   }
// });

// var ctx = document.getElementById("chartMasukTahun").getContext('2d');
// var myChart3 = new Chart(ctx, {
//   type: 'line',
//   data: {
//     labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
//     datasets: [{
//       label: 'Statistics',
//       data: [460, 458, 330, 502, 430, 610, 488],
//       borderWidth: 2,
//       backgroundColor: 'rgba(63,82,227,.8)',
//       borderWidth: 0,
//       borderColor: 'transparent',
//       pointBorderWidth: 0,
//       pointRadius: 3.5,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
//     }, {
//       label: 'Statistics',
//       data: [390, 600, 390, 280, 600, 430, 638],
//       borderWidth: 2,
//       backgroundColor: 'rgba(254,86,83,.7)',
//       borderWidth: 0,
//       borderColor: 'transparent',
//       pointBorderWidth: 0,
//       pointRadius: 3.5,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
//     }]
//   },
//   options: {
//     legend: {
//       display: false
//     },
//     scales: {
//       yAxes: [{
//         gridLines: {
//           drawBorder: false,
//           color: '#f2f2f2',
//         },
//         ticks: {
//           beginAtZero: true,
//           stepSize: 200,
//           callback: function (value, index, values) {
//             return '$' + value;
//           }
//         }
//       }],
//       xAxes: [{
//         gridLines: {
//           display: false,
//           tickMarkLength: 15,
//         }
//       }]
//     },
//   }
// });