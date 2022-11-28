
$('.datex').datetimepicker({
        format: 'YYYY-MM'
});

////



var quality = {
    get_mandatory_daily_census_report : function()
    {
        $("#daily-census-form").submit();
    },

    get_mandatory_daily_discharges_report : function()
    {
        $("#daily-discharges-form").submit();
    },

    search_quality_census : function(){
        var s_date = $('#search-quality-form input[name = start_date]');
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
            quality.get_quality_census();
       }
    },

    get_quality_census: function ()
    {
        start_date = $('#search-quality-form input[name=start_date]').val(); 
        $("#search-quality-form input[name=s_date]").val(start_date);


        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/get_newborn",
            data: {s_date:$("#search-quality-form input[name=s_date]").val()},
            dataType: 'json'
        }).done(function(data) {
            if (data.status) {

             $('#newborn-census-table').dataTable().fnDestroy();
               var newborn_census = $('#newborn-census-table').DataTable({
                        
                        dom: 't',});
               newborn_census.clear();
             
                     
                             newborn_census.row.add(
                                        [
                                            '<th><center>TOTAL # OF NEWBORN</center></th>',
                                            data.newborn_census[0]["nhip"],
                                            data.newborn_census[0]["non"],
                                            data.newborn_census[0]["totalx"],
                                  
                                        ] 
                                    ).draw(false);
                                   
                          
            } else {
                console.log("fail get census");
            }
        });
    },

   


}




