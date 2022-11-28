$(".report-btn").hide();
//var table = $('#in-process-table').DataTable({
//    dom: 'frtip',
//    responsive: true
//});

$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});


var pendingclaims = {
    get_pending_claims : function(){
        
        $('#pending-claims-table').dataTable().fnDestroy();
        var table = $('#pending-claims-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true,
            pageLength:50,
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_pending_claims",
                type:"POST",
            },
            createdRow : function( row, datax, dataIndex){
                    if( datax[5] <= 15)
                    {
                        $(row).css('background-color','#8bc34a');
                    }
                    else if( datax[5] >= 16 && datax[5] <= 30)
                    {
                       $(row).css('background-color','#4caf50'); 
                       $(row).css('color','white'); 
                    }
                    else if( datax[5] >= 31 && datax[5] <= 45)
                    {
                       $(row).css('background-color','#ffc107'); 
                       $(row).css('color','white'); 
                    }
                    else if( datax[5] >= 46 && datax[5] <= 60)
                    {
                       $(row).css('background-color','#ff9800'); 
                       $(row).css('color','white'); 
                    }
                    else
                    {
                        $(row).css('background-color','#ff5722'); 
                        $(row).css('color','white'); 
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
        $('#pending-claims-table_filter input').unbind();
        $('#pending-claims-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
   
   
    
    search_posted_cheque : function(){
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
            posted.get_posted_cheque();
        }
    },
    
    generate_pending_claim_report : function()
    {
        $("#total-pending-claim-form").submit();
    }
    

};
