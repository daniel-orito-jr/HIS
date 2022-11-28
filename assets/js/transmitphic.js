$(".report-btn").hide();
var table = $('#transmittal-table').DataTable({
    dom: 'frtip',
    responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM'
});


var transmitphic = {
    get_transmittal : function(){
        $('#transmittal-table').dataTable().fnDestroy();
        var table = $('#transmittal-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_transmitphic_accnt",
                type:"POST",
                data: { 
                    start_date : $('#search-transmittal-form input[name=start_date]').val(), 
                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalpx]").val(json["total"]["px"]).closest('.form-line').addClass('focused');
                $("#total-data input[name=tatolamt]").val('₱' + accounting.format(json["total"]["amount"],2)).closest('.form-line').addClass('focused');
                $(".report-btn").show();
            }
        });
        $('#transmittal-table_filter input').unbind();
        $('#transmittal-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    search_phic_transmit : function(){
        var s_date = $('#search-transmittal-form input[name = start_date]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if (error === 0) {
            load_transmittal_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        }
    },
    
    generate_phic_transmittal_report : function(){
        start_date = $('#search-transmittal-form input[name=start_date]').val();
        
        $("#phic-transmittal-form input[name=s_date]").val(start_date);
        $("#phic-transmittal-form").submit();
    },
    
    generate_phic_transmittal_daily_report : function(){
        var start_date = $('#search-transmittal-day-form input[name=start_datex]').val();
        var end_date = $('#search-transmittal-day-form input[name=end_datex]').val();
        
        $("#phic-transmittal-day-form input[name=s_date]").val(start_date);
        $("#phic-transmittal-day-form input[name=e_date]").val(end_date);
        $("#phic-transmittal-day-form").submit();
    }
    

};

function load_transmittal_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            transmitphic.get_transmittal();
            
        })
        .fail(function( jqxhr, settings, exception ) {
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


$('#transmittal-months-table').on('click', 'td', function () {
    
      
          var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#transmittal-months-table').dataTable().fnGetData(current_row);
    show_transmitmonthly(data);
    $("#transmitmonthly").modal("show");
      
 
});

function show_transmitmonthly(data)
{
   var monthly = moment(data[0]).format('MMMM YYYY');
   $('#month').html(monthly);
   
   var amt = '₱'+ accounting.format(data[4],2);
   $('#monthlyamount').html(amt);
   
   
     $('#transmitx-monthly-table').dataTable().fnDestroy();
        var table = $('#transmitx-monthly-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_monthly_transmittal",
                type:"POST",
                data: { 
                    datex : data[0]
                }
            }
        });
        $('#transmitx-monthly-table_filter input').unbind();
        $('#transmitx-monthly-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}

var transmit_day =
        {
    search_phic_transmit_day : function(){
        var s_date = $('#search-transmittal-day-form input[name = start_datex]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if (error === 0) {
            //load_transmittal_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
            
            transmit_day.get_transmitted_patients_day(s_date.val());
        }
    },
    
    get_transmitted_patients_day : function ()
    {
        var sdate = $('#search-transmittal-day-form input[name=start_datex]').val();
        var edate = $('#search-transmittal-day-form input[name=end_datex]').val();
        
        $('#transmittal-day-table').dataTable().fnDestroy();
        var table = $('#transmittal-day-table').dataTable({
            dom: 'frtip',
//            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_transmitted_patients_day",
                type:"POST",
                data: {start_datexxx : sdate, end_datexxx : edate}
            },
            initComplete : function(settings, json){
                $("#totalx input[name=totalpxx]").val(json["recordsTotal"]).closest('.form-line').addClass('focused');
                $("#totalx input[name=tatolamtx]").val('₱' + accounting.format(json["total"]["amount"],2)).closest('.form-line').addClass('focused');
                $(".report-btn").show();
                
                $('#transmittal-day-table tbody') // select table tbody
                .prepend('<tr style="background-color:blue;color:white;"/>') // prepend table row
                .children('tr:first') // select row we just created
                .append(' <th style="text-align:right;" colspan="4">TOTAL</th>'+
                            '<th style="text-align:right;">'+ accounting.format(json["total"]["hosp"],2)+'</th>'+
                            '<th style="text-align:right;">'+ accounting.format(json["total"]["prof"],2)+'</th>'+
                            '<th style="text-align:right;">'+ accounting.format(json["total"]["amount"],2)+'</th>'+
                            '<th></th>'+
                            '<th></th>') // append four table cells to the row we created
            }
        });
        $('#transmittal-day-table_filter input').unbind();
        $('#transmittal-day-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) { table.fnFilter(this.value);}
        });
    }

}
















