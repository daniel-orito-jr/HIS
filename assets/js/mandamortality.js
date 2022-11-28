$('.datex').datetimepicker({
        format: 'YYYY-MM'
});
var mortality = {
    get_mortality : function(){
        start_date = $('#search-mortality-form input[name=start_date]').val(); 
        $("#search-mortality-form input[name=s_date]").val(start_date);
        $('#mortality-census-table').dataTable().fnDestroy();
        $('#mortality-census-table tbody').empty();
        var table = $('#mortality-census-table').dataTable({
            dom: 'frt',
             scrollX:true,
             pageLength:5,
            columnDefs: [ {
                targets:   [1,2],
                width: "15%"
            }],
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_mortality_case",
                type:"POST",
                data: {s_date: $("#search-mortality-form input[name=s_date]").val()},
            },
        });
    
        $('#mortality-census-table_filter input').unbind();
        $('#mortality-census-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value); 
            }
        });
    },

    search_mortality_census : function(){
        var s_date = $('#search-mortality-form input[name = start_date]');
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
            mortality.get_mortality();
       }
    },
    
    
    
    
    }

