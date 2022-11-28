
var proof_table = $('#proofsheet-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    order: [[ 0, "desc" ]],
    buttons: [
        {
            extend: 'pdf',
            title: 'Proofsheet/s List',
            customize: function (doc) {
                console.log(doc);
                doc.content[2].table.widths = 
                    Array(doc.content[2].table.body[0].length + 1).join('*').split('');
            },
            exportOptions: {
                columns: 'th:not(:last-child)'
            },
            message: function(){
                var startdate = $('#search-proofsheet-form input[name = s_date]').val(); 
                var enddate = $('#search-proofsheet-form input[name = e_date]').val();
                return "From: "+startdate+"\n"+"To: "+enddate;
            }
        }
    ]
});

var proof_details_table = $('#proofsheet-details-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    order: [[ 1, "asc" ]],
    buttons: [
        {
            extend: 'pdf',
            title: 'Proofsheet Summary',
            customize: function (doc) {
                doc.content[1].table.widths = 
                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
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
    dom: 'Bfrtip',
    responsive: true,
    order: [[ 0, "desc" ]],
    buttons: [
        {
            extend: 'pdf',
            title: 'Proofsheet/s List',
            customize: function (doc) {
                doc.content[1].table.widths = 
                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#search-proofsheet-form input[name = s_date]').val(); 
                var enddate = $('#search-proofsheet-form input[name = e_date]').val();
                return "From: "+startdate+"\n"+"To: "+enddate;
            }
        }
    ]
});


var add_patient_table = $('#all-patient-table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    order: [[ 1, "desc" ]],
    buttons: [
        {
            extend: 'pdf',
            title: 'Patients/s List',
            customize: function (doc) {
                doc.content[1].table.widths = 
                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            },
            message: function(){
                var startdate = $('#search-patients-form input[name = s_date]').val(); 
                var enddate = $('#search-patients-form input[name = e_date]').val();
                return "From: "+startdate+"\n"+"To: "+enddate;
            }
        }
    ]
});
