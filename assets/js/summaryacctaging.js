$('.date').datetimepicker({
        format: 'YYYY-MM'
});

var summaryacctaging = 
{
    acctngagingx : function()
    {
        var acctitle = $('#cmbaccttitle').val();
        var coveredmonth = $('#search-arapsummary-form input[name=start_date]').val();
        var zero;
        if($('#showzero').prop('checked')){
            zero = 1;  
        }else{
            zero = 0;  
        }
        if(acctitle !== null)
        {
            $('#tbl-acctaging').removeClass('hidden');
            $('#acctngaging-table').dataTable().fnDestroy();
            $('#acctngaging-table tbody').empty();
            var table = $('#acctngaging-table').dataTable({
                dom: 'frtip',
                pageLength: 10,
                processing:true,  
                serverSide:true, 
                order:[],
                ajax:{  
                    url:BASE_URL + "user/fetch_acctng_summary_aging",
                    type:"POST",
                    data:{coacode:acctitle,coveredmonth:coveredmonth,zero:zero}
                },

                initComplete : function(settings, json)
                {
                    if(json["totalsumm"]["totalrisk"] < 0){
                        $("#txttotalatrisk").attr('style','color:red');
                    }else{
                         $("#txttotalatrisk").attr('style','color:black');
                    }
                    if(json["totalsumm"]["totalcurrent"] < 0){
                        $("#txttotalcurrent").attr('style','color:red');
                    }else{
                         $("#txttotalcurrent").attr('style','color:black');
                    }
                    if(json["totalsumm"]["sum30days"] < 0){
                        $("#txttotal130days").attr('style','color:red');
                    }else{
                         $("#txttotal130days").attr('style','color:black');
                    }
                    if(json["totalsumm"]["sum45days"] < 0){
                        $("#txttotal3145days").attr('style','color:red');
                    }else{
                         $("#txttotal3145days").attr('style','color:black');
                    }
                    if(json["totalsumm"]["sum60days"] < 0){
                        $("#txttotal4660days").attr('style','color:red');
                    }else{
                         $("#txttotal4660days").attr('style','color:black');
                    }
                    if(json["totalsumm"]["sum90days"] < 0){
                        $("#txttotal6190days").attr('style','color:red');
                    }else{
                         $("#txttotal6190days").attr('style','color:black');
                    }
                    if(json["totalsumm"]["sum120days"] < 0){
                        $("#txttotal91120days").attr('style','color:red');
                    }else{
                         $("#txttotal91120days").attr('style','color:black');
                    }
                    if(json["totalsumm"]["sum120daysabove"] < 0){
                        $("#txttotal120daysabove").attr('style','color:red');
                    }else{
                         $("#txttotal120daysabove").attr('style','color:black');
                    }
                    
                    $("#txttotalatrisk").val('₱ ' + accounting.format(json["totalsumm"]["totalrisk"],2));
                    $("#txttotalcurrent").val('₱ ' + accounting.format(json["totalsumm"]["totalcurrent"],2));
                    $("#txttotal130days").val('₱ ' + accounting.format(json["totalsumm"]["sum30days"],2));
                    $("#txttotal3145days").val('₱ ' + accounting.format(json["totalsumm"]["sum45days"],2));
                    $("#txttotal4660days").val('₱ ' + accounting.format(json["totalsumm"]["sum60days"],2));
                    $("#txttotal6190days").val('₱ ' + accounting.format(json["totalsumm"]["sum90days"],2));
                    $("#txttotal91120days").val('₱ ' + accounting.format(json["totalsumm"]["sum120days"],2));
                    $("#txttotal120daysabove").val('₱ ' + accounting.format(json["totalsumm"]["sum120daysabove"],2));
                }

            });
            $('#acctngaging-table_filter input').unbind();
            $('#acctngaging-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        }
//        
    },
    
    grouping : function()
    {
        var groupingx = $('#cmbgrouping').val();
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/argrouping",
            data: {grouping : groupingx},
            dataType: 'json'
            }).done(function(data) {
                console.log(data);
                if (data.status) 
                {
                    $('#cmbaccttitle').empty();
                    for(var i =0; i< data.fetchGroup.length;i++)
                    {
                        if(i == 0)
                        {
                            $('#cmbaccttitle').append('<option value="ALL">ALL</option>').attr("selected","selected");
                            $('#cmbaccttitle').append('<option value="'+data.fetchGroup[i]['coacode']+'">'+data.fetchGroup[i]['accttitle']+'</option>');
                        }
                        else
                        {
                             $('#cmbaccttitle').append('<option value="'+data.fetchGroup[i]['coacode']+'">'+data.fetchGroup[i]['accttitle']+'</option>');
                        }
                       
                    }
                    $("#cmbaccttitle").selectpicker("refresh");
                } 
                else 
                {
                    
                }
        });
    },
    
    checkboxx :function()
    {
        summaryacctaging.acctngagingx();
    }
}