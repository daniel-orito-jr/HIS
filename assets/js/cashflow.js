
$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});


var proof_table = $('#proofsheet-table').DataTable({
    dom: 'frtip',
    responsive: true
});

var proof_details_table = $('#proofsheet-details-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    paging: false,
//    order: [[ 1, "asc" ]],
    buttons: [
        {
            extend: 'pdf',
            title: 'Proofsheet Summary',
            customize: function (doc) {
                console.log(doc);
//                doc.content[1].table.widths = 
//                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#search-proofsheet-form input[name = s_date]').val(); 
                var enddate = $('#search-proofsheet-form input[name = e_date]').val();
                return "From: "+startdate+"\n"+"To: "+enddate;
            }
        }
    ]
});




var date_proof_table = $('#date-proofsheet-table').DataTable({
    dom: 'frtip',
    responsive: true
});




$(".report-btn").hide();

