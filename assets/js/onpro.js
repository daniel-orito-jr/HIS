$(".report-btn").hide();
var table = $('#onpro-table').DataTable({
    dom: 'frtip',
    responsive: true
});


var phic = {
    get_onpro : function(){
        $('#onpro-table').dataTable().fnDestroy();
        var table = $('#onpro-table').dataTable({
            dom: 'frtip',
//            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            columnDefs: [
            { "visible": false, "targets": 0 }
            ],
            ajax:{  
                url:BASE_URL + "user/fetch_op_phic_accnt",
                type:"POST",
                data: { 
                    start_date : $('#search-onpro-form input[name=start_date]').val(), 
                }
            },
            initComplete : function(settings, json){
                $("#total-data input[name=totalpx]").val(json["total"]["px"]).closest('.form-line').addClass('focused');
                $("#total-data input[name=tatolamt]").val('₱' + accounting.format(json["total"]["amount"],2)).closest('.form-line').addClass('focused');
                $(".report-btn").show();
            }
        });
        $('#onpro-table_filter input').unbind();
        $('#onpro-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    search_phic_disx : function(){
        var s_date = $('#search-onpro-form input[name = start_date]');
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
            load_phic_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        }
    },
    
    generate_dis_report : function(){
        start_date = $('#search-onpro-form input[name=start_date]').val(); 
        s_data = $('#onpro-table_filter input').val();
        
        $("#search-onpro-form input[name=s_date]").val(start_date);
        $("#search-onpro-form input[name=search]").val(s_data);
        $("#search-onpro-form").submit();
    },
    
    generate_onprocess_report : function()
    {
        var start_date = $('#search-onpro-form input[name=start_date]').val(); 
        
        $("#on-pro-form input[name=s_date]").val(start_date);
        $("#on-pro-form").submit();
    },
    
    generate_onprocess_aging_report : function()
    {
        var start_date = $('#search-onpro-form input[name=start_date]').val(); 
     
        $("#on-process-form input[name=s_date]").val(start_date);
        $("#on-process-form input[name=agingx]").val();
//        alert($("#on-process-form input[name=agingx]").val());
        $("#on-process-form").submit();
//        alert("Hello");
    }
};

function load_phic_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            phic.get_onpro();
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}

$('#onpro-table').on('dblclick', 'td', function () {
//    alert("asdfasdf");
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#onpro-table').dataTable().fnGetData(current_row);
////    row.css("background","#FF5722");
//
//    $("#dis-purchase-form input[name=control]").val(data[5]);
//    $("#disPurchase").modal("show");

    console.log(data);
});