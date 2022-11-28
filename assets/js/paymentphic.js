$(".report-btn").hide();
var table = $('#transmittal-table').DataTable({
    dom: 'frtip',
    responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM'
});


var paymentphic = {
    get_payment : function(){
        $('#paymentaging-table').dataTable().fnDestroy();
        var table = $('#paymentaging-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_paymentphic_accnt",
                type:"POST",
                data: { 
                    start_date : $('#search-payment-form input[name=start_date]').val(), 
                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalpx]").val(json["total"]["px"]).closest('.form-line').addClass('focused');
                $("#total-data input[name=tatolamt]").val('₱' + accounting.format(json["total"]["amount"],2)).closest('.form-line').addClass('focused');
                $(".report-btn").show();
            }
        });
        $('#paymentaging-table_filter input').unbind();
        $('#paymentaging-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    search_phic_payment : function(){
        var s_date = $('#search-payment-form input[name = start_date]');
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
            load_payment_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        }
    },
    
    generate_dis_report : function(){
        start_date = $('#search-payment-form input[name=start_date]').val(); 
        s_data = $('#search-payment-form_filter input').val();
        
        $("#search-payment-form input[name=s_date]").val(start_date);
        $("#search-payment-form input[name=search]").val(s_data);
        $("#search-payment-form").submit();
    }
};

function load_payment_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            paymentphic.get_payment();
            paymentphic_discharge.get_payment_discharge();
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}

//payment_discharge

var paymentphic_discharge = {
    get_payment_discharge : function(){
        $('#paymentdischarge-table').dataTable().fnDestroy();
        var table = $('#paymentdischarge-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_paymentphic_discharge_accnt",
                type:"POST",
                data: { 
                    start_date : $('#search-payment-form input[name=start_date]').val(), 
                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalpx]").val(json["total"]["px"]).closest('.form-line').addClass('focused');
                $("#total-data input[name=tatolamt]").val('₱' + accounting.format(json["total"]["amount"],2)).closest('.form-line').addClass('focused');
                $(".report-btn").show();
            }
        });
        $('#paymentdischarge-table_filter input').unbind();
        $('#paymentdischarge-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
}