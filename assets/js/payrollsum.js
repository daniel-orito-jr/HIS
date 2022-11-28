var payroll = 
{
//    get_payroll_summary : function(){
//        start_date = $('#payroll-summary-form input[name=start_date_payroll]').val(); 
//        end_date   = $('#payroll-summary-form input[name=end_date_payroll]').val(); 
//         
//         
//        $("#payroll-summary-form input[name=s_date_payroll]").val(start_date);
//        $("#payroll-summary-form input[name=e_date_payroll]").val(end_date);
////        alert($("#search-hmo-asofdate-form input[name=s_date]").val());
////        alert(hmolist);
//        $('#payroll-summary-table').dataTable().fnDestroy();
//        var table = $('#payroll-summary-table').dataTable({
//           dom: 'frti',
//            paging:false,
//          pagination: true,
//            processing:true,  
//            serverSide:true, 
//            order:[],  
//            columnDefs: [
//            { "visible": false, "targets": 0 }
//                ],
//            'rowCallback': function(row, data, index){
//                                     $(row).find('td:eq(5)').css('background-color', '#BBDEFB');
//                                     $(row).find('td:eq(11)').css('background-color', '#C5CAE9');
//                                 },
//            "drawCallback": function ( settings ) {
//            var api = this.api();
//            var rows = api.rows({ page: 'current' }).nodes();
//            var last = null;
//           
//            
//            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
//               console.log('group', group);
//            console.log('index', i);
//                if ( last !== group ) {
//                    $(rows).eq( i ).before(
//                            '<tr class="group"><td colspan="12" style=" text-transform: uppercase;background-color:green;color:white;">'+group+'</td><tr>'
//                    );
//                    last = group;
//                }
//              
//                
//     
//        });
//        },
//           
//            ajax:{  
//                url:BASE_URL + "user/fetch_payroll_summary",
//                type:"POST",
//                 data: {start_date: $("#payroll-summary-form input[name=s_date_payroll]").val() ,
//                        end_date: $("#payroll-summary-form input[name=e_date_payroll]").val()
//                    }
////                data: { 
////                    start_date : $('#search-transmittal-form input[name=start_date]').val(), 
////                }
//            },
//            initComplete : function(settings, json){
//                
//                $("#payperiod").text(json["total"]['paysched']);
//                $("#paydays").text(json["total"]['workdays']);
////                alert(json["total"]['paysched']);
////                $("#total-data input[name=totalsales]").val('₱ ' + accounting.format(json["total"]["sales"],2)).closest('.form-line').addClass('focused');
////                $("#total-data input[name=totalending]").val('₱ ' + accounting.format(json["total"]["ending"],2)).closest('.form-line').addClass('focused');
//              $('#payroll-summary-table tbody') // select table tbody
//                .prepend('<tr style="background-color:blue;color:white;"/>') // prepend table row
//                .children('tr:first') // select row we just created
//                .append(' <th style="text-align:right;" colspan="4">TOTAL</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["totalincentives"],2)+'</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["GRS"],2)+'</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["SSSded"],2)+'</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["PHICded"],2)+'</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["HDMFded"],2)+'</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["TAXded"],2)+'</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["ABSENTded"],2)+'</th>'+
//                            '<th style="text-align:right;">'+ accounting.format(json["total"]["Net"],2)+'</th>') // append four table cells to the row we created
////                
//                                               
//            }
//        });
//        $('#payroll-summary-table_filter input').unbind();
//        $('#payroll-summary-table_filter input').bind('keyup', function(e) {
//            if(e.keyCode == 13) {
//                table.fnFilter(this.value);	
//            }
//        });
//    },
get_payroll_summary : function()
    {
        $('#payroll-summary-table').dataTable().fnDestroy();
        $('#payroll-summary-table tbody').empty();
        var table = $('#payroll-summary-table').dataTable
        ({
            dom: 'frtip',
            pageLength: 5,
            processing:true,  
            serverSide:true, 
            order:[],
            
            ajax:
            {  
                url:BASE_URL + "user/fetch_payroll_summary",
                type:"POST"
            },
            
            createdRow : function(row, data, dataIndex)
            {

            },

            initComplete : function()
            {
//                $('[data-toggle="popover"]').click(function()
//                {
//                    $('[data-toggle="popover"]').not(this).popover('hide');
//                });
            }
        });
        $('#payroll-summary-table_filter input').unbind();
        $('#payroll-summary-table_filter input').bind('keyup', function(e) 
        {
            if(e.keyCode == 13) 
            {
                table.fnFilter(this.value);	
            }
        });
    },
    
//    get_payroll_summary_report : function()
//    {
//        var start_date = $('#payroll-summary-form input[name=start_date_payroll]').val(); 
//        var end_date   = $('#payroll-summary-form input[name=end_date_payroll]').val();
//     
//        $("#payroll-form input[name=s_datex]").val(start_date);
//        $("#payroll-form input[name=e_datex]").val(end_date);
//        $("#payroll-form").submit();
//    },

    get_payroll_summary_report : function()
    {
        $("#payroll-summary-form input[name=batchno]").val();
        $("#payroll-summary-form").submit();
    },
    
    view_payroll_details : function(batchno)
    {
        var batch = batchno.split(',');
        
        if(batch[1] === "Yes")
        {
            $('#payroll_funded').attr('hidden',true);
        }
        else
        {
             $('#payroll_funded').removeAttr('hidden',true);
        }
        $('#payrolldetails').modal('show');
        $("#batch").val(batch[0]);
        $("#batchno").val(batch[0]);
        $('#payroll-details-table').dataTable().fnDestroy();
        $('#payroll-details-table tbody').empty();
        
        var table = $('#payroll-details-table').dataTable
        ({
            dom: 'frti',
            paging:false,
            pagination: true,
            processing:true,  
            serverSide:true, 
            
            order:[],  
            columnDefs: [{ "visible": false, "targets": 0 }],
            
            'rowCallback': function(row, data, index)
            {
                $(row).find('td:eq(5)').css('background-color', '#BBDEFB');
                $(row).find('td:eq(11)').css('background-color', '#C5CAE9');
            },
            
            "drawCallback": function ( settings ) 
            {
                var api = this.api();
                var rows = api.rows({ page: 'current' }).nodes();
                var last = null;
                
                api.column(0, {page:'current'} ).data().each( function ( group, i ) 
                {
                    console.log('group', group);
                    console.log('index', i);
                    if ( last !== group ) 
                    {
                        $(rows).eq( i ).before
                        (
                            '<tr class="group"><td colspan="12" style=" text-transform: uppercase;background-color:#00ce68;color:white;">'+group+'</td><tr>'
                        );
                        last = group;
                    }
                });
            },
                
            ajax:
            {  
                url:BASE_URL + "user/fetch_payroll_details",
                type:"POST",
                data:{batchno:batch[0]}
            },
            
            createdRow : function(row, data, dataIndex)
            {

            },

            initComplete : function(settings, json)
            {
                $("#payperiod").val(json["total"]['paysched']);
                $("#paydays").val(json["total"]['workdays']);
                $("#netpay").val('₱ ' +accounting.format(json["total"]["Net"],2));
                $('#netpay').attr('style','text-decoration:underline');
                $('#payroll-details-table tbody')
                
                .prepend('<tr style="background-color:blue;color:white;"/>')
                .children('tr:first')
                .append
                (  
                    '<th style="text-align:right;" colspan="4">TOTAL</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["totalincentives"],2)+'</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["GRS"],2)+'</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["SSSded"],2)+'</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["PHICded"],2)+'</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["HDMFded"],2)+'</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["TAXded"],2)+'</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["ABSENTded"],2)+'</th>'+
                    '<th style="text-align:right;">'+ accounting.format(json["total"]["Net"],2)+'</th>'
                )                         
            }
        });
        
        $('#payroll-details-table_filter input').unbind();
        $('#payroll-details-table_filter input').bind('keyup', function(e) 
        {
            if(e.keyCode == 13) 
            {
                table.fnFilter(this.value);	
            }
        });
    },
}