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

$('.date').datetimepicker({
        format: 'YYYY-MM'
});

var purchase = {
    
    monthpick : function()
    {
         var s_date = $('#search-frequency-form input[name = monthdate]');
        var error = 0;
        
        if (s_date.val() == "") {
            s_date.parents('.form-line').removeClass('error success').addClass('error');
            s_date.parents('.input-group').find('small').text('Please select a date!');
            error++;
        }else{
            s_date.parents('.form-line').removeClass('error success').addClass('success');
            s_date.parents('.input-group').find('small').text('');
        }
      
        
        if (error === 0) {

        code = $('#search-frequency-form input[name=barcode]').val();
        purchase.show_ledger(code,s_date);
           
        }
    },
    
    detailspick : function()
    {
        var s_date = $('#search-details-form input[name = month]');
        var error = 0;
        
        if (s_date.val() == "") {
           s_datex = "All";
        }else{
           s_datex = $('#search-details-form input[name = month]').val();
        }

        code = $('#search-frequency-form input[name=barcode]').val();
        purchase.show_ledger(code,s_datex);
    },
    
    get_forapproval : function(){
        $('#purchases-table').dataTable().fnDestroy();
        $('#purchases-table tbody').empty();
        var table = $('#purchases-table').dataTable({
            dom: 'frtip',
            responsive: {
            details: {
                    type: 'column',
                    target: -1
                }
            },
            pageLength: 30,
            columnDefs: [ {
                className: 'control',
                orderable: false,
                targets:   -1,
                width: "3%"
            },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
                },
                {
                    targets : [7],
                    visible : false
                }
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true,  
            serverSide:true, 
            order:[],
            ajax:{  
                url:BASE_URL + "user/fetch_purchases/fapproval",
                type:"POST"
            },
            initComplete : function(){
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
            }
            
        });
        $('#purchases-table_filter input').unbind();
        $('#purchases-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    
    get_approved : function(){
        $('#approved-table').dataTable().fnDestroy();
        $('#approved-table tbody').empty();
        var table = $('#approved-table').dataTable({
            dom: 'frtip',
            responsive: true,
            processing:true,  
            serverSide:true, 
            order:[], 
            pageLength: 30,
            columnDefs: [
                {
                    targets: [6],
                    visible: false
                }
            ],  
            ajax:{  
                url:BASE_URL + "user/fetch_purchases/approved",
                type:"POST"
            }
            
        });
        $('#approved-table_filter input').unbind();
        $('#approved-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
            table.fnFilter(this.value);	
            }
        });
    },
    approve_p : function(data){
        $('#purchases-table').dataTable().fnDestroy();
        $('#purchases-table tbody').empty();
        var table = $('#purchases-table').dataTable({
            dom: 'frtip',
            responsive: {
            details: {
                    type: 'column',
                    target: -1
                }
            },
            pageLength: 30,
            columnDefs: [ {
                className: 'control',
                orderable: false,
                targets:   -1,
                width: "3%"
            },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    width: "3%"
                },
                {
                    targets : 6,
                    visible : false
                }
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            processing:true,  
            serverSide:true, 
            order:[],    
            ajax:{  
                url:BASE_URL + "user/app_purchase/fapproval",
                data: {controls : data},
                type:"POST"
            },
            initComplete: function(settings, json) {
                $('[data-toggle="popover"]').click(function(){
                    $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                });
                swal("Success","Purchase approved!","success");
            }
            
        });
        $('#purchases-table_filter input').unbind();
        $('#purchases-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    show_ledger : function(barcode,s_datex){
        
        $('#search-frequency-form input[name=barcode]').val(barcode);
        
        $('#ledger-table').dataTable().fnDestroy();
        $('#ledger-table tbody').empty();
        var table = $('#ledger-table').dataTable({
            dom: 'frtip',
            responsive: true,
            pageLength: 30,
            processing:true,  
            serverSide:true, 
            order:[],    
            ajax:{  
                url:BASE_URL + "user/fetch_ledger",
                data: {bcode : barcode,
                    month: $('#search-frequency-form input[name=monthdate]').val(),
                    s_datexx: s_datex},
                type:"POST"
            },
            initComplete: function(settings, json) {
                $("#ledgerSale").modal("show");
                
                for(i=1;i<7;i++)
                {
                    
                    $("#month"+i).text(json['total']['month'+i]);
                    if(json['total']['frequency'][i-1]['qty'] === null)
                    {
                      $("#qty"+i).text('0');
                    }
                    else
                    {
                        $("#qty"+i).text(parseInt(json['total']['frequency'][i-1]['qty']));
                    }
                    //$("#qty"+i).text(parseInt(json['total']['frequency'][i-1]['qty']));
                }
                
//                $("#month1").text(json['total']['month1']);
//                $("#month2").text(json['total']['month2']);
//                $("#total-data input[name=totalpf]").val('₱ ' + accounting.format(json["total"]["pfhmo"],2)).closest('.form-line').addClass('focused');
            }
            
        });
        $('#ledger-table_filter input').unbind();
        $('#ledger-table_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.fnFilter(this.value);	
            }
        });
    },
    
    disapprove_p : function(){
        var ctrl = [];
        var data = $('#purchases-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][7]);
        }
        
        swal({
            title: "Disapprove Purchase?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#F44336",
            confirmButtonText: "Yes, disapprove it!",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function () {
            $('#purchases-table').dataTable().fnDestroy();
            $('#purchases-table tbody').empty();
            var table = $('#purchases-table').dataTable({
                dom: 'frtip',
                responsive: {
                details: {
                        type: 'column',
                        target: -1
                    }
                },
                pageLength: 30,
                columnDefs: [ 
                    {
                        className: 'control',
                        orderable: false,
                        targets:   -1,
                        width: "3%"
                    },
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0,
                        width: "3%"
                    },
                    {
                        targets : 6,
                        visible : false
                    }
                ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                processing:true,  
                serverSide:true, 
                order:[],   
                ajax:{  
                    url:BASE_URL + "user/dis_purchase/fapproval",
                    type:"POST",
                    data: {controls : ctrl, b: $("#dis-purchase-form textarea[name=note]").val()}
                },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $("#disPurchase").modal("hide");
                    swal("Sucess","Purchase disapproved!","success");
                }

            });
            $('#purchases-table_filter input').unbind();
            $('#purchases-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
    
    deffer : function(){
        var ctrl = [];
        var data = $('#purchases-table').DataTable().rows({selected:  true}).data();
        for (var i = 0; i <data.length; i++) {
            ctrl.push(data[i][7]);
        }
        
        swal({
            title: "Deffer Purchase?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#F44336",
            confirmButtonText: "Yes, deffer it!",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function () {
            $('#purchases-table').dataTable().fnDestroy();
            $('#purchases-table tbody').empty();
            var table = $('#purchases-table').dataTable({
                dom: 'frtip',
                responsive: {
                details: {
                        type: 'column',
                        target: -1
                    }
                },
                pageLength: 30,
                columnDefs: [ {
                    className: 'control',
                    orderable: false,
                    targets:   -1,
                    width: "3%"
                },
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0,
                        width: "3%"
                    },
                    {
                        targets : 6,
                        visible : false
                    }
                ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                processing:true,  
                serverSide:true, 
                order:[],  
                ajax:{  
                    url:BASE_URL + "user/def_purchase/fapproval",
                    type:"POST",
                    data: {controls : ctrl, b: $("#def-purchase-form textarea[name=note]").val()}
                },
                initComplete: function(settings, json) {
                    $('[data-toggle="popover"]').click(function(){
                        $('[data-toggle="popover"]').not(this).popover('hide'); //all but this
                    });
                    $("#defPurchase").modal("hide");
                    swal("Sucess","Purchase deffered!","success");
                }

            });
            $('#purchases-table_filter input').unbind();
            $('#purchases-table_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                table.fnFilter(this.value);	
                }
            });
        });
    },
    
    get_selected_app : function()
    {
        if ($('#purchases-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select purchase/s for approval.",
                type: "warning"
            });
        }else{
            var ctrl = [];
            var data = $('#purchases-table').DataTable().rows({selected:  true}).data();
            for (var i = 0; i <data.length; i++) {
                ctrl.push(data[i][7]);
            
            }
        
            
            swal({
            title: "Approve Purchase?",
            text: "You cannot undo this action!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4CAF50",
            confirmButtonText: "Yes, approve it!",
            cancelButtonText: "No",
            closeOnConfirm: false
            }, function () {
                purchase.approve_p(ctrl);
            });
        }
    },
    
    get_selected_dis : function(){
        if ($('#purchases-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select purchase/s for disapproval.",
                type: "warning"
            });
        }else{
            $("#disPurchase").modal("show");
        }
    },
    
    get_selected_def : function(){
        if ($('#purchases-table').DataTable().rows({selected:  true}).data().length == 0) {
            swal({
                title: "Oops!",
                text: "Please select purchase/s for defferal.",
                type: "warning"
            });
        }else{
            $("#defPurchase").modal("show");
        }
    },
    
    newquantity : function()
    {
        var newqty = $('#change-quantity-form input[name=newqty]').val();
        var id = $('#change-quantity-form input[name=idx]').val();
        var old = $('#aqty').text();
        var descr = $('#itemname').text();
        
       
        $.ajax({
        type: 'POST',
        url:  BASE_URL + "user/changeqty",
        data: {newqtyx:newqty, idx:id, oldqty:old, item:descr },
        dataType: 'json'
        }).done(function(data1) {
            console.log(data1);
            if (data1.status) {
                console.log('success');
                swal(
                    'Success',
                    'Quantity successfully updated!',
                    'success' 
                    );            
            } 
            else 
            {
                swal(
                    'Unsuccessful',
                    'Quantity is NOT successfully updated!',
                    'error' 
                    );        
                
            }
            });
            purchase.get_forapproval();
            $('#changepurqty').modal('hide');
    }
    
    
    
};

$('#purchases-table').on('click', '.btn-dis-purchase', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#purchases-table').dataTable().fnGetData(current_row);
//    row.css("background","#FF5722");

    $("#dis-purchase-form input[name=control]").val(data[5]);
    $("#disPurchase").modal("show");
});


$('#purchases-table').on('click', '.btn-def-purchase', function () {
     var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data = $('#purchases-table').dataTable().fnGetData(current_row);
//    alert("cancel");

    $("#def-purchase-form input[name=control]").val(data[5]);
    $("#defPurchase").modal("show");
});

$('#purchases-table').on('click', '.ledger-btn', function () {
    purchase.show_ledger($(this).attr("id"));
    
});

$("#checkall2").click(function() { // a button with checkall2 as its id
    var table = $('#purchases-table').DataTable();
    table.rows('#purchases-table tbody tr').select();
    
    
//alert("asdfasdfasdf");
});

$("#check-all").on("change",function(){
    var table = $('#purchases-table').DataTable();
    if($(this)[0].checked) {
        table.rows('#purchases-table tbody tr').select();
        
    }else{
        table.rows('#purchases-table tbody tr').deselect();
    }
    
    //--------------------------------------------------------sum price
    var data = table.rows({selected:  true}).data();
    var totalPrice = 0.0; 
    for (var i = 0; i < data.length; i++) {
        totalPrice += parseFloat(trim_money(data[i][5]));
    }
    
    $("#purHeader").html('(₱ '+accounting.format(totalPrice,2)+')');
});

function trim_money(data){
    var res = data.split(";");
    return res[1].replace(/,/g,'').trim();
}

$('#purchases-table').on('click', 'td', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    
    var cur_row = $('#purchases-table').dataTable().fnGetData(current_row);
    
    
    
});

$('#purchases-table').on('click', '.select-checkbox', function () {
    var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    
    var cur_row = $('#purchases-table').dataTable().fnGetData(current_row);
    var totalPrice = 0.0;
    
    var data = $('#purchases-table').DataTable().rows({selected:  true}).data();
    
    if (cur_row != null) {
        $('#check-all').removeAttr('checked');
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                totalPrice += parseFloat(trim_money(data[i][5]));
            }
            if (current_row.hasClass('selected')) {
                totalPrice -= parseFloat(trim_money(cur_row[5]));
            }else{
                totalPrice += parseFloat(trim_money(cur_row[5]));
            }
        }else{
            totalPrice += parseFloat(trim_money(cur_row[5]));
        }
        $("#purHeader").html('(₱ '+accounting.format(totalPrice,2)+')');
    }
});

$('#purchases-table').on( 'draw.dt', function () {
    $("#purHeader").html('(₱ 0.00)');
    $('#check-all').removeAttr('checked');
} );

function editquantity (control)
{
  var cc = control.split('@');
  var dscr = cc[0];
  var id = cc[1];
  var qty = cc[2];
//  alert(qty);
  $('#changepurqty').modal('show');
  $('#itemname').html(dscr);
  $('#change-quantity-form input[name=idx]').val(id);
  $('#aqty').html(qty);
}
