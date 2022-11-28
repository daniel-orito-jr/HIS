$(".report-btn").hide();
var table = $('#in-process-table').DataTable({
    dom: 'frtip',
    responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM'
});


var returnphic = {
    get_return : function(){
        $('#return-table').dataTable().fnDestroy();
        var table = $('#return-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_phic_return_accnt",
                type:"POST",
                data: { 
                    start_date : $('#search-return-form input[name=start_date]').val(), 
                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalpx]").val(json["total"]["px"]).closest('.form-line').addClass('focused');
                $("#total-data input[name=tatolamt]").val('₱' + accounting.format(json["total"]["amount"],2)).closest('.form-line').addClass('focused');
                $(".report-btn").show();
                 if(json["total"]["px"] === 0)
                {
                 
                   swal(
                    'NO RETURN',
                    'No return as of ' + moment(json["total"]["datex"]["date"]).format("MMMM YYYY")+'!\n Try to search another month',
                    'error' 
                    );
                }
            }
        });
        $('#return-table_filter input').unbind();
        $('#return-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    search_phic_return : function(){
        var s_date = $('#search-return-form input[name = start_date]');
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
    
    generate_phicreturn_report : function(){
        start_date = $('#search-return-form input[name=start_date]').val();
        
        $("#phic-return-form input[name=s_date]").val(start_date);
        $("#phic-return-form").submit();
    }
    

};

function load_transmittal_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            returnphic.get_return();
            
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


$('#return-table').on('click', 'td', function () {
    
      
          var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#return-table').dataTable().fnGetData(current_row);
      var datexx = $('#search-return-form input[name=start_date]').val();
    show_return(data,datexx);
    $("#phicreturn_modal").modal("show");
    
 
});

function show_return(data,datexx)
{
  
    
   var monthly = data[0];
   $('#month').html(monthly);
   
   var amt =  data[2];
   $('#totalamount').html(amt);
   
   
     $('#phic-return-table').dataTable().fnDestroy();
        var table = $('#phic-return-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_phic_return_patients",
                type:"POST",
                data: { 
                    datex : datexx,aging: $('#month').text()
                }
            }
        });
        $('#phic-return-table_filter input').unbind();
        $('#phic-return-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);	
            }
        });
}



















