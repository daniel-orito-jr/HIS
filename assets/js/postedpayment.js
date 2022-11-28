$(".report-btn").hide();
//var table = $('#in-process-table').DataTable({
//    dom: 'frtip',
//    responsive: true
//});

$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});


var posted = {
    get_posted_cheque : function(){
        
        var s_date = $('#search-check-posted-form input[name=start_date]').val();
        var e_date = $('#search-check-posted-form input[name=end_date]').val();

        
        $('#posted-check-table').dataTable().fnDestroy();
        var table = $('#posted-check-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_posted_payment",
                type:"POST",
                data: { 
                    start_date : s_date, 
                    end_date : e_date
                }
            },
            initComplete : function(settings, json){
                $("#total-posted-check input[name=hosppaid]").val('₱ ' + accounting.format(json["total"]["hosppaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check input[name=profpaid]").val('₱ ' + accounting.format(json["total"]["profpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check input[name=grandpaid]").val('₱ ' + accounting.format(json["total"]["grandpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check input[name=hospunpaid]").val('₱ ' + accounting.format(json["total"]["hospunpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check input[name=profunpaid]").val('₱ ' + accounting.format(json["total"]["profunpaid"],2)).closest('.form-line').addClass('focused');
                $("#total-posted-check input[name=grandunpaid]").val('₱ ' + accounting.format(json["total"]["grandunpaid"],2)).closest('.form-line').addClass('focused');
     
     
            }
        });
        $('#posted-check-table_filter input').unbind();
        $('#posted-check-table_filter input').bind('keyup', function(e) {
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
           $('#total-posted-check-form input[name=s_date]').val(start_date.val());
           $('#total-posted-check-form input[name=e_date]').val(end_date.val());
            posted.get_posted_cheque();
        }
    },
    
    generate_posted_payment_report : function()
    {
        alert($("#total-posted-check-form input[name=s_date]").val());
        $("#total-posted-check-form").submit();
    }
    

};