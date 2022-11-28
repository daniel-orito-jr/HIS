
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
            url:  BASE_URL + "user/get_quality",
            data: {s_date:$("#search-quality-form input[name=s_date]").val()},
            dataType: 'json'
        }).done(function(data) {
            if (data.status) {

              console.log('success');
              $('#mbor').text(data.mbor);
              $('#px').text(data.px);
              $('#dd').text(data.dd);
              $('#DOHauthorizedbed').text(data.DOHauthorizedbed);
              $('#MNHIBOR').text(data.MNHIBOR);
              $('#phic').text(data.phic);
              $('#authorizedbed').text(data.authorizedbed);
              $('#dae').text(data.dd);
              $('#alspp').text(data.alspp);
              $('#phicc').text(data.phic);
              $('#dispat').text(data.dispat);
            } else {
                console.log("fail get census");
            }
        });
    },

   


}




