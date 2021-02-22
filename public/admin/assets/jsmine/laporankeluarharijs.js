$('#print').click(function () {


	let printContents, popupWin;
        printContents = document.getElementById('area-1').innerHTML;
		popupWin = window.open('', '_blank', 'height=500, width=500');
        popupWin.document.open();
        popupWin.document.write(`
          <html>
            <head>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            </head>
			<style>
			
            </style>
        <body onload="window.print();">${printContents}</body>
          </html>`
        );
        popupWin.document.close();

 
	// var divContents = document.getElementById("area-1").innerHTML; 
	// var a = window.open('', '', 'height=500, width=500'); 
	// a.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"><html>'); 
	// a.document.write('<body >');
	// a.document.write(divContents); 
	// a.document.write('</body></html>'); 
	// a.document.close(); 
	// a.print(); 
});





$(document).ready(function () {

	var groupColumn = 0;
    var table = $('#kelhar').DataTable({
		"searching": false,
		"paging": false,
		"bInfo": false,
		//"ordering": false,
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        "order": [[ groupColumn, 'asc' ]],

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(),
               data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
               return typeof i === 'string' ?
                  i.replace(/[\,]/g, '') * 1 :
                  typeof i === 'number' ?
                  i : 0;
            };
            // Total over all pages
            total = api
               .column(4)
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);
   
            // Total over this page
            pageTotal = api
               .column(4, {
                  page: 'current'
               })
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);


               total1 = api
               .column(5)
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);
   
            // Total over this page
            pageTotal1 = api
               .column(5, {
                  page: 'current'
               })
               .data()
               .reduce(function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0);

            // Update footer
            $(api.column(4).footer()).html(
               '' + pageTotal + ''
            );

            $(api.column(5).footer()).html(
                '' + pageTotal1 + ''
             );
         },
        // "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group text-right"><td colspan="6"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );




    /////////////////////////

	var groupColumn1 = 0;
    var table = $('#suphar').DataTable({
        //"searching": false,
		"paging": false,
		"bInfo": false,
		//"ordering": false,
        "columnDefs": [
            { "visible": false, "targets": groupColumn1 }
        ],
        "order": [[ groupColumn1, 'asc' ]],

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(),
               data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
               return typeof i === 'string' ?
                  i.replace(/[\,]/g, '') * 1 :
                  typeof i === 'number' ?
                  i : 0;
            };
            // Total over all pages
            total = api
            .column(3)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotal = api
            .column(3, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         totala = api
            .column(4)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotala = api
            .column(4, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

            totalb = api
            .column(5)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotalb = api
            .column(5, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);


            total1 = api
            .column(6)
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Total over this page
         pageTotal1 = api
            .column(6, {
               page: 'current'
            })
            .data()
            .reduce(function (a, b) {
               return intVal(a) + intVal(b);
            }, 0);

         // Update footer
         $(api.column(3).footer()).html(
            '' + pageTotal + ''
         );

         $(api.column(4).footer()).html(
            '' + pageTotala + ''
         );

         $(api.column(5).footer()).html(
            '' + pageTotalb + ''
         );

         $(api.column(6).footer()).html(
             '' + pageTotal1 + ''
          );
         },



        // "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn1, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group text-center"><td colspan="6"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );

    $('#cari_tanggal').datepicker(
		{
		format: "yyyy-mm-dd"
		// startView: "year",
		// minViewMode: "months"
	}
	);


	// var bulan = $('#cari_bulan').val('');
	// var tahun = $('#cari_tahun').val('');

	// if()
   

});



