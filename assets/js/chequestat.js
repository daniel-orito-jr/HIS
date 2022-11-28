$(".report-btn").hide();
//var table = $('#in-process-table').DataTable({
//    dom: 'frtip',
//    responsive: true
//});

$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});


var chequestat = {
    get_cheque_stat : function(){
        
        var s_date = $('#search-check-posted-form input[name=start_date]').val();
        var e_date = $('#search-check-posted-form input[name=end_date]').val();

        
        $('#cheque-stat-table').dataTable().fnDestroy();
        var table = $('#cheque-stat-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_cheque_status",
                type:"POST",
                data: { 
                    start_date : s_date, 
                    end_date : e_date
                }
            },
            createdRow : function( row, datax, dataIndex){
                    if( datax[11] ===  "POSTED")
                    {
                        $(row).css('background-color','#B7F6A6');
                    }
                    else
                    {
                       $(row).css('background-color','#CDD5CB'); 
                    }
                    
                    
            },
            initComplete : function(settings, json){
                $("#total-posted-check-stat input[name=posthosppaid]").val('₱ ' + accounting.format(json["total"]["posthosppaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check-stat input[name=postprofpaid]").val('₱ ' + accounting.format(json["total"]["postprofpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check-stat input[name=postgrandpaid]").val('₱ ' + accounting.format(json["total"]["postgrandpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check-stat input[name=posthospunpaid]").val('₱ ' + accounting.format(json["total"]["posthospunpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check-stat input[name=postprofunpaid]").val('₱ ' + accounting.format(json["total"]["postprofunpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check-stat input[name=postgrandunpaid]").val('₱ ' + accounting.format(json["total"]["postgrandunpaid"],2)).closest('.form-line').addClass('focused');
                
                $("#total-unposted-check-stat input[name=unposthosppaid]").val('₱ ' + accounting.format(json["total"]["unposthosppaid"],2)).closest('.form-line').addClass('focused');
                $("#total-unposted-check-stat input[name=unpostprofpaid]").val('₱ ' + accounting.format(json["total"]["unpostprofpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-unposted-check-stat input[name=unpostgrandpaid]").val('₱ ' + accounting.format(json["total"]["unpostgrandpaid"],2)).closest('.form-line').addClass('focused');
               
     
     
            }
        });
        $('#cheque-stat-table_filter input').unbind();
        $('#cheque-stat-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
   
   
    
    search_cheque_stat : function(){
        var start_date = $('#search-check-posted-form input[name=start_date]');
        var end_date = $('#search-check-posted-form input[name=end_date]');
        var error = 0;
        
        if (start_date.val() == "") {
            start_date.parents('.form-line').removeClass('error success').addClass('error');
            start_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            start_date.parents('.form-line').removeClass('error success').addClass('success');
            start_date.parents('.input-group').find('small').text('');
        }
        
        if (end_date.val() == "") {
            end_date.parents('.form-line').removeClass('error success').addClass('error');
            end_date.parents('.input-group').find('small').text('Please select an end date!');
            error++;
        }else{
            end_date.parents('.form-line').removeClass('error success').addClass('success');
            end_date.parents('.input-group').find('small').text('');
        }
        
       
       if (error === 0) {
            $('#total-cheque-date-form input[name=s_date]').val(start_date.val());
            $('#total-cheque-date-form input[name=e_date]').val(end_date.val());
            chequestat.get_cheque_stat();
        }
    },
    
    generate_cheque_stat_report : function()
    {
        $("#total-cheque-date-form").submit();
    }
    

};
