$('.date').datetimepicker({
        format: 'YYYY-MM-DD'
});

$('body').popover({
    selector: '[data-toggle="popover"]'
});

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

var monitor = {
    
    get_chequemonitor : function(){
        $('#cheque-monitoring-table').dataTable().fnDestroy();
        $('#cheque-monitoring-table tbody').empty();
        var table = $('#cheque-monitoring-table').dataTable({
            dom: 'frtip',
             
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
            pageLength: 30,
           
            
            
            
            processing:true,  
            serverSide:true, 
            order:[],
            
            
            ajax:{  
                url:BASE_URL + "user/fetch_chequemonitoring",
                type:"POST"
            },
            
           
        });
    
        $('#cheque-monitoring-table_filter input').unbind();
        $('#cheque-monitoring-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) {
            table.fnFilter(this.value);
            
            }
        });
    },
    
    get_all_cheque : function(){
        $('#cheque-monitor-table').dataTable().fnDestroy();
        $('#cheque-monitor-table tbody').empty();
        var table = $('#cheque-monitor-table').dataTable({
            dom: 'frt',
              language    : { search: "Search (for Date format: Year-month-date)" },
//            responsive: {
//            details: {
//                    type: 'column',
//                    target: -1
//                }
//            },
//            
//            columnDefs: [ {
//                className: 'control',
//                orderable: false,
//                targets:   -1,
//                width: "3%"
//                
//                
//            },
//                
//                {
//                    targets : 5,
//                    visible : false
//                }
//            ],
//       
//            select: {
//                style:    'multi',
//                selector: 'td:first-child'
//            },
//            
            
            
            processing:true,  
            serverSide:true, 
            order:[],
            
            
            ajax:{  
                url:BASE_URL + "user/fetch_all_check",
                type:"POST"
            },
           
           initComplete : function(settings, json){
                
                    $("#chequeAmts").html('(₱ 0.00)');
           
           }
        });
    
        $('#cheque-monitor-table_filter input').unbind();
        $('.dataTables_filter').addClass('pull-left');
        $('#cheque-monitor-table_filter input').bind('keyup', function(e) {
            if(e.keyCode === 13) 
            {
            table.fnFilter(this.value);	
            $('#cheque-monitor-table').removeClass("hidden");
            }
        });
    },
    
    
    get_ticketdetails : function(idx){
        
                            $('#monitorticket').modal("show");
                             
                            $.ajax({
                                type: 'POST',
                                url:  BASE_URL + "user/get_ticketdetailx",
                                data: {ids:idx},
                                dataType: 'json'
                            }).done(function(data1) {
                                console.log(data1);
                                if (data1.status) {
                                    console.log('success');
                                    
                                $('#ticket-details-form input[name=ticketref]').val(data1.ticketdetail["TICKETREF"]);
                                $('#dis-ticket-form input[name=disticketref]').val(data1.ticketdetail["TICKETREF"]);
                                $('#defer-ticket-form input[name=disticketref]').val(data1.ticketdetail["TICKETREF"]);
                                $('#credit-debit-form input[name=ticketcode]').val(data1.ticketdetail["TICKETCODE"]);
                                $('#ticket-details-form input[name=ticketcode]').val(data1.ticketdetail["TICKETCODE"]);
                
                                var ticketdate = moment(data1.ticketdetail["TICKETDATE"]).format('LL');
                                $('#ticket-details-form input[name=ticketdate]').val(ticketdate);
                   
                                var checkamt = accounting.format(data1.ticketdetail["CHEQUEAMT"],2);
                   
                                $('#ticket-details-form input[name=payee]').val(data1.ticketdetail["PAYEE"]);
                                $('#ticket-details-form input[name=checkamt]').val('₱ '+ checkamt);
                                $('#ticket-details-form input[name=checkname]').val(data1.ticketdetail["CHEQUENAME"]);
                                $('#ticket-details-form textarea[name=explanation]').val(data1.ticketdetail["EXPLANATION"]);
                                var prepdate = moment(data1.ticketdetail["PREPDATETIME"]).format('LLL');
                                var checkdate = moment(data1.ticketdetail["CHKDATETIME"]).format('LLL');
            
                                $('#ticket-details-form input[name=prepdatetime]').val(prepdate);
                                $('#ticket-details-form input[name=checkdatetime]').val(checkdate);
                                $('#ticket-details-form input[name=checknote]').val(data1.ticketdetail["note"]);
                            } 
                            else 
                            {
                                console.log('fail');
                            }
                        });
                   
        ///
       
    },
}

$(".report-btn").hide();
/* 
     * 
     * 
$(".report-btn").hide();
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//
//$("#check-all").on("change",function(){
//    var table = $('#cheque-monitoring-table').DataTable();
//    if($(this)[0].checked) {
//        table.rows('#cheque-monitoring-table tbody tr').select();
//        
//    }else{
//        table.rows('#cheque-monitoring-table tbody tr').deselect();
//    }
//    
//    //--------------------------------------------------------sum price
//    var data = table.rows({selected:  true}).data();
//    var totalPrice = 0.0; 
//    for (var i = 0; i < data.length; i++) {
//        totalPrice += parseFloat(trim_money(data[i][2]));
//    }
//    
//    $("#chequeAmt").html('(₱ '+accounting.format(totalPrice,2)+')');
//});
//
//function trim_money(data){
//    var res = data.split(";");
//    return res[1].replace(/,/g,'').trim();
//}
//
//$('#cheque-approval-table').on('click', '.select-checkbox', function () {
//    var current_row = $(this).parents('tr');//Get the current row
//    if (current_row.hasClass('child')) {//Check if the current row is a child row
//        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
//    }
////  
//    var cur_row = $('#cheque-monitoring-table').dataTable().fnGetData(current_row);
//    var totalPrice = 0.0;
//    
//    var data = $('#cheque-monitoring-table').DataTable().rows({selected:  true}).data();
//    
//    if (cur_row != null) {
//        $('#check-all').removeAttr('checked');
//        if (data.length > 0) {
//            for (var i = 0; i < data.length; i++) {
//                totalPrice += parseFloat(trim_money(data[i][2]));
//            }
//            if (current_row.hasClass('selected')) {
//                totalPrice -= parseFloat(trim_money(cur_row[2]));
//            }else{
//                totalPrice += parseFloat(trim_money(cur_row[2]));
//            }
//        }else{
//            totalPrice += parseFloat(trim_money(cur_row[2]));
//        }
//        $("#chequeAmt").html('(₱ '+accounting.format(totalPrice,2)+')');
//    }
//});
//
//

$('#cheque-monitor-table').on( 'draw.dt', function () {
    var wwww = $('#cheque-monitor-table').DataTable();
 
                    var data = wwww
                        .rows()
                        .data();
                
                if (data.length != 0) {
                    var total = 0.0;
                    for (var i = 0; i < data.length; i++) {
                        var res = data[i][1].split(";");
                        total += parseFloat(res[1].replace(/,/g,'').trim());
                    }
                    $("#chequeAmts").removeClass("hidden");
                    $("#chequeAmts").html('(₱ '+accounting.format(total,2)+')');
                    
                  
                }

                

} );

//$('#cheque-monitor-table').on('search.dt', function() {
//    var wwww = $('#cheque-monitor-table').DataTable();
//    //number of filtered rows
//    console.log(wwww.rows( { filter : 'applied'} ).nodes().length);
//    //filtered rows data as arrays
//    console.log(wwww.rows( { filter : 'applied'} ).data());                                  
//})  