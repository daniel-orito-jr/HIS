$(".report-btn").hide();
var table = $('#dis-phic-table').DataTable({
    dom: 'frtip',
    responsive: true
});

$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});

var phic = {
    get_phic_dis : function(){
        $('#dis-phic-table').dataTable().fnDestroy();
        var table = $('#dis-phic-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[],  
            ajax:{  
                url:BASE_URL + "user/fetch_phic_dis",
                type:"POST",
                data: { 
                    start_date : $('#search-phic-dis-form input[name=start_date]').val(), 
                    end_date : $('#search-phic-dis-form input[name=end_date]').val()
                }
            },
            initComplete : function(){
                $(".report-btn").show();
            }
        });
        $('#dis-phic-table_filter input').unbind();
        $('#dis-phic-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    search_phic_dis : function(){
        var s_date = $('#search-phic-dis-form input[name = start_date]');
        var e_date = $('#search-phic-dis-form input[name = end_date]');
        var error = 0;
        
//        alert(s_date.val());
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a start date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
        
        if (e_date.val() == "") {
            e_date.parents('.form-line').removeClass('error success').addClass('error');
            e_date.parents('.input-group').find('small').text('Please select an end date!');
            error++;
        }else{
            e_date.parents('.form-line').removeClass('error success').addClass('success');
            e_date.parents('.input-group').find('small').text('');
        }
        
        if (error === 0) {
            load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        }
    },
    
    generate_dis_report : function(){
        start_date = $('#search-phic-dis-form input[name=start_date]').val(); 
        end_date = $('#search-phic-dis-form input[name=end_date]').val();
        s_data = $('#dis-phic-table_filter input').val();
        
        $("#dis-phic-form input[name=s_date]").val(start_date);
        $("#dis-phic-form input[name=e_date]").val(end_date);
        $("#dis-phic-form input[name=search]").val(s_data);
        $("#dis-phic-form").submit();
    }
};

function load_script(scriptUrl)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
//            console.log( textStatus );
            phic.get_phic_dis();
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}


















