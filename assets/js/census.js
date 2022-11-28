//----------------------------------------------------------------datetimepickler
$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});

//$(".date").datetimepicker("setDate",MY_DATE);
//alert(MY_DATE);
//$('.date').datetimepicker({
//   beforeShow: function(){$('input').blur();}
//});
//
var phic_table = $('#phic-table').DataTable({
    dom: 'rtip',
    responsive: true,
    "createdRow": function ( row, data, index ) {
        $('td', row).eq(2).css({'font-weight' : 'Bold','background-color':'cyan'});
    }   
});

var phic_table = $('#phic-dis-table').DataTable({
    dom: 'rtip',
    responsive: true,
    "createdRow": function ( row, data, index ) {
        $('td', row).eq(2).css({'font-weight' : 'Bold','background-color':'cyan'});
    }   
});
//
//
var dis_adm_table = $('#dis-adm-table').DataTable({
    dom: 'frtip',
    responsive: true
});

var opd_table = $('#opd-table').DataTable({
    dom: 'frtip',
    responsive: true
});
//
//
var doctor_table = $('#doctor-table').DataTable({
    dom: 'frtip',
    responsive: true,
    createdRow: function ( row, data, index ) {
                    $('td', row).eq(3).css({'font-weight' : 'Bold','background-color':'cyan'});
                }
});
//
//
var admit_table = $('#admitted-table').DataTable({
    dom: 'frtip',
    responsive: true
//    columnDefs: [
//        { "width": "25%", "targets": 0 }
//      ]
});

var discharge_table = $('#discharged-table').DataTable({
    dom: 'frtip',
    responsive: true
    
});



var px_classification_table = $('#px-classification-table').DataTable({
    dom: 'frtip',
    responsive: true
});

//------disposition

var px_disposition_table = $('#px-disposition-table').DataTable({
    dom: 'frtip',
    responsive: true
});

//end disposition

var ros1_table = $('#ros1-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
       {
            extend: 'pdf',
            title: 'Room Occupational Statistics',
            customize: function (doc) {
                doc.content[2].table.widths = 
                    Array(doc.content[2].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#day1-tab').text(); 
                return "Date: "+startdate;
            }
        }
    ]
});

var ros2_table = $('#ros2-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
       {
            extend: 'pdf',
            title: 'Room Occupational Statistics',
            customize: function (doc) {
                doc.content[2].table.widths = 
                    Array(doc.content[2].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#day2-tab').text(); 
                return "Date: "+startdate;
            }
        }
    ]
});
var ros3_table = $('#ros3-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
       {
            extend: 'pdf',
            title: 'Room Occupational Statistics',
            customize: function (doc) {
                doc.content[2].table.widths = 
                    Array(doc.content[2].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#day3-tab').text(); 
                return "Date: "+startdate;
            }
        }
    ]
});
var ros4_table = $('#ros4-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
       {
            extend: 'pdf',
            title: 'Room Occupational Statistics',
            customize: function (doc) {
                doc.content[2].table.widths = 
                    Array(doc.content[2].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#day4-tab').text(); 
                return "Date: "+startdate;
            }
        }
    ]
});
var ros5_table = $('#ros5-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
       {
            extend: 'pdf',
            title: 'Room Occupational Statistics',
            customize: function (doc) {
                doc.content[2].table.widths = 
                    Array(doc.content[2].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#day5-tab').text(); 
                return "Date: "+startdate;
            }
        }
    ]
});

$(".report-btn").hide();

//-----------------------------------------------------------------------------------------------------------------------

