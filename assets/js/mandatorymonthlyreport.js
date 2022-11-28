

$('.datex').datetimepicker({
        format: 'YYYY-MM'
});

var mandamonthly = {


get_common_confinement_causes : function(){



        start_date = $('#search-confinement-causes-form input[name=start_date]').val(); 
//        $("#search-confinement-causes-form input[name=s_date]").val(start_date);


        $('#common_Confinement-causes-table').dataTable().fnDestroy();
        $('#common_Confinement-causes-table tbody').empty();
        var table = $('#common_Confinement-causes-table').dataTable({
            dom: 'frt',
            

            pageLength: 10,
            processing:true,  
            serverSide:true, 
            order:[],
            
            
            ajax:{  
                url:BASE_URL + "user/fetch_common_confinement_causes",
                type:"POST",
                data: {s_date: $("#search-confinement-causes-form input[name=s_date]").val()},
            },
           
            
        });
    
        $('#common_Confinement-causes-table_filter input').unbind();
        $('#common_Confinement-causes-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
    },


       search_manda_report : function(){
        var s_date = $('#search-monthly-report-form input[name = start_date]');
        var error = 0;

        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a month!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }

        if (error === 0) {

            start_date = $('#search-monthly-report-form input[name=start_date]').val(); 
            $("#search-report-form input[name=s_date]").val(start_date);

            $("#search-report-form").submit();
            
            $('#mandamonth').modal('hide');

       }
    },

     get_manda_report: function ()
    {

        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/mandatoryreport_report",
            data: {s_date:$("#search-monthly-report-form input[name=s_date]").val()},
         
        }).done(function(data) {
            if (data.status) {

            console.log('success');
               var url = BASE_URL + "user/mandatoryreport_report"
            window.open(url);
               
            } else {
                console.log("fail get census");
            }
        });
    },    
    
    }