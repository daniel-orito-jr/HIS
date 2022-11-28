$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});

var unposted = {
    get_unposted_cheque : function(){
        
        var s_date = $('#search-check-unposted-form input[name=start_date]').val();
        var e_date = $('#search-check-unposted-form input[name=end_date]').val();
    
        
        $('#unposted-cheque-table').dataTable().fnDestroy();
        var table = $('#unposted-cheque-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_unposted_payment",
                type:"POST",
                data: { 
                    start_date : s_date, 
                    end_date : e_date, 
                    status: "check"
                }
            },
            initComplete : function(settings, json){
                $("#total-unposted-check input[name=hosp]").val('₱' + accounting.format(json["total"]["hosp"],2)).closest('.form-line').addClass('focused');
                $("#total-unposted-check input[name=prof]").val('₱' + accounting.format(json["total"]["prof"],2)).closest('.form-line').addClass('focused');
                $("#total-unposted-check input[name=grand]").val('₱' + accounting.format(json["total"]["grand"],2)).closest('.form-line').addClass('focused');
     
            }
        });
        $('#unposted-cheque-table_filter input').unbind();
        $('#unposted-cheque-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    get_unposted_wcheque : function(){
        
        var s_date = $('#search-check-unposted-form input[name=start_date]').val();
        var e_date = $('#search-check-unposted-form input[name=end_date]').val();
    
        
        $('#unposted-wcheque-table').dataTable().fnDestroy();
        var table = $('#unposted-wcheque-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_unposted_payment",
                type:"POST",
                data: { 
                    start_date : s_date, 
                    end_date : e_date, 
                    status: "wcheck"
                }
            },
            initComplete : function(settings, json){
                $("#total-unposted-wcheck input[name=whosp]").val('₱ ' + accounting.format(json["total"]["whosp"],2)).closest('.form-line').addClass('focused');
                $("#total-unposted-wcheck input[name=wprof]").val('₱ ' + accounting.format(json["total"]["wprof"],2)).closest('.form-line').addClass('focused');
                $("#total-unposted-wcheck input[name=wgrand]").val('₱ ' + accounting.format(json["total"]["wgrand"],2)).closest('.form-line').addClass('focused');
            }
        });
        $('#unposted-wcheque-table_filter input').unbind();
        $('#unposted-wcheque-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
   
    
    search_unposted_cheque : function(){
        var start_date = $('#search-check-unposted-form input[name=start_date]');
        var end_date = $('#search-check-unposted-form input[name=end_date]');
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
           
           $('#s_date').val(start_date.val());
           $('#e_date').val(end_date.val());
           $('#ws_date').val(start_date.val());
           $('#we_date').val(end_date.val());
           
            unposted.get_unposted_cheque();
            unposted.get_unposted_wcheque();
        }
    },
    
    generate_unposted_check_report : function()
    {
        $("#total-unposted-check-form").submit();
    },
    generate_unposted_wcheck_report : function()
    {
        $("#total-unposted-wcheck-form").submit();
    }
    

};
