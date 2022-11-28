$(function () {

   eclaimsummaryreport();
});


$(".report-btn").hide();
var table = $('#in-process-table').DataTable({
    dom: 'frtip',
    responsive: true
});

$('.date').datetimepicker({
    format: 'YYYY-MM'
});

function eclaimsummaryreport()
{

    $.ajax({
        type: 'POST',
        url: BASE_URL + "user/eclaimsummaryreport",
        data: {start_date: $('#search-eclaimsummaryreport-form input[name=start_date]').val()},
        dataType: 'json'
    }).done(function (data1) {
        console.log(data1);
        if (data1.status) {
            console.log('success');
            
            $('#eclaims-summary-report-table').dataTable().fnDestroy();
            var eclaims_summary_report_table =  $('#eclaims-summary-report-table').DataTable( {
        "order": false,
         "paging": false
    } );
            eclaims_summary_report_table.clear();
            var allsent = data1.all_eclaimssummary_report['allsent'];
            var alldischarged = data1.all_eclaimssummary_report['alldischarged'];
            var sentpercentage = '0.00%', dischargedpercentage = "0.00%";
            var allsentpercentage = '0.00%', alldischargedpercentage = "0.00%";
            if (data1.eclaimsummaryreport.length > 0)
            {
                for (var i = 0; i < data1.eclaimsummaryreport.length; i++) {
//                    alert(data1.eclaimsummaryreport[i]["pStatus"]);
                 if(allsent !== '0')
                 {
                     sentpercentage = parseFloat((data1.eclaimsummaryreport[i]["sent"]/allsent)*100).toFixed(2)+"%";
                     allsentpercentage = parseFloat((allsent/allsent)*100).toFixed(2)+"%";
                 }
                 
                 if(alldischarged !== '0')
                 {
                     dischargedpercentage = parseFloat((data1.eclaimsummaryreport[i]["discharged"]/alldischarged)*100).toFixed(2)+"%";
                     alldischargedpercentage = parseFloat((alldischarged/alldischarged)*100).toFixed(2)+"%";
                 }
                    eclaims_summary_report_table.row.add(
                    [
                        "<b>"+data1.eclaimsummaryreport[i]["pStatus"]+"</b>",
                        data1.eclaimsummaryreport[i]["sent"],
                        sentpercentage,
                        data1.eclaimsummaryreport[i]["discharged"],
                        dischargedpercentage,
                    ]).draw(false);
                    
                }
                eclaims_summary_report_table.row.add(
                    [
                        "<b>Total Claims Submitted</b>",
                        "<b>"+allsent+"</b>",
                        "<b>"+allsentpercentage+"</b>",
                        "<b>"+alldischarged+"</b>",
                        "<b>"+alldischargedpercentage+"</b>",
                    ]).draw(false);
            } else
            {
                $('#eclaims-summary-report-table').dataTable().fnDestroy();
                var eclaims_summary_report_table = $('#eclaims-summary-report-table').DataTable();
                eclaims_summary_report_table.clear();
            }
        } else
        {
            console.log('fail');
        }
    });

}

var inprocessphic = {
    get_in_process: function () {

    },

    search_phic_in_process: function () {
        var s_date = $('#search-inprocess-form input[name = start_date]');
        var error = 0;

        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        } else {
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }

        if (error === 0) {
            load_transmittal_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        }
    },

    generate_phicinprocess_report: function ()
    {
        start_date = $('#search-inprocess-form input[name=start_date]').val();

        $("#phic-in-process-form input[name=s_date]").val(start_date);
        $("#phic-in-process-form").submit();
    }


};

function load_transmittal_script(scriptUrl)
{
    $.getScript(scriptUrl)
            .done(function (script, textStatus) {
                inprocessphic.get_in_process();

            })
            .fail(function (jqxhr, settings, exception) {
                console.log("fail to load script");
            });
}

$('#transmittal-table').on('dblclick', 'td', function () {
//    alert("asdfasdf");
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#transmittal-table').dataTable().fnGetData(current_row);
////    row.css("background","#FF5722");
//
//    $("#dis-purchase-form input[name=control]").val(data[5]);
//    $("#disPurchase").modal("show");

    console.log(data);
});


$('#in-process-table').on('click', 'td', function () {


    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#in-process-table').dataTable().fnGetData(current_row);
    var datexx = $('#search-inprocess-form input[name=start_date]').val();
    show_inprocess(data, datexx);
    $("#phicinprocess_modal").modal("show");


});

function show_inprocess(data, datexx)
{


    var monthly = data[0];
    $('#month').html(monthly);

    var amt = data[2];
    $('#totalamount').html(amt);


    $('#phic-inprocess-table').dataTable().fnDestroy();
    var table = $('#phic-inprocess-table').dataTable({
        dom: 'frtip',
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: BASE_URL + "user/fetch_phic_inprocess_patients",
            type: "POST",
            data: {
                datex: datexx, aging: $('#month').text()
            }
        }
    });
    $('#phic-inprocess-table_filter input').unbind();
    $('#phic-inprocess-table_filter input').bind('keyup', function (e) {
        if (e.keyCode === 13) {
            table.fnFilter(this.value);
        }
    });
}