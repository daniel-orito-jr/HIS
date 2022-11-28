$(".report-btn").hide();
//var table = $('#in-process-table').DataTable({
//    dom: 'frtip',
//    responsive: true
//});

$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});


var historylog = {
    get_history_log : function(){
        
        $('#history-log-table').dataTable().fnDestroy();
        var table = $('#history-log-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true,
            pageLength:30,
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_history_log",
                type:"POST",
            },
            createdRow : function( row, datax, dataIndex){
                    if( datax[6] !==  "")
                    {
                        $(row).css('background-color','#B7F6A6');
                    }
                    else
                    {
                       $(row).css('background-color','#CDD5CB'); 
                    }
                    
                    
            },
            initComplete : function(settings, json){
//                $("#total-posted-check-stat input[name=posthosppaid]").val('₱ ' + accounting.format(json["total"]["posthosppaid"],2)).closest('.form-line').addClass('focused');
//                $("#total-posted-check-stat input[name=postprofpaid]").val('₱ ' + accounting.format(json["total"]["postprofpaid"],2)).closest('.form-line').addClass('focused');
//                $("#total-posted-check-stat input[name=postgrandpaid]").val('₱ ' + accounting.format(json["total"]["postgrandpaid"],2)).closest('.form-line').addClass('focused');
//                $("#total-posted-check-stat input[name=posthospunpaid]").val('₱ ' + accounting.format(json["total"]["posthospunpaid"],2)).closest('.form-line').addClass('focused');
//                $("#total-posted-check-stat input[name=postprofunpaid]").val('₱ ' + accounting.format(json["total"]["postprofunpaid"],2)).closest('.form-line').addClass('focused');
//                $("#total-posted-check-stat input[name=postgrandunpaid]").val('₱ ' + accounting.format(json["total"]["postgrandunpaid"],2)).closest('.form-line').addClass('focused');
//                
//                $("#total-unposted-check-stat input[name=unposthosppaid]").val('₱ ' + accounting.format(json["total"]["unposthosppaid"],2)).closest('.form-line').addClass('focused');
//                $("#total-unposted-check-stat input[name=unpostprofpaid]").val('₱ ' + accounting.format(json["total"]["unpostprofpaid"],2)).closest('.form-line').addClass('focused');
//                $("#total-unposted-check-stat input[name=unpostgrandpaid]").val('₱ ' + accounting.format(json["total"]["unpostgrandpaid"],2)).closest('.form-line').addClass('focused');
               
     
     
            }
        });
        $('#history-log-table_filter input').unbind();
        $('#history-log-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    generate_history_log_report : function()
    {
        $("#total-history-log-form").submit();
    }
    

};
