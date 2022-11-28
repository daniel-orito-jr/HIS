var c = $('#daily-census-table').dataTable({
    dom : 't',
    order: [[ 0, "asc" ]],
    pageLength:30
    
});
var d = $('#census-of-the-day-table').dataTable({
    dom : 't',
    order: [[ 0, "asc" ]],
    pageLength:30

});

$('.date').datetimepicker({
        format: 'YYYY-MM'
});

////



var mandadaily = {
    get_mandatory_daily_census_report : function()
    {
         start_date = $('#search-daily-form input[name=start_date]').val(); 

        $("#daily-census-form input[name=s_date]").val(start_date);
        $("#daily-census-form").submit();
    },

    get_mandatory_daily_discharges_report : function()
    {  
        start_date = $('#search-daily-form input[name=start_date]').val(); 

        $("#daily-discharges-form input[name=s_date]").val(start_date);

        $("#daily-discharges-form").submit();
    },

    search_daily_census : function(){
        var s_date = $('#search-daily-form input[name = start_date]');
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
            mandadaily.get_daily_census();
            mandadaily.get_daily_discharges();
       }
    },

    get_daily_census: function ()
    {
        start_date = $('#search-daily-form input[name=start_date]').val(); 
        $("#search-daily-form input[name=s_date]").val(start_date);

        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_census_month",
            data: {s_date:$("#search-daily-form input[name=s_date]").val()},
            dataType: 'json'
        }).done(function(data) {
            if (data.status) {

               $('#daily-census-table').dataTable().fnDestroy();
               var daily_census = $('#daily-census-table').DataTable({
                        
                        dom: 'frt',
                        pageLength:35,});
               daily_census.clear();
             
                     if(data.census_month.length > 0)
                     {
                         for (var i = 0; i < data.census_month.length; i++) {
                         
                             daily_census.row.add(
                                        [
                                            data.census_month[i]["datex"],
                                            data.census_month[i]["nhip"],
                                            data.census_month[i]["non"],
                                            data.census_month[i]["totalx"],
                                  
                                        ] 
                                    ).draw(false);
                                   
                            }
                             daily_census.row.add(
                                        [
                                            ' <td>TOTAL</td>',
                                            data.phic,
                                            data.non,
                                            data.pat,
                                        ]  
                                    ).draw(false);
                    }else
                    {
                        $('#daily-census-table').dataTable().fnDestroy();
                        var daily_census = $('#daily-census-table').DataTable();
                        daily_census.clear();
                    }
            } else {
                console.log("fail get census");
            }
        });
    },

    get_daily_discharges: function ()
    {
        start_date = $('#search-daily-form input[name=start_date]').val(); 
        $("#search-daily-form input[name=s_date]").val(start_date);

        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_discharges_month",
            data: {s_date:$("#search-daily-form input[name=s_date]").val()},
            dataType: 'json'
        }).done(function(data) {
            if (data.status) {

               $('#discharges-month-table').dataTable().fnDestroy();
               var discharges_monthx = $('#discharges-month-table').DataTable({
                        
                        dom: 'frt',
                        pageLength:35,});
               discharges_monthx.clear();
             
                     if(data.discharges_month.length > 0)
                     {
                         for (var i = 0; i < data.discharges_month.length; i++) {
                         
                             discharges_monthx.row.add(
                                        [
                                            data.discharges_month[i]["datex"],
                                            data.discharges_month[i]["nhip"],
                                            data.discharges_month[i]["non"],
                                            data.discharges_month[i]["totalx"],
                                  
                                        ] 
                                    ).draw(false);
                                   
                            }
                             discharges_monthx.row.add(
                                        [
                                            ' <td>TOTAL</td>',
                                            data.disphic,
                                            data.disnon,
                                            data.dispat,
                                        ]  
                                    ).draw(false);
                    }else
                    {
                        $('#discharges-month-table').dataTable().fnDestroy();
                        var discharges_monthx = $('#discharges-month-table').DataTable();
                        discharges_monthx.clear();
                    }
            } else {
                console.log("fail get census");
            }
        });
    },

    load_records : function(type){
    
        
        switch(parseInt(type)){
            case 0:
                var  start = $('#search-daily-form input[name = start_date]').val();
                
                 mandadaily.get_daily_census();
                
                $('#search-daily-form input[name = s_date]').val(start);  
                break;
            
            default:
                break;
        }

 
    }
}


function load_script(scriptUrl,type,subType)
{
    $.getScript(scriptUrl)
        .done(function( script, textStatus ) {
            console.log( textStatus );
            switch(parseInt(subType)){
                case 0:
                    mandadaily.load_records(type);
                    break;
                default:
                    break;
            }
            
        })
        .fail(function( jqxhr, settings, exception ) {
         console.log("fail to load script");
    });
}

