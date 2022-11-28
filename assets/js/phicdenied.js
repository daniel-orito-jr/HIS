$(".report-btn").hide();
var table = $('#in-process-table').DataTable({
    dom: 'frtip',
    responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM'
});


var deniedphic = {
    get_denied : function(){
        $('#denied-table').dataTable().fnDestroy();
        var table = $('#denied-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_phic_denied_accnt",
                type:"POST",
                data: { 
                    start_date : $('#search-denied-form input[name=start_date]').val(), 
                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalpx]").val(json["total"]["px"]).closest('.form-line').addClass('focused');
                $("#total-data input[name=tatolamt]").val('₱' + accounting.format(json["total"]["amount"],2)).closest('.form-line').addClass('focused');
                $(".report-btn").show();
                if(json["total"]["px"] === 0)
                {
                 
                   swal(
                    'NO DENIED',
                    'No denied as of ' + moment(json["total"]["datex"]["date"]).format("MMMM YYYY")+'!\n Try to search another month',
                    'error' 
                    );
                }
            }
        });
        $('#denied-table_filter input').unbind();
        $('#denied-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    search_phic_denied : function(){
        var s_date = $('#search-denied-form input[name = start_date]');
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
            load_phicdenied_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        }
    },
    
    generate_phicdenied_report : function(){
        start_date = $('#search-denied-form input[name=start_date]').val();
        s_data = $('#search-denied-form_filter input').val();
        
        $("#phic-denied-form input[name=s_date]").val(start_date);
//        $("#search-denied-form input[name=search]").val(s_data);
        $("#phic-denied-form").submit();
    }
    

};

function load_phicdenied_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            deniedphic.get_denied();
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}

//$('#return-table').on('dblclick', 'td', function () {
////    alert("asdfasdf");
//    var current_row = $(this).parents('tr');//Get the current row
//    if (current_row.hasClass('child')) {//Check if the current row is a child row
//        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
//    }
//    var data = $('#transmittal-table').dataTable().fnGetData(current_row);
//////    row.css("background","#FF5722");
////
////    $("#dis-purchase-form input[name=control]").val(data[5]);
////    $("#disPurchase").modal("show");
//
//    console.log(data);
//});


$('#denied-table').on('click', 'td', function () {
    
      
          var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#denied-table').dataTable().fnGetData(current_row);
      var datexx = $('#search-denied-form input[name=start_date]').val();
    show_denied(data,datexx);
    $("#phicdenied_modal").modal("show");
    
 
});

function show_denied(data,datexx)
{
  
    
   var monthly = data[0];
   $('#month').html(monthly);
   
   var amt =  data[2];
   $('#totalamount').html(amt);
   
   
     $('#phic-denied-table').dataTable().fnDestroy();
        var table = $('#phic-denied-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_phic_denied_patients",
                type:"POST",
                data: { 
                    datex : datexx,aging: $('#month').text()
                }
            }
        });
        $('#phic-denied-table_filter input').unbind();
        $('#phic-denied-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}



















